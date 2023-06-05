<?php

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Sfm\Store;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\NumberUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\PublicController;
use App\Models\Sfm\ShoppingCart;
use App\Models\Sfm\Store\ShoppingCartAttribute;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Helpers\RefUtil;
use App\Helpers\App\SfmUtil;

class CheckOutController extends PublicController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/sfm/store';

        $this->yml_file = 'checkout_controller';

        $this->entity = 'Item';

        $this->auth_entity = 'checkout';

        $this->controller_base = 'check-out';

        $this->view_base = 'sfm.store.checkout';

        $this->model = new ShoppingCart();

        $this->upsert_mode = true;
    }

    public function getIndex()
    {
        $this->title = '';
        return parent::getIndex();
    }
    public function getShopping($id = null){

        if(!\Illuminate\Support\Facades\Auth::check()){
            return redirect( env('AUTH_REDIRECT_TO','login'));
        }

        $this->model2 = new ShoppingCartAttribute();

        $cartSession = Auth::user()->cartSession;
        $fullname = Auth::user()->fullname;
        // $result = $this->model2::where('cartSession','=',$cartSession)
        // ->updateOrInsert(
        //     ['status' => 'Checkout test'],
        //     ['cartSession' => $cartSession]
        // );

        $result = $this->model2::where('cartSession','=',$cartSession)->count();

        if($result <= 0){
            $this->model2->created_at = Carbon::now();
            $this->model2->cartSession = $cartSession;
            $this->model2->status = "Checkout";
            $this->model2->buyer = $fullname;
            $this->model2->fname = "";
            $this->model2->lname = "";
            $this->model2->billing_address = "";
            $this->model2->billing_address2 = "";
            $this->model2->city = "";
            $this->model2->zipcode = "";
            $this->model2->mobile = "";
            $this->model2->email = "";
            $this->model2->add_info = "";
            $this->model2->delivery_option = "";
            $this->model2->payment_option = "";
            $this->model2->save();
   
        }else{
            $this->model2->where("cartSession","=", $cartSession)->update(["status" => "Checkout", "updated_at" => Carbon::now()]);
        }

        $this->res_path = 'models/controllers/sfm/store';
        $this->yml_file = 'checkout_controller';

        $this->nav_file = 'nav';

        $this->title = ' ';

        $this->show_title = false;

        $this->item_data_url = 'sfm/checkout/data';

        $this->item_id = 1;

        $this->has_tab = false;

        $this->form_mode = 'edit';

        $this->form_view = 'form.htmlpage';

        $this->form_type = 'html';

        $this->form_layout = 'sfm.checkout.form_layout';

        $this->can_autosave = false;

        $this->can_lock = true;

        $this->can_add = false;

        $this->page_refresh_button = true;

        // $this->page_additional_view = 'sfm.admin.dashboard.toolbar';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        // $formOptions['companyName'] = "''";

        // // $defaultRange = [
        // //         Carbon::now()->startOfYear()->toDateString(),
        // //         Carbon::now()->endOfYear()->toDateString(),
        // //     ];

        // // $this->extra_query = [
        // //     'fromDate'=>$defaultRange,
        // //     'untilDate'=>'',
        // // ];

        $this->aux_data = $formOptions;

        return parent::formGenerator();
    }
    public function getData($id, $additional_data = null)
    {
        Util::ajaxDebug();
        $request = Request::capture();

        $cartSession = Auth::user()->cartSession;

        // $dateRange = $request->get('extraData')['fromDate'];

        // $date = Carbon::now()->year;
        // $yy = Carbon::now()->isoFormat('YY');
        // $year = Carbon::now()->isoFormat('YYYY');
        // $date = JobRegister::select('inquiryDate')->first();
        // $year = Carbon::parse($date->inquiryDate)->year;
        // dd($date);date("d M Y", strtotime('inquiryDate'))

        $population = [];
        $population['total'] = ShoppingCart::select('orderSubTotal')->where('cartSession','=',$cartSession)->sum('orderSubTotal');
        $population['currency'] = ShoppingCart::select('currency')->where('cartSession','=',$cartSession)->first();
        $population['subTotal'] = NumberUtil::currency(ShoppingCart::select('price')->where('cartSession','=',$cartSession)->sum('orderSubTotal'));
        // $population['subTotal'] = NumberUtil::decimal($population('subTotal'));
        $population['totalShopping'] = ShoppingCart::where('cartSession','=',$cartSession)->count('_id');      
        $population['weight'] = NumberUtil::decimal(ShoppingCart::where('cartSession','=',$cartSession)->sum('weight')); 

        // ShoppingCart::where('cartSession','=',$cartSession)->sum('weight');


        // $population['totalRevenue'] = ShoppingCart::select('price')->sum('price');
        // $population['totalRevenue'] = NumberUtil::decimal($population('totalRevenue'));
        // $population['totalSales'] = ShoppingCart::count('_id');
        // $population['totalBuyer'] = Purchase::count('_id');

        // data untuk chart, berupa array dalam array, bukan array of object
        // https://github.com/ankane/vue-chartkick/blob/v0.6.1/README.md
        // $population = Data::raw()->aggregate([
        //     ['$group' =>
        //         ['_id' => '$name', 'count' => ['$sum' => 1]]
        //     ],
        //     ['$sort' => ['count' => -1]],
        //     ['$limit' => 30],
        //     ['$project' => ['_id' => 0,
        //                    'text' => '$_id',
        //                    'size' => '$count',
        //                    ]
        //     ],

        // ]);
        // for ($i=0; $i <= 11 ; $i++) {
        //         $totalDraft = BudgetRequisition::select('grandTotal')
        //         ->where('approvalStatus', '!=', 'OPEN')
        //         // ->where('requestDate', '<=', $date.'-'.$i.'31')
        //         ->where('requestDate', '>=', $date.'-'.$i.'01')
        //         ->sum('grandTotal');
        //         $bulan[$i]['name']=Carbon::parse($date.'-'.($i+1).'-01')->format('F');
        //         $bulan[$i]['total']=$totalDraft;
        //     }
        // $population['salesByPeriod'] =  [
        //     ['Jan', [123, 400]],
        //     ['Feb', 200],
        //     ['Mar', 400],
        //     ['Apr', 800  ],
        //     ['May', 700],
        //     ['Jun', 1400],
        //     ['Jul', 1020],
        // ];
        // $population['revenueByPeriod'] = [
        //     ['Jan', 3000000],
        //     ['Feb', 5750000],
        //     ['Mar', 4600000],
        //     ['Apr', 2350000],
        //     ['May', [9970000, 2350000, 1300000 ]],
        //     ['Jun', 12004000],
        //     ['Jul', 28000000],
        // ];

        // if(AuthUtil::is('Owner')){
        //     $population['totalUser'] = User::count();
        //     $population['totalBusiness'] = BizProfile::where('ownerId', '=', Auth::user()->_id )->count();
        //     $population['totalProduct'] = HalalProduct::where('ownerId', '=', Auth::user()->_id )->count();
        // }

        // if(AuthUtil::is('Validator')){
        //     $population['totalUser'] = User::count();
        //     $population['totalBusiness'] = BizProfile::where('ownerId', '=', Auth::user()->_id )->count();
        //     $population['totalProduct'] = HalalProduct::where('ownerId', '=', Auth::user()->_id )->count();
        // }
        $br = ShoppingCart::select('orderQty','productName','currency','orderSubTotal' )
        ->where('cartSession','=',$cartSession)
        ->orderBy('createdDate','desc')
        ->get();
        $datatable = $br->each->makeHidden(['_id']);
        // debug($datatable->toArray());

        $population['tableCart'] = [
              'titleTable'=>'Cart',
              'titleColor'=>'text-green',
              'thClass'=>['text-70 text-center', 'text-150 text-center', 'text-150 text-center', 'text-150 text-center', 'text-100 text-center', 'text-150 text-center', 'text-150 text-center'],
              'tdTable'=> $datatable
          ];


        if(Auth::check()){
            return response()->json($population, 200);
        }else{
            return response('Unauthorized', 401);
        }

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
        $item = $this->model::where('cartSession','=',$id);
        // ->find($id);

        // $this->item_id = $item->_id;

        // $this->title = __('Edit') . ' ' . $item->_id;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sfm.checkout.form_layout';

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

    public function postDel(Request $request)
    {

        //return parent::postDel($request); // TODO: Change the autogenerated stub
    }


    public function additionalQuery($model, Request $request)
    {
        $model = $model->where('cartSession', '=', Auth::user()->cartSession )
//            ->groupBy('productName')
            ->orderBy('orderTimestamp', 'desc');
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

    public function externalData($data, $request)
    {
//        $cartdata = $data;
//
//        $cg = [];
//        $total = 0;
//        foreach ($cartdata as $cd){
//            $cg[ $cd['productName'] ] = $cd;
//            $cg[ $cd['productName'] ]['orderQty'] += $cd['orderQty'] ?? 0;
//            $cg[ $cd['productName'] ]['orderSubTotal'] += $cd['orderSubTotal'] ?? 0;
//            $total += $cg[ $cd['productName'] ]['orderSubTotal'];
//        }
//
//        $data = array_values($cg);

        return parent::externalData($data, $request); // TODO: Change the autogenerated stub
    }


    public function getActiveCart(){

        $cartSession = Auth::user()->cartSession ?? 'noSession';

        $cart = $this->model->where('cartSession', '=', $cartSession)
            ->orderBy('orderTimestamp', 'desc')
            ->get();

        $cartdata = [];
        $carttotal = $this->model->where('cartSession', '=', $cartSession)->sum('orderSubTotal');
        $carttotalqty = $this->model->where('cartSession', '=', $cartSession)->sum('orderQty');

        if($cart){
            $cartdata = $cart->toArray();
//
//            $cg = [];
//            foreach ($cartdata as $cd){
//                $cg[ $cd['productName'] ] = $cd;
//                $cg[ $cd['productName'] ]['orderQty'] += $cd['orderQty'] ?? 0;
//                $cg[ $cd['productName'] ]['orderSubTotal'] += $cd['orderSubTotal'] ?? 0;
//            }
//
//            $cartdata = array_values($cg);

        }

        return response()->json([
            'result'=>'OK',
            'msg'=>'All OK',
            'data'=>[
                'cart'=>$cartdata,
                'totalBill'=>$carttotal,
                'totalQty'=>$carttotalqty
            ]
        ], 200);


    }

}
