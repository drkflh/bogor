<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Ecf;

use App\Helpers\App\EcfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\PublicController;
use App\Models\Core\Mongo\User;
use App\Models\Ecf\Campaign;
// use App\Models\Inventory\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class EtalaseController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf';

        $this->yml_file = 'etalase_controller';

        $this->entity = 'Etalase';

        $this->auth_entity = 'etalase';

        $this->controller_base = 'ecf/etalase';

        $this->view_base = 'ecf.etalase';

        $this->model = new Campaign();
    }

    public function getIndex()
    {

        $this->title = __('Featured Campaign');

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        // /**
        // * Set form layout
        // */
        // $this->form_view = 'form.html';
        $this->form_view = 'form.html';// use plain html
        $this->form_layout = 'ecf.etalase.form_layout';

        $this->form_dialog_size = 'xl';

        // /**
        // * Set Viewer layout
        // */
        $this->viewer_layout = 'ecf.etalase.view_layout';
        // $this->viewer_layout = 'sfm.store.checkout.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.bizRegisteredName + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.bizRegisteredName + "</h4>"';

        $this->page_refresh_button = true;

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'ecf.etalase.product_card';

        $this->table_per_page = 6;

        $this->grid_card_layout = 'card-columns';

        $this->layout = 'layouts.nobleui_h';

        // $this->grid_card_class = 'w-25';
        $this->bootstrap_version = 4;
        if( $this->layout == 'layouts.nobleui_h'){
            $this->bootstrap_version = 5;
        }
        // $this->schedule = "test";


        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        // $this->title = __('Product Catalog');
        $this->title = __('Hasil pencarian:' . $search);

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
         * Set form layout
         */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.etalase.form_layout';
        $this->form_dialog_size = 'xl';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'ecf.etalase.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.bizRegisteredName + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.bizRegisteredName + "</h4>"';

        $this->page_refresh_button = true;

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'ecf.etalase.product_item';

        $this->grid_card_layout = 'card-columns';

        //$this->grid_card_class = 'w-25';
        $this->bootstrap_version = 5;

        // $schedule = Http::get('https://api.banghasan.com/sholat/format/json/jadwal/kota/742/tanggal/'.date("Y-m-d"))->json()['jadwal']['data'];
        // $this->schedule = "test";

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        // $formOptionsPrencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(), 'name','name', true);

        $formOptions['cartObject'] = "{}";
        $formOptions['cartSubTotal'] = 0;
        $formOptions['cartQty'] = 1;
        $formOptions['cartPrice'] = 0;
        $formOptions['cartNote'] = "''";
        $formOptions['campaignId'] = "''";


        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.etalase.form_layout';

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

        $this->title = __('Edit').' '.$item->bizRegisteredName;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.etalase.form_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_redirect_after_save = true;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {

        $item = $this->model->find($id);

        $this->item_id = $id;

        // $this->title = $item->bizRegisteredName;
        $this->title = $item->campaignTitle;

        /* Use custom form layout */
        $this->viewer_view = 'form.html'; // use plain html
        $this->viewer_layout = 'ecf.etalase.view_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->viewer_can_print = false;

        $this->page_redirect_after_save = true;


        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }
    public function getViewForm($id)
    {
        $this->res_path = 'models/controllers/ecf';

        $this->yml_file = 'etalase_controller';

        $this->title = ' ';

        $this->show_title = false;

        $this->item_data_url = 'ecf/invoice/data';

        $this->item_id = $id;

        $this->form_view = 'form.htmlpage';

        $this->form_type = 'html';

        $this->form_layout = 'ecf.etalase.campaign_detail';

        $this->can_autosave = false;

        $this->can_lock = true;

        $this->can_add = false;

        $this->page_refresh_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        // $population = [];

        // $population['orderID'] = 'test';

        return parent::formGenerator();
    }

    public function postClone(Request $request)
    {
        $this->revision_key = 'requestNo';
        return parent::postClone($request);
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $model = $model->where('campaignStatus', '=', 'VERIFIED' );
        // $search = $request->get('search');
        // if ($search != NULL)
        // {
        //     $model = $model->where('bizRegisteredName', "like", "%". $search ."%" );
        // }

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

    public function getSearch(Request $request){

        $search = $request->get('search');

        // Search in the title and body columns from the posts table
        $data = Product::query()
            ->where('bizRegisteredName', 'LIKE', '%' .$search . '%')
            ->get();

        return parent::getList($data);
    }

}
