<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Store;

use App\Helpers\App\EcfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\PublicController;
use App\Models\Core\Mongo\User;
use App\Models\Inventory\InventoryItem;
use App\Models\Reference\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class HomeController extends PublicController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf/product';

        $this->yml_file = 'catalog_controller';

        $this->entity = 'Product';

        $this->auth_entity = 'Product';

        $this->controller_base = 'home';

        $this->view_base = 'ecf.product.store';

//        $this->model = new Product();
        $this->model = new InventoryItem();

    }


    public function getIndex()
    {
         // $this->test = 'test';
        $this->title = __('Featured Products');

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        // /**
        // * Set form layout
        // */
        // $this->form_view = 'form.html';
        $this->form_view = 'form.html';// use plain html
        $this->form_layout = 'ecf.product.catalog.form_layout';

        $this->form_dialog_size = 'xl';
        //ini sementara karena belum ketemu isi param schedule
        // $schedule = Http::get('https://api.banghasan.com/sholat/format/json/jadwal/kota/742/tanggal/2022-07-25')->json()['jadwal']['data'];
        // print_r($schedule);
        // echo implode(" ",$schedule);
        // $hasil = '';
        // foreach ($schedule as $out) {
//             Array ( [ashar] => 14:53 [dhuha] => 06:03 [dzuhur] => 11:33 [imsak] => 04:08 [isya] => 18:37 [maghrib] => 17:24 [subuh] => 04:18 [tanggal] => Senin 25 Jul 2022 [terbit] => 05:35 )//
//            $hasil .= 'Jadwal Shalat Hari ' . $schedule['tanggal'] . ' Ashar ' . $schedule['ashar'] . ' Dhuha ' . $schedule['dhuha'] . ' Dzuhur ' . $schedule['dzuhur'] . ' Isya ' . $schedule['isya'] . ' Maghrib ' . $schedule['maghrib'] . ' Subuh ' . $schedule['subuh'];
        // }
        // $hasil = implode("&",array_map(function($a) {return implode("~",$a);},$schedule));
        // //   implode("&",array_map(function($a) {return implode("~",$a);},$array));
        // echo $hasil;

        // $this->form_dialog_size = $hasil;


        // /**
        // * Set Viewer layout
        // */
        $this->viewer_layout = 'ecf.product.catalog.view_layout';
        // $this->viewer_layout = 'ecf.store.checkout.view_layout';
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

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'ecf.product.catalog.product_item';

        $this->table_per_page = 5;

        $this->grid_card_layout = 'card-columns';

        // $this->grid_card_class = 'w-25';
        $this->bootstrap_version = 5;
        $this->schedule = "test";

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
        $this->form_layout = 'ecf.product.catalog.form_layout';
        $this->form_dialog_size = 'xl';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'ecf.product.catalog.view_layout';
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

        $this->table_component = 'grid-view';

        $this->grid_item_view = 'ecf.product.catalog.product_item';

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
        $formOptions['unitOptions'] = EcfUtil::toOptions(EcfUtil::getUnits(),'uom','uom', true);
        $formOptions['categoryOptions'] = EcfUtil::toOptions(EcfUtil::getCategories(),['category'],'categoryCode', true);
        $formOptions['currencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(), 'name','name', true);

        $formOptions['cartObject'] = "{}";
        $formOptions['cartSubTotal'] = 0;
        $formOptions['cartQty'] = 1;
        $formOptions['cartPrice'] = 0;
        $formOptions['cartNote'] = "''";

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.product.catalog.form_layout';

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
        $this->form_layout = 'ecf.product.catalog.form_layout';

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

        $this->title = $item->productName;

        /* Use custom form layout */
        $this->viewer_view = 'form.viewhtml'; // use plain html
        $this->viewer_layout = 'ecf.product.catalog.view_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('view');

        $this->viewer_can_print = true;

        $this->page_redirect_after_save = true;


        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getPromo()
    {
            $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');

                return view( 'ecf.promo.promo_layout' )
                    ->with('title', __('Promo'))
                    ->with('layout', $default_layout);
    }

    public function getPromoView()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');
        $layout = env('LOGIN_LAYOUT', $default_layout );
        $view = env('REGISTER_SUCCESS_VIEW', 'auth.select_promo_view' );

                return view( $view )
                    ->with('title', __('Promo'))
                    ->with('layout', $layout);
    }

    public function getAboutUs()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');

                return view( 'ecf.company.about-us' )
                    ->with('title', __('About Us'))
                    ->with('layout', $default_layout);
    }
    public function getPrivacyPolicy()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');

                return view( 'ecf.company.privacy-policy' )
                    ->with('title', __('Privacy Policy'))
                    ->with('layout', $default_layout);
    }

    public function getContactUs()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');

                return view( 'ecf.company.contact-us' )
                    ->with('title', __('Contact Us'))
                    ->with('layout', $default_layout);
    }
    public function getSupportCenter()
    {
        $default_layout =  env('DEFAULT_LAYOUT', 'layouts.dojek3');

                return view( 'ecf.company.support-center' )
                    ->with('title', __('Support Center'))
                    ->with('layout', $default_layout);
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
        $search = $request->get('search');
        if ($search != NULL)
        {
            $model = $model->where('productName', "like", "%". $search ."%" );
        }

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
            ->where('productName', 'LIKE', '%' .$search . '%')
            ->get();

        return parent::getList($data);
    }

}
