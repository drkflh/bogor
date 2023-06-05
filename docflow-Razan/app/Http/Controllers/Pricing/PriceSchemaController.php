<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Pricing;

use App\Helpers\AuthUtil;
use App\Helpers\Injector;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Cars\CarType;
use App\Models\Core\Mongo\User;
use App\Models\Pricing\PriceCategory;
use App\Models\Pricing\PriceCriteria;
use App\Models\Pricing\PriceService;
use App\Models\Pricing\PriceUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PriceSchemaController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/pricing/priceschema';
        $this->yml_file = 'fields';

        $this->entity = 'Price Unit';
        $this->title = 'Price Schema';

        // this must be set to use ACL
        $this->auth_entity = 'price-schema';

        // set controller path
        $this->controller_base = 'price/schema';

        // set view base to include standard slot
        $this->view_base = 'pricing.priceschema';

        $this->model = new PriceUnit();
    }

    public function getIndex()
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';

        $this->template_var = [ 'hasSideNav'=>false ];

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'pricing.priceschema.formlayout';

        $this->table_grouped = true;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'pricing.priceschema.formlayout';
        $this->form_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        /* parameters for simple table modal with template
        * example :
         * model name = simpleTableTemplate
         *
        */
        $uiOptions = [];

        $criteriaRules = Injector::setModel( PriceCriteria::orderBy('criteriaName') ) // gunakan model sebagai input, set query disini
                ->toModelArray() // akan running query dan menghasilkan array object
                ->toOptions('criteriaName', 'criteriaKey', true)
                ->getArray();

        // use injector to provide parameter for simpletablemodaltemplate / simpletable
        $uiOptions = Injector::setObject('criteriaRule') // name variable / field yang akan diinject
                ->setObjFields( // mwnambahkan setting field untuk table
                    [
                        [ 'label'=>'Criteria Var', 'key'=>'criteriaName'],
                        [ 'label'=>'Operator', 'key'=>'operator', 'class'=>'text-100'],
                        [ 'label'=>'Value', 'key'=>'value'],
                        [ 'label'=>'Type', 'key'=>'type', 'class'=>'text-100'],
                    ]
                )->setObjDef( // set object default
                    [
                        'criteriaName'=>'',
                        'value'=>'',
                        'operator'=>'',
                        'type'=>'string',
                        'remark'=>''
                    ]
                )->setObjParams( // set parameter
                    [
                        'criteriaNames'=> $criteriaRules  ,
                        'operator'=> config( 'app.params.notationOperator' ),
                        'types'=> config( 'app.params.varType' )
                    ]
                )
                ->setObjTemplate(file_get_contents( resource_path('views/pricing/priceschema/criteria.html') )) // set template
                ->injectObject($uiOptions); // inject into uiOption array

        // use injector to provide options for simpleselect / localselect
        $uiOptions = Injector::setModel( PriceCategory::orderBy('priceCategoryCode') ) // gunakan model sebagai input, set query disini
            ->toModelArray() // akan running query dan menghasilkan array object
            ->toOptions('priceCategoryName', 'priceCategoryCode', true) // jadikan option untuk select
            ->injectOption('priceCategoryCode', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        // use injector to provide options for simpleselect / localselect
        $uiOptions = Injector::setModel( PriceService::orderBy('priceCategoryCode') ) // gunakan model sebagai input, set query disini
            ->toModelArray() // akan running query dan menghasilkan array object
            ->toOptions('priceServiceName', 'priceServiceCode', true) // jadikan option untuk select
            ->injectOption('priceServiceCode', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge($uiOptions,$formOptions) ;

        $this->update_title_fields = 'this.priceCategoryCode + " "+ this.priceUnitCode + " "+ this.priceUnitName';
        $this->view_title_fields = 'this.priceCategoryCode + " "+ this.priceUnitCode + " "+ this.priceUnitName';

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        //$this->defOrderField = 'IODate';
        //$this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $this->def_param['defaultQty'] = 1;
        $this->def_param['active'] = 'yes';
        $this->def_param['priceUnitCurrency'] = 'IDR';

        return parent::getParam(); // TODO: Change the autogenerated stub
    }


    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        $model = $model->orderBy('displaySeq', 'asc');
        return $model;
    }

    public function externalData($data, $request)
    {
        $temp = [];

        for($i = 0; $i < count($data); $i++ ){
            $label = $data[$i]['priceCategoryCode'];
            $temp[ $label ][] = $data[$i];
        }

        $out = [];
        foreach($temp as $k=>$v){
            $out[] = [
                'label'=>$k,
                'mode'=>'span',
                'children'=>$v
            ];
        }
        return $out;
    }


}
