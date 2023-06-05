<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Obj;

use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Obj\CompDev;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ComponentController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/obj/component';
        $this->yml_file = 'fields';

        $this->model = new CompDev();
    }

    public function getIndex()
    {
        $this->title = 'Component';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'obj';
        $this->res_path = 'views/obj/component';
        $this->yml_file = 'fields';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        $this->nav_file = env('APP_NAV_FILE');
        $this->nav_path = env('APP_NAV_PATH');

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'obj/component';

        $this->add_url = 'obj/component/add';

        $this->update_url = 'obj/component/edit';

        $this->del_url = 'obj/component/del';

        $this->item_data_url = 'obj/component/data';

        $this->clone_url = 'obj/component/clone';

        $this->param_url = 'obj/component/param';

        $this->del_url = 'obj/component/del';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'obj/component/commit';

        $this->logo = env('APP_LOGO');

        /* Use custom form layout */
        $this->form_view = 'form.flatgrid';
        //$this->table_slot_view = 'obj.component.tableslot';

        $ltcolumns = Util::loadResYaml( 'lt',$res_path )->toColFields(false);

        $uiOptions = [
            'loadableFormSchema'=>Util::templateJson('key', 'load-form-schema' ),
            'loadableFormOptions'=>[
                'validateAfterLoad'=> false,
                'validateAfterChanged'=> true,
                'validateAsync'=> true
            ],
            'livetableColumns'=>$ltcolumns

        ];

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->grid = [
            ['col'=>[3,9]],
            ['col'=>[3,3,6]],
        ];

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    /* Custom form sample route method
     * requires manual route setting
     * */
    public function getDev(){

        $this->nav_section = 'obj';
        $this->res_path = 'views/obj/component';
        $this->yml_file = 'fields';
        $this->logo = env('APP_LOGO');

        $this->nav_file = env('APP_NAV_FILE');
        $this->nav_path = env('APP_NAV_PATH');

        /* Injected model data, merged with vue data model as well
         * */

        $this->title = 'Component Dev';

        /* Merge injected data with with vue data model as well
        `* data with the same var name / index will be overriden by injected data
         * */
        $imageNote = url(Storage::disk('local')->url('images/default_1024.jpg'));

        $this->data['imageNote'] = Util::makeDataModel( 'imageNote', $imageNote, 'text', 'text', $imageNote );

        $this->data['sortablelist'] = Util::makeDataModel( 'sortablelist', $imageNote, 'array', 'array', $imageNote );

        $this->form_view = 'form.flatgridpage';

        $activeFormTemplate = file_get_contents( resource_path('views/obj/component/activeform.html') );

        $activeFormDefaultObject = ['description'=>''];

        $imageArray = [
        'https://cdn1-production-images-kly.akamaized.net/P85Ddv6JF2FbVJeoCgCelmhtt4U=/640x360/smart/filters:quality(75):strip_icc():format(jpeg)/kly-media-production/medias/1439641/original/042027300_1482131661-reddit.jpg',
        'https://cdn.idntimes.com/content-images/duniaku/post/20191202/aaaabyqp33z3d9ugjk0izsyfvenqpsz4zosrjb8v5ccl4utifde7z-yovhiedfhjtgm2rh4lolejfhwhdyrdmtezwqojkdxh-4a0234ded14168ec564c25ddab155e65.jpg',
        'https://dvdshoppekanbaru.files.wordpress.com/2014/05/01710-narutoepisode006-mkv_001099140.jpg',
        'https://calonbos.com/wp-content/uploads/2020/01/8d281e89561f0de6474b7f5e1845d9c5.jpg',
        'https://kyouid-storage.sgp1.digitaloceanspaces.com/items/52445-pvc-figure-uzumaki-naruto-sage-mode-vibration-stars-17cm.jpg'
        ];

        /* parameters for invoice items
        * example :
         * model name = simpleTableTemplate
         *
        */
        $invoiceItemsObjDef = [
            'itemname'=>'',
            'uom'=>'unit',
            'qty'=>1,
            'description'=>'',
            'currency'=>'IDR',
            'unitPrice'=>0,
            'unitTotal'=>0
        ];
        $invoiceItemsFields = [
            [ 'label'=>'Description', 'key'=>'itemname'],
            [ 'label'=>'Curr', 'key'=>'currency'],
            [ 'label'=>'Price', 'key'=>'unitPrice'],
            [ 'label'=>'Unit', 'key'=>'uom'],
        ];

        $invoiceItemsTemplate = '`'.file_get_contents( resource_path('views/obj/component/invoice_form_template.html') ).'`';

        $invoiceItemsContent = '``';
        $invoiceItemsParams = [
            'uom'=>[
                ['text'=>'unit', 'value'=>'unit'],
                ['text'=>'gr', 'value'=>'gr'],
                ['text'=>'kg', 'value'=>'kg'],
                ['text'=>'lusin', 'value'=>'lusin'],
                ['text'=>'koli', 'value'=>'koli'],
            ],
            'currency'=>[
                ['text'=>'IDR', 'value'=>'IDR'],
                ['text'=>'USD', 'value'=>'USD']
            ]
        ];




        /* parameters for simple table modal with template
        * example :
         * model name = simpleTableTemplate
         *
        */
        $simpleTableTemplateObjDef = [
            'name'=>'',
            'age'=>10,
            'address'=>'',
            'jenis'=>''
        ];
        $simpleTableTemplateFields = [
            [ 'label'=>'Name', 'key'=>'name'],
            [ 'label'=>'Age', 'key'=>'age'],
            [ 'label'=>'Address', 'key'=>'address'],
        ];

        $simpleTableTemplateTemplate = '`'.file_get_contents( resource_path('views/obj/component/form_template.html') ).'`';

        $simpleTableTemplateContent = '``';
        $simpleTableTemplateParams = [
            'jenis'=>[
                ['text'=>'LOGMAR', 'value'=>'LOGMAR'],
                ['text'=>'NCT', 'value'=>'NCT'],
                ['text'=>'Refraksi Lengkap', 'value'=>'Refraksi Lengkap'],
                ['text'=>'Tidak Perlu Refraksi', 'value'=>'Tidak Perlu Refraksi'],
                ['text'=>'Visus Kasar', 'value'=>'Visus Kasar'],
            ],
        ];

        $sortableListItemTemplate = '`'.file_get_contents( resource_path('views/obj/component/item_template.html') ).'`';

        $ltcolumns = Util::loadResYaml( 'lt', $this->res_path )->toColFields(false);

        debug($ltcolumns);

        $uiOptions = [
            'loadableFormSchema'=>Util::templateJson('key', 'load-form-schema' ),
            'loadableFormOptions'=>[
                'validateAfterLoad'=> false,
                'validateAfterChanged'=> true,
                'validateAsync'=> true
            ],
            'activeFormTemplate'=>"`".$activeFormTemplate."`",
            'activeFormDefaultObject'=>$activeFormDefaultObject,
            'listExample' => Util::templateJson('key', 'coordinate-list'),
            'imageArray' => $imageArray,
            'simpleTableTemplateObjDef'=>$simpleTableTemplateObjDef,
            'simpleTableTemplateFields'=>$simpleTableTemplateFields,
            'simpleTableTemplateTemplate'=>$simpleTableTemplateTemplate,
            'simpleTableTemplateContent'=>$simpleTableTemplateContent,
            'simpleTableTemplateParams'=>$simpleTableTemplateParams,

            'invoiceItemsObjDef'=>$invoiceItemsObjDef,
            'invoiceItemsFields'=>$invoiceItemsFields,
            'invoiceItemsTemplate'=>$invoiceItemsTemplate,
            'invoiceItemsContent'=>$invoiceItemsContent,
            'invoiceItemsParams'=>$invoiceItemsParams,
            'sortableListItemTemplate'=>$sortableListItemTemplate,
            'livetabledataColumns'=>$ltcolumns

        ];

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->handle = Str::random(12);

        $this->grid = [
            ['col'=>[3,9]],
            ['col'=>[3,4,5]],
            ['col'=>[7,5]],
            ['col'=>[12]],
        ];

        $this->can_autosave = true;

        $this->data_url = 'obj/component';

        $this->add_url = 'obj/component/add';

        $this->update_url = 'obj/component/edit';

        $this->autosave_url = 'obj/component/autosave';

        $this->del_url = 'obj/component/del';

        $this->item_data_url = 'obj/component/data';

        $this->param_url = 'obj/component/param';

        $this->can_add = true;


        return parent::formGenerator();
    }

}
