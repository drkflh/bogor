<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Halal\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\NumberUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\UserController;
use App\Models\Halal\BizProfile;
use App\Models\Halal\Business;
use App\Models\Halal\HalalProduct;
use App\Models\Halal\HalalCertification;
use App\Models\Reference\Company;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\User;
use App\Models\Reference\Product;
use App\Models\Wms\SalesOperation\JobRegister;
use App\Models\Wms\SalesOperation\SalesHighlight;
use Carbon\Carbon;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SihalalRegister2Controller extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Doc();
    }

    public function getIndex()
    {
        $this->title = 'Dashboard';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/halal/admin/dashboard';

        $this->template_var = [ 'hasSideNav'=>false ];

        $this->can_add = true;

        $this->data_url = 'admin/fieldreport';

        $this->table_view = env('ADMIN_DASHBOARD_VIEW', 'trips.dashboard');

        return parent::getIndex();
    }

    public function getDashboard($id = null)
    {   
        $sihalal_member = Auth::user()->status_sihalal_pu;

        if($sihalal_member){
            return redirect('halal/sihalal-confirm');
        }

        $this->res_path = 'models/controllers/halal/admin';
        $this->yml_file = 'dashboard_controller';

        $this->nav_file = 'user_nav';

        $this->title = '';

        $this->show_title = true;

        $this->item_data_url = 'halal/dashboard/data';

        $this->item_id = 1;

        $this->has_tab = false;

        $this->form_mode = 'edit';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'halal.halalproduct.sihalal_reg2';

        $this->can_autosave = false;

        $this->can_lock = true;

        $this->can_add = false;

        $this->page_refresh_button = true;

        $this->page_additional_view = 'halal.admin.dashboard.toolbar';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['companyName'] = "''";

        $defaultRange = [
                Carbon::now()->startOfYear()->toDateString(),
                Carbon::now()->endOfYear()->toDateString(),
            ];

        $this->extra_query = [
            'fromDate'=>$defaultRange,
            'untilDate'=>'',
        ];

        $this->aux_data = $formOptions;

        $this->page_class = 'col-lg-10 col-md-10 col-xs-12';

        return parent::formGenerator();
    }

    public function postIndex(Request $request)
    {
        $this->defOrderField = 'createdDate';
        $this->defOrderDir = 'desc';

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        return $model;
    }

    public function beforeSave($data)
    {
        $data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function getData($id, $additional_data = null)
    {
        Util::ajaxDebug();
        $request = Request::capture();

        $dateRange = $request->get('extraData')['fromDate'];

        $date = Carbon::now()->year;
        $yy = Carbon::now()->isoFormat('YY');
        $year = Carbon::now()->isoFormat('YYYY');
        // $date = JobRegister::select('inquiryDate')->first();
        // $year = Carbon::parse($date->inquiryDate)->year;
        // dd($date);date("d M Y", strtotime('inquiryDate'))

        $population = [];

        $population['userId'] = Auth::id();
        $population['totalUser'] = User::count();
        $population['totalBusiness'] = BizProfile::count();
        $population['totalProduct'] = Product::count();

        $totalNotCertified = HalalProduct::select('productName')
            ->where('productStatus', '=', 'Belum Tersertifikasi')
            ->count();
        $totalInProgress = HalalProduct::select('productName')
            ->where('productStatus', '=', 'Dalam Proses')
            ->count();
        $totalCertified = HalalProduct::select('productName')
            ->where('productStatus', '=', 'Tersertifikasi Halal')
            ->count();

        $totalDraft = HalalCertification::select('productName')
            ->where('certificationStatus', '=', 'Draft')
            ->count();
        $totalCertificationInProgress = HalalCertification::select('productName')
            ->where('certificationStatus', '=', 'Dalam Proses')
            ->count();
        $totalFinal = HalalCertification::select('productName')
            ->where('certificationStatus', '=', 'Final')
            ->count();

        $population['productStatusByChart'] =  [
            ['Not Certified', $totalNotCertified],
            ['Processed', $totalInProgress],
            ['Certified', $totalCertified],
        ];

        $population['certificationStatusByChart'] = [
            ['Draft', $totalDraft],
            ['Processed', $totalCertificationInProgress],
            ['Final', $totalFinal],
        ];

        if(AuthUtil::is('Owner')){
            $population['totalUser'] = User::count();
            $population['totalBusiness'] = BizProfile::where('ownerId', '=', Auth::user()->_id )->count();
            $population['totalProduct'] = HalalProduct::where('ownerId', '=', Auth::user()->_id )->count();
        }

        if(AuthUtil::is('Validator')){
            $population['totalUser'] = User::count();
            $population['totalBusiness'] = BizProfile::where('ownerId', '=', Auth::user()->_id )->count();
            $population['totalProduct'] = HalalProduct::where('ownerId', '=', Auth::user()->_id )->count();
        }


        if(Auth::check()){
            return response()->json($population, 200);
        }else{
            return response('Unauthorized', 401);
        }

    }

    public function getSales(){
        $begin = new DateTime( '2020-08-01' );
        $end = new DateTime( '2020-08-30' );
        $interval = new DateInterval('P1D');
        $dr = new DatePeriod($begin, $interval ,$end);

        $data = [];

        $s1 = [];
        foreach ($dr as $d){
            $s1[ $d->format('d-m-Y') ] = rand( 1, 45);
        }

        $s2 = [];
        foreach ($dr as $d){
            $s2[ $d->format('d-m-Y') ] = rand( 1, 25);
        }

        $s3 = [];
        foreach ($dr as $d){
            $s3[ $d->format('d-m-Y') ] = rand( 1, 35);
        }

        $data = [
            [ 'name'=>'Series 1', 'data'=> $s1 ]
        ];

        return response()->json( $data );

    }

    private function setWithinYear($model, $year, $field )
    {
        $model = $model->where(function($q) use($year, $field) {
            if(is_array($year) && count($year) == 2){
                $start = Carbon::make( $year[0] );
                $end = Carbon::make( $year[1] );

                $q->orWhereBetween( $field, [$start, $end]);
            }else{
                $start = Carbon::make( $year.'-01-01' )->startOfYear();
                $end = Carbon::make( $year.'-01-01' )->endOfYear();

                $q->where($field,'like','%'.$year.'%')
                    ->orWhereBetween( $field, [$start, $end]);
            }
        });
        return $model;
    }

}
