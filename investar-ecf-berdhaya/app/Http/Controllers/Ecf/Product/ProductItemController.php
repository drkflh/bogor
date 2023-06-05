<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Product;

use App\Helpers\App\EcfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Reference\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductItemController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf/product';

        $this->yml_file = 'product_controller';

        $this->entity = 'Product';

        $this->auth_entity = 'ecf-product-product-item';

        $this->controller_base = 'ecf/product/product-list';

        $this->view_base = 'ecf.product.product';

        $this->model = new Product();
    }

    public function getIndex()
    {
        $this->title = 'Product Catalog';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        $this->nav_file = 'nav';
        $this->nav_path = 'views/partials/app/ecf';
        $this->template_var = [ 'hasSideNav'=>true ];
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.product.product.form_layout';
        $this->form_dialog_size = 'xl';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.product.product.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.productName + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.productName + "</h4>"';

        $this->page_refresh_button = true;

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $this->title = 'Product Catalog';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.product.product.form_layout';
        $this->form_dialog_size = 'xl';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.product.product.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Edit')." ".'" + this.productName + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('View')." ".'" + this.productName + "</h4>"';

        $this->add_filler = false;

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['unitOptions'] = EcfUtil::toOptions(EcfUtil::getUnits(),'uom','uom', true);
        $formOptions['categoryOptions'] = EcfUtil::toOptions(EcfUtil::getCategories(),['category'],'categoryCode', true);
        $formOptions['currencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(), 'name','name', true);

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.product.product.form_layout';

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

        $this->title = __('Edit').' '.$item->productName;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.product.product.form_layout';

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

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        $data['level'] ='TOPANG';
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {
        $data['level'] ='TOPANG';
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

}