<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Ecf\NoOfBranches;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoOfBranchesController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf';

        $this->yml_file = 'noofbranches_controller';

        $this->entity = 'Jumlah Cabang';

        $this->auth_entity = 'ecf-noofbranches';

        $this->controller_base = 'ecf/noofbranches';

        $this->view_base = 'ecf.noofbranches';

        $this->title_fields = 'name';

        $this->model = new NoOfBranches();
    }

    public function getIndex()
    {
        $this->extra_query = [
            'name'=>'',
            'description'=>'',
            'seq'=>'',
        ]; 

        $this->title = 'Jumlah Cabang';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.noofbranches.form_layout';
        $this->form_dialog_size = 'md';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.noofbranches.view_layout';
        $this->viewer_dialog_size = 'md';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;

        $this->add_filler = true;

        return parent::getIndex();
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $this->with_advanced_search = false;
        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        return parent::setupFormOptions($formOptions, $data); 
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.noofbranches.form_layout';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('Edit').' '.$item->_id;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.noofbranches.form_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function postClone(Request $request)
    {
        $this->revision_key = 'requestNo';
        return parent::postClone($request);
    }

    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'Item';
//        $this->defOrderDir = 'asc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    // public function additionalQuery($model, Request $request)
    // {
    //     /* sample query modifier */
    //     //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
    //     return $model;
    // }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;
        if( $adv && $ext &&  (isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){

            if( isset($ext['name']) && $ext['name'] != '' ){
                $name = explode(',', $ext['name'] );

                $model = $model->where(function($q) use ( $name) {
                    for($i = 0; $i < count($name); $i++){
                        if($i == 0){
                            $q = $q->where('name','like','%'.$name[$i].'%');
                        }else{
                            $q = $q->orWhere('name','like','%'.$name[$i].'%');
                        }
                    }
                });
            }

            if( isset($ext['description']) && $ext['description'] != '' ){
                $description = explode(',', $ext['description'] );

                $model = $model->where(function($q) use ( $description) {
                    for($i = 0; $i < count($description); $i++){
                        if($i == 0){
                            $q = $q->where('description','like','%'.$description[$i].'%');
                        }else{
                            $q = $q->orWhere('description','like','%'.$description[$i].'%');
                        }
                    }
                });
            }

            if( isset($ext['seq']) && $ext['seq'] != '' ){
                $seq = explode(',', $ext['seq'] );

                $model = $model->where(function($q) use ( $seq) {
                    for($i = 0; $i < count($seq); $i++){
                        if($i == 0){
                            $q = $q->where('seq','like','%'.$seq[$i].'%');
                        }else{
                            $q = $q->orWhere('seq','like','%'.$seq[$i].'%');
                        }
                    }
                });
            }
        }

        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}