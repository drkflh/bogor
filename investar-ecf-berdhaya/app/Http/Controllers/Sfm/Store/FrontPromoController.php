<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Sfm\Store;

use App\Helpers\App\SfmUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\PublicController;
use App\Models\Sfm\Product\Promo;
use App\Models\Reference\Product;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Helpers\RefUtil;
use App\Helpers\NumberUtil;
use Illuminate\Support\Str;

class FrontPromoController extends PublicController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/sfm/store';

        $this->yml_file = 'frontpromo_controller';

        $this->entity = 'Promo';

        $this->auth_entity = 'front-promo';

        $this->controller_base = 'promo';

        $this->view_base = 'sfm.product.frontpromo';

        $this->model = new Promo();
    }

    public function getIndex()
    {
        $this->title = __('Promo');

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.product.frontpromo.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'sfm.product.frontpromo.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.name + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.name + "</h4>"';

        $this->page_refresh_button = true;

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'sfm.product.frontpromo.product_item';

        $this->grid_card_layout = 'card-columns';

        //$this->grid_card_class = 'w-25';
        $this->bootstrap_version = 5;

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Promo');

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.product.frontpromo.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'sfm.product.frontpromo.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.name + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.name + "</h4>"';

        $this->page_refresh_button = true;

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'sfm.product.frontpromo.product_item';

        $this->grid_card_layout = 'card-columns';

        //$this->grid_card_class = 'w-25';
        $this->bootstrap_version = 5;

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }


    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.product.frontpromo.form_layout';

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

        $this->title = __('Edit').' '.$item->name;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.product.frontpromo.form_layout';

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
        // $item = Promo::where('slug', $id)->first();

        $item = $this->model->find($id);

        $this->item_id = $id;

        $this->title = ' ';

        $this->show_title = false;

        // $this->code = $item->promoCode;
        // $item = new Promo;

        // $this->post->name = $request->name;

        // $this->post->slug = Str::slug($item->, '-');

        /* Use custom form layout */
        $this->viewer_view = 'form.viewhtml'; // use plain html
        $this->viewer_layout = 'sfm.product.frontpromo.view_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('page');

        $this->viewer_can_print = false;

        $this->page_redirect_after_save = true;

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
