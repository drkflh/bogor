<?php

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Sfm;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Sfm\ShoppingCart;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\RefUtil;
use App\Helpers\App\SfmUtil;

class ShoppingCartController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/sfm';

        $this->yml_file = 'shoppingcart_controller';

        $this->entity = 'Shopping Cart';

        $this->auth_entity = 'sfm-shopping-cart';

        $this->controller_base = 'sfm/shopping-cart';

        $this->view_base = 'sfm.shoppingcart';

        $this->model = new ShoppingCart();

        $this->upsert_mode = true;
    }

    public function getIndex()
    {
        $this->title = 'Shopping Cart';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
         * Set form layout
         */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.shoppingcart.form_layout';
        $this->form_dialog_size = 'xl   ';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'sfm.shoppingcart.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->update_title_fields = '"<h4>'.__('Ubah')." Row ".'" + this.productCode + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('Lihat')." Row ".'" + this.productCode + "</h4>"';
        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->add_filler = false;

        return parent::getIndex();
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['unitOptions'] = SfmUtil::toOptions(SfmUtil::getUnits(),'uom','uom', true);
        $formOptions['categoryOptions'] = SfmUtil::toOptions(SfmUtil::getCategories(),['category'],'categoryCode', true);
        $formOptions['currencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(), 'name','name', true);
        $formOptions['orderStatusOptions'] = [
            ['text' => 'OPEN', 'value' => 'OPEN'],
            ['text' => 'CLOSED', 'value' => 'CLOSED'],
        ];
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add') . ' ' . $this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.shoppingcart.form_layout';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge($uiOptions, $formOptions);

        $this->page_redirect_after_save = false;

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('Edit') . ' ' . $item->_id;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.shoppingcart.form_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge($uiOptions, $formOptions);

        $this->page_redirect_after_save = false;

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

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function getModel($data, $model)
    {
        $tmodel = $this->model;
        $newmodel = $tmodel->where('cartSession', '=', (Auth::user()->cartSession ?? 'nosession') )
            ->where('productName', '=', $data['productName'])
            ->first();

        if($newmodel){
            $data['orderQty'] += $newmodel->orderQty ?? 0 ;
//            $data['orderSubTotal'] += $newmodel->orderSubTotal ?? 0 ;
            $data['orderSubTotal'] = $data['orderQty'] * $data['orderPrice'];
//            $data['orderPrice'] = $newmodel->orderPrice ?? 0 ;
//            $data['orderNote'] = $newmodel->orderNote ?? '' ;
            $model = $newmodel;
        }

        return parent::getModel($data, $model); // TODO: Change the autogenerated stub
    }


    public function beforeSave($data)
    {

        $data['userName'] = Auth::user()->name;
        $data['userLocation'] = Auth::user()->kabupaten ?? '';

        $data['orderTimestamp'] = Carbon::now( env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'))->unix();
        $data['orderTime'] = Carbon::now( env('DEFAULT_TIME_ZONE', 'Asia/Jakarta'));

        $data['cartSession'] = Auth::user()->cartSession ?? null;
        $berat = $data['weight'];  
        $data['weight'] = $berat * $data['orderQty'];

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

    public function getActiveCart(){

        $cartSession = Auth::user()->cartSession ?? 'noSession';

        $cart = $this->model->where('cartSession', '=', $cartSession)
            ->orderBy('orderTimestamp', 'desc')
            ->get();

        $cartdata = [];
        $carttotal = $this->model->where('cartSession', '=', $cartSession)->sum('orderSubTotal');
        $carttotalqty = $this->model->where('cartSession', '=', $cartSession)->sum('orderQty');
        $carttotalweight = $this->model->where('cartSession', '=', $cartSession)->sum('weight');

        if($cart){
            $cartdata = $cart->toArray();
        }

        return response()->json([
            'result'=>'OK',
            'msg'=>'All OK',
            'data'=>[
                'cart'=>$cartdata,
                'totalBill'=>$carttotal,
                'totalQty'=>$carttotalqty,
                'totalWeight'=>$carttotalweight
            ]
        ], 200);


    }

}
