<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\NumberUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\UserController;
use App\Models\Ecf\BizProfile;
use App\Models\Ecf\Business;
use App\Models\Ecf\EcfProduct;
use App\Models\Ecf\EcfCertification;
use App\Models\Reference\Company;
use App\Models\Ecf\Campaign;
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

class DashboardController extends AdminController
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
        $this->res_path = 'views/ecf/admin/dashboard';

        $this->template_var = [ 'hasSideNav'=>false ];

        $this->can_add = true;

        $this->data_url = 'admin/fieldreport';

        $this->table_view = env('ADMIN_DASHBOARD_VIEW', 'trips.dashboard');

        return parent::getIndex();
    }

    public function getDashboard($id = null)
    {
        $this->res_path = 'models/controllers/ecf/admin';
        $this->yml_file = 'dashboard_controller';

        $this->nav_file = 'user_nav';

        if( Auth::user()->isComplete == false){


            if( AuthUtil::is('Penerbit')){

                $personal_data = [
                    'mobile',
                    'placeOfBirth',
                    'dateOfBirth',
                    'address',
                    'kabupaten',
                    'province',
                    'ZIP',
                    'idType',
                    'idNumber',
                    'idPic'
                ];

                if( !AuthUtil::isFilled($personal_data) ){
                    return redirect('personal-profile');
                }
                if(Auth::user()->idType == 'KTP'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor KTP anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KTP harus numeric 16 karakter'); 
                    }
                    if (!is_numeric(Auth::user()->idNumber)){
                        return redirect('personal-profile')->with('error', 'Nomor KTP anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KTP harus numeric 16 karakter'); 
                    } 
                }
                if(Auth::user()->idType == 'SIM'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor SIM anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor SIM harus numeric 14 karakter'); 
                    }
                    if (!is_numeric(Auth::user()->idNumber)){
                        return redirect('personal-profile')->with('error', 'Nomor SIM anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor SIM harus numeric 14 karakter'); 
                    } 
                }
                if(Auth::user()->idType == 'KITAS'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor KITAS anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KITAS harus 12 karakter'); 
                    }
                }
                if(Auth::user()->idType == 'PASSPORT'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor PASSPORT anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor PASSPORT harus 8 karakter'); 
                    }
                }
                


                $biz_data1 = [
                    'name',
                    'contactWA',
                    'directorIdCard',
                    'ownerIdCard'
                ];

                if( !AuthUtil::isFilled($biz_data1) ){
                    return redirect('ecf/profile/penerbit/step/1')->with('error', 'Pastikan KTP Pemilik dan Direksi Terisi');
                }

                $biz_data2 = [
                    'bizTradeMark',
                    'bizAddress',
                    'bizType',
                    'bizRegisteredName',
                    'bizCompanyType',
                    'bizIdType',
                    'bizIdNumber',
                    'legality',
                    'noNPWP',

                ];

                if( !AuthUtil::isFilled($biz_data2) ){
                    return redirect('ecf/profile/penerbit/step/2');
                }

                $penerbitdoc2 = [
                    'attAktaPerusahaan',
                    'attNIB',
                    'attSKKemenhumham',
                    'attTDP',
                    'attNPWP',
                    'slikOJK'

                ];
                if( Auth::User()->haveLegalitas == 'ya'){
                    if( !AuthUtil::isFilled($penerbitdoc2) ){
                        return redirect('ecf/profile/penerbit/step/2')->with('error', 'Pastikan Lampiran NPWP, Lampiran Dokumen NIB, Lampiran Akta Perusahaan, Lampiran SK Kemenhumham, Lampiran TDP, dan Lampiran SLIK OJK Terisis');  
                    }
                }
                $biz_data3 = [
                    'productServices',
                    'productServicesDescription',
                    'establishedSinceYear',
                    'monthlyGrossRevenue',
                    'monthlyNettRevenue',
                    'requiredFunding',
                    'typeOfFunding'

                ];

                if( !AuthUtil::isFilled($biz_data3) ){
                    return redirect('ecf/profile/penerbit/step/3');
                }

                $penerbitdoc3 = [
                    'attCompanyProfile',
                    'attFinancialReports',
                    'bizPlanTriennial',
                    'attBizPlan',
                ];

                if( !AuthUtil::isFilled($penerbitdoc3) ){
                    return redirect('ecf/profile/penerbit/step/3')->with('error', 'Pastikan Dokumen Company Profile, Laporan Keuangan, Rencana Bisnis 3 Tahun Kedepan, dan Dokumen Rencana Bisnis Terisi');  
                }


            }

            if( AuthUtil::is('Pemodal')){

                $personal_data = [
                    'mobile',
                    'placeOfBirth',
                    'dateOfBirth',
                    'address',
                    'kabupaten',
                    'province',
                    'ZIP',
                    'idType',
                    'idNumber'
                    // 'idPic'
                ];

                if( !AuthUtil::isFilled($personal_data) ){
                    return redirect('personal-profile');
                }
                if(Auth::user()->idType == 'KTP'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor KTP anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KTP harus numeric 16 karakter'); 
                    }
                    if (!is_numeric(Auth::user()->idNumber)){
                        return redirect('personal-profile')->with('error', 'Nomor KTP anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KTP harus numeric 16 karakter'); 
                    } 
                }
                if(Auth::user()->idType == 'SIM'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor SIM anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor SIM harus numeric 14 karakter'); 
                    }
                    if (!is_numeric(Auth::user()->idNumber)){
                        return redirect('personal-profile')->with('error', 'Nomor SIM anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor SIM harus numeric 14 karakter'); 
                    } 
                }
                if(Auth::user()->idType == 'KITAS'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor KITAS anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor KITAS harus 12 karakter'); 
                    }
                }
                if(Auth::user()->idType == 'PASSPORT'){
                    if (Auth::user()->idValidation != 0){
                        return redirect('personal-profile')->with('error', 'Nomor PASSPORT anda tidak sesuai dengan ketentuan yang ada')->with('validation', 'Nomor PASSPORT harus 8 karakter'); 
                    }
                }


                $pemodal1 = [
                    'name',
                    'firstName',
                    'gender',
                    'placeOfBirth',
                    'dateOfBirth',
                    'citizenship',
                    'IdCardAddress',
                    'address',
                    'incomeSource',
                    'currentJobDesc',
                    'incomeSourceDesc',
                ];

                if( !AuthUtil::isFilled($pemodal1) ){
                    return redirect('ecf/profile/pemodal/step/1');
                }

                if( Auth::user()->userAge < 17 ){
                    return redirect('ecf/profile/pemodal/step/1')->with('error', 'Usia Anda Harus 17 Tahun Keatas');  
                }

                $pemodal2 = [
                    'idPic',
                    'idCardSelfie'
                ];

                if( !AuthUtil::isFilled($pemodal2) ){
                    return redirect('ecf/profile/pemodal/step/2');
                }

                $pemodal3 = [
                    'bankName',
                    'bankNo',
                    'bankNoOwner'
                ];

                if( !AuthUtil::isFilled($pemodal3) ){
                    return redirect('ecf/profile/pemodal/step/3');
                }

                $pemodal4 = [
                    'investmentBudget',
                    'investmentGoal',
                    'investmentPreference'
                ];

                if( !AuthUtil::isFilled($pemodal4) ){
                    return redirect('ecf/profile/pemodal/step/4');
                }


                // $second_data = [
                //     'relativeName',
                //     'relativeMobile',
                //     'relativeAddress',
                //     'relativeKabupaten',
                //     'relativeProvince',
                //     'relativeZIP'
                // ];

                // if( !AuthUtil::isFilled($second_data) ){
                //     return redirect('second-profile');
                // }



        }
    }

        // if( AuthUtil::is('Sponsor')){

        //     $personal_data = [
        //         'mobile',
        //         'placeOfBirth',
        //         'dateOfBirth',
        //         'address',
        //         'kabupaten',
        //         'province',
        //         'ZIP',
        //         'idType',
        //         'idNumber'
        //     ];

        //     if( !AuthUtil::isFilled($personal_data) ){
        //         return redirect('personal-profile');
        //     }


        //     $biz_data = [
        //         'bizTradeMark',
        //         'bizCompanyType',
        //         'bizRegisteredName',
        //         'bizIdType',
        //         'bizIdNumber',
        //         'bizAddress',
        //         'bizType',
        //         'bizPicEmail',
        //         'bizPicName',
        //         'bizPicPosition'
        //     ];

        //     if( !AuthUtil::isFilled($biz_data) ){
        //         return redirect('ecf/profile/penerbit/step/1');
        //     }

        // }

        // if( AuthUtil::is('Validator')){

        //     $personal_data = [
        //         'mobile',
        //         'placeOfBirth',
        //         'dateOfBirth',
        //         'address',
        //         'kabupaten',
        //         'province',
        //         'ZIP',
        //         'idType',
        //         'idNumber'
        //     ];

        //     if( !AuthUtil::isFilled($personal_data) ){
        //         return redirect('personal-profile');
        //     }


//            $second_data = [
//                'relativeName',
//                'relativeMobile',
//                'relativeAddress',
//                'relativeKabupaten',
//                'relativeProvince',
//                'relativeZIP'
//            ];
//
//            if( !AuthUtil::isFilled($second_data) ){
//                return redirect('second-profile');
//            }



        // }

//        $this->nav_path = 'views/partials/app/ecf';
//        $this->logo = env('APP_LOGO');

        $this->title = 'Dashboard';

        $this->show_title = true;

        $this->item_data_url = 'ecf/dashboard/data';

        $this->item_id = 1;

        $this->has_tab = false;

        $this->form_mode = 'edit';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        // $this->form_layout = 'ecf.admin.dashboard.admin';
        $this->form_layout = 'ecf.admin.dashboard.admin';
        if (Auth::user()->approvalStatus == 'DECLINED') {
            $this->form_layout = 'ecf.admin.dashboard.noaccess';
        }

        if( AuthUtil::is('owner')){
            $this->form_layout = 'ecf.admin.dashboard.owner';
        }

        if( AuthUtil::is('validator') || AuthUtil::is('pendamping')){
            $this->form_layout = 'ecf.admin.dashboard.validator';
        }

        if( AuthUtil::is('sponsor')){
            $this->form_layout = 'ecf.admin.dashboard.sponsor';
        }

        if( AuthUtil::is('pemodal')){
            $this->form_layout = 'ecf.admin.dashboard.pemodal';
        }
        if( AuthUtil::is('penyelenggara')){
            $this->form_layout = 'ecf.admin.dashboard.penyelenggara';
        }

        // $this->form_layout = 'ecf.admin.dashboard.admin';

        $this->can_autosave = false;

        $this->can_lock = true;

        $this->can_add = false;

        $this->page_refresh_button = true;

        // $this->page_additional_view = 'ecf.admin.dashboard.toolbar';

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

        // $dateRange = $request->get('extraData')['fromDate'];

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
        $population['totalPenerbit'] = User::where('roleSlug', '=', 'penerbit' )->count();
        $population['totalPemodal'] = User::where('roleSlug', '=', 'pemodal' )->count();
        $population['totalCampaign'] = Campaign::sum('requiredFunding');
        $tgl = Carbon::now()->subDays(7);
        $population['totalPenerbitDelta'] = User::where('roleSlug', '=', 'penerbit' )->where('created_at', '>=', $tgl)->count();
        $population['totalPemodalDelta'] = User::where('roleSlug', '=', 'pemodal' )->where('created_at', '>=', $tgl)->count();
        $population['totalPenerbitVerified'] = User::where('roleSlug', '=', 'penerbit' )->where('approvalStatus', 'VERIFIED')->count();
        $population['totalPemodalVerified'] = User::where('roleSlug', '=', 'pemodal' )->where('approvalStatus', 'VERIFIED')->count();
        $totalPenerbit = User::where('roleSlug', '=', 'penerbit' )->count();
        $totalPemodal = User::where('roleSlug', '=', 'pemodal' )->count();
        $population['penerbitPemodalByChart'] = [
            ['Penerbit', $totalPenerbit],
            ['Pemodal', $totalPemodal],
        ];

        $population['totalVerified'] = User::whereIn('roleSlug', ['penerbit', 'pemodal'] )->where('status', 'verified')->count();
        $population['totalUnverified'] = User::whereIn('roleSlug', ['penerbit', 'pemodal'] )->where('status', 'unverified')->count();
        $totalVerified = User::whereIn('roleSlug', ['penerbit', 'pemodal'] )->where('approvalStatus', 'VERIFIED')->count();
        $totalUnverified = User::whereIn('roleSlug', ['penerbit', 'pemodal'] )->where('approvalStatus', 'UNVERIFIED')->count();
       
        $population['verifiedUnverifiedByChart'] = [
            ['Verified', $totalVerified],
            ['Unverified', $totalUnverified],
        ];

        // $totalNotCertified = HalalProduct::select('productName')
        //     ->where('productStatus', '=', 'Belum Tersertifikasi')
        //     ->count();
        // $totalInProgress = HalalProduct::select('productName')
        //     ->where('productStatus', '=', 'Dalam Proses')
        //     ->count();
        // $totalCertified = HalalProduct::select('productName')
        //     ->where('productStatus', '=', 'Tersertifikasi Halal')
        //     ->count();

        // $totalDraft = HalalCertification::select('productName')
        //     ->where('certificationStatus', '=', 'Draft')
        //     ->count();
        // $totalCertificationInProgress = HalalCertification::select('productName')
        //     ->where('certificationStatus', '=', 'Dalam Proses')
        //     ->count();
        // $totalFinal = HalalCertification::select('productName')
        //     ->where('certificationStatus', '=', 'Final')
        //     ->count();

        // $population['productStatusByChart'] =  [
        //     ['Not Certified', $totalNotCertified],
        //     ['Processed', $totalInProgress],
        //     ['Certified', $totalCertified],
        // ];

        // $population['certificationStatusByChart'] = [
        //     ['Draft', $totalDraft],
        //     ['Processed', $totalCertificationInProgress],
        //     ['Final', $totalFinal],
        // ];

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
