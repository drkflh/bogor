<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Profiles;

use App\Helpers\App\DwfUtil;
use App\Helpers\App\MmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\App\EcfUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Helpers\WorkflowUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\Role;
use App\Models\Ecf\BizProfile;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PenerbitController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf/profiles';

        $this->yml_file = 'penerbit_profile_controller';

        $this->entity = 'Investee Profile';

        $this->auth_entity = 'biz-profile';

        $this->controller_base = 'ecf/profile/penerbit';

        $this->view_base = 'ecf.profiles.penerbit';

        $this->model = new User();
    }

    public function getIndex()
    {
        $this->title = 'Profil Penerbit';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = false;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.profiles.penerbit.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.profiles.penerbit.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_upload = false;
        $this->can_download_csv = false;
        $this->can_download_xls = false;

        $this->add_as_page = true;
        $this->edit_as_page = true;

        $this->add_page_base = $this->controller_base.'/step/1';
        $this->edit_page_base = $this->controller_base.'/step/';

        $this->add_filler = false;
        $this->view_title_fields = 'this.bizRegisteredName';

        $this->with_advanced_search = false;

        return parent::getIndex();
    }

    public function getStep(Request $request, $step = 1, $id = null, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
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
        ];

        if( !AuthUtil::isFilled($personal_data) ){
            return redirect('personal-profile');
        }

        if( Auth::user()->userAge < 17 ){
            return redirect('personal-profile')->with('error', 'Usia Anda Harus 17 Tahun Keatas');  
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

        $id_pic = [
            'idPic'
        ];

        if( !AuthUtil::isFilled($id_pic) ){
            return redirect('personal-profile')->with('error', 'Kartu Identitas Wajib Diisi'); ;
        }
        $profile_data = [
            'bizTradeMark',
            'bizAddress',
            'bizType',
            'bizRegisteredName',
            'bizCompanyType',
            'bizIdType',
            'bizIdNumber',
            'legality',
            'haveLegalitas',
            'attAktaPerusahaan',
            'attNIB',
            'attSKKemenhumham',
            'attTDP',
            'noNPWP',
            'attNPWP',
            'slikOJK',
            'productServices',
            'productServicesDescription',
            'establishedSinceYear',
            'attCompanyProfile',
            'monthlyGrossRevenue',
            'monthlyNettRevenue',
            'attFinancialReports',
            'bizPlanTriennial',
            'attBizPlan',
            'idPic',
            'ownerIdCard',
            'directorIdCard',
            'requiredFunding',
            'typeOfFunding'
        ];
        $bizprofile = BizProfile::where('ownerId', '=', Auth::user()->_id)->first();
        if( AuthUtil::isFilled($profile_data) && $bizprofile != null){
            return redirect('ecf/dashboard');
        }
        $this->title = __($this->entity);
        $this->is_step_page = true;
        $this->model = new User();
        $this->yml_file = 'penerbit_profile_controller';
        $this->res_path = 'models/controllers/ecf/profiles';
        $this->nav_file = 'new_user_nav';
        // $this->backlink = 'biz-profile';
        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            // $this->title = 'Profil Usaha';
        }else{
            return redirect('login');
        }
        $this->item_id = $id;
        /* Use custom form layout */
        $step = $step ?? 1;

        $id = $id ?? Auth::user()->_id;

        $formlayout = 'ecf.profiles.penerbit.step_'.$step;

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = $formlayout;

        $this->page_class = 'col-lg-8 col-md-12 col-xs-12';

        $this->form_mode = 'edit';

        $mode = $this->form_mode;

        $this->runAcl();
        $this->runUrlSet($mode);
        $this->runPageViewSet($mode);

        $this->non_closing_save = true;

        $this->page_redirect_after_save = false;

        $this->current_step = $step;
        $this->num_step_page = 4;
        $this->step_progress = [
            [
                'title'=>'Data Individu',
                'description'=>'Data diri',
                'active'=>( $this->current_step >= 1 )
            ],
            [
                'title'=>'Legalitas Perusahaan',
                'description'=>'Harap mengisi semua dokumen',
                'active'=>( $this->current_step >= 2 )
            ],
            [
                'title'=>'Informasi Bisnis Perusahaan',
                'description'=>'Harap mengisi semua dokumen',
                'active'=>( $this->current_step >= 3 )
            ],
            [
                'title'=>'Sumber Informasi',
                'active'=>( $this->current_step >= 4 )
            ],
        ];
        $this->save_button_label = 'Lanjut ke Data Kerabat';
        $this->page_save_redirect = 'ecf/dashboard';

        return parent::getStep($request, $step, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }


    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');
        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);
        $formOptions['companyNameOptions'] = RefUtil::toOptions(WorkflowUtil::getClient(),'companyName','companyName', false);
        $formOptions['statusEmployeeOptions'] = config('util.employee_status');
        $formOptions['genderOptions'] = [[ 'value'=> 'L', 'text'=> 'L' ],[ 'value'=> 'P', 'text'=> 'P']];

        $formOptions['jobObjectOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode(), ['jobCode','jobTitle'], '_object', false ) ;

        $formOptions['bizUnitOptions'] = RefUtil::toOptions( RefUtil::getBizUnit(), ['bizUnitCode','bizUnitName'], 'bizUnitCode', true ) ;

        $formOptions['notificationSubsOptions'] = RefUtil::toOptions( MmsUtil::getNotificationTemplates(), ['slug', 'description'], '_object', false ) ;

        $formOptions['idTypeOptions'] = [[ 'value'=> 'KTP', 'text'=> 'KTP' ],[ 'value'=> 'SIM', 'text'=> 'SIM'],[ 'value'=> 'KITAS', 'text'=> 'KITAS'],[ 'value'=> 'PASSPORT', 'text'=> 'PASSPORT']];

        $formOptions['kabupatenOptions'] = RefUtil::toGroupOptions2( RefUtil::getKabupaten() , 'kabupatenName', 'kabupatenName', 'provinceName', true );
        $formOptions['relativeKabupatenOptions'] = RefUtil::toGroupOptions2( RefUtil::getKabupaten() , 'kabupatenName', 'kabupatenName', 'provinceName', true );

        $formOptions['kabupatenObjectOptions'] = RefUtil::toGroupOptions2( RefUtil::getKabupaten() , 'kabupatenName', '_object', 'provinceName', true );

        $formOptions['relativeKabupatenObjectOptions'] = RefUtil::toGroupOptions( RefUtil::getKabupaten() , 'kabupatenName', '_object', 'provinceName', true );

        $formOptions['bizCompanyTypeOptions'] = RefUtil::toOptions(RefUtil::getCompanyTypes(),'companyType','companyType', false);
        $formOptions['bizIdTypeOptions'] = [
            ['text'=>'NIB', 'value'=>'NIB']
        ];
        $formOptions['legalityOptions'] = [
            ['text'=>'YA', 'value'=>'CONFIRMED']
        ];
        $formOptions['haveLegalitasOptions'] = [
            ['text'=>'YA', 'value'=>'ya'],
            ['text'=>'TIDAK', 'value'=>'tidak']
        ];
        $formOptions['bizTypeOptions'] = RefUtil::toOptions(EcfUtil::getBizType(),'name','name', false);
        $formOptions['marketingFunnelsOptions'] = RefUtil::toOptions(EcfUtil::getMarketingFunnels(),'name','name', false);
        $formOptions['getToKnowInvestarOptions'] = RefUtil::toOptions(EcfUtil::getKnowInvestar(),'name','name', false);
        $formOptions['typeOfFundingOptions'] = RefUtil::toOptions(EcfUtil::getFundingType(),'name', 'name', false);
        $formOptions['noOfBranchesOptions'] = RefUtil::toOptions(EcfUtil::getNoOfBranches(),'name', 'name', false);
        $formOptions['positionOptions'] = RefUtil::toOptions(EcfUtil::getPositionInCompany(),'name', 'name', false);
        $formOptions['contactWACountryOptions'] = [
            ['text'=>'+62', 'value'=>'+62'],
            ['text'=>'+61', 'value'=>'+61']
        ];
        // $formOptions['noOfBranchesOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'1', 'value'=>'One'],
        //     ['text'=>'2 - 10', 'value'=>'TwoToTen'],
        //     ['text'=>'11 - 50', 'value'=>'ElevenToFifty'],
        //     ['text'=>'50+', 'value'=>'MoreThenFifty']
        // ];
        // $formOptions['establishedYearOptions'] = [
        //     ['text'=>'Kurang Dari 1 Tahun', 'value'=>'lessOneYear'],
        //     ['text'=>'2-5 Tahun', 'value'=>'twoToFiveYear'],
        //     ['text'=>'6-10 Tahun', 'value'=>'sixToTenYear'],
        //     ['text'=>'10 Tahun Lebih', 'value'=>'moreThenTenYear']
        // ];
        // $formOptions['marketingFunnelsOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Pabrik Langsung Ke Pelanggan', 'value'=>'direct'],
        //     ['text'=>'Pabrik ke Pengecer ke Pelanggan', 'value'=>'fromRetailer'],
        //     ['text'=>'Pabrik ke Agen ke Pedagang Besar ke Pengecer ke Pelanggan', 'value'=>'fromAgen']
        // ];
        // $formOptions['getToKnowInvestarOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Kerabat', 'value'=>'kerabat'],
        //     ['text'=>'Teman', 'value'=>'teman'],
        //     ['text'=>'Iklan', 'value'=>'iklan'],
        //     ['text'=>'Lainnya', 'value'=>'lainnya']
        // ];
        // $formOptions['contractReferenceOptions'] = [
        //     ['text'=>'Memiliki', 'value'=>'Memiliki'],
        //     ['text'=>'Tidak Memiliki', 'value'=>'Tidak Memiliki']
        // ];

        $kmap = [
            '_id',
            'kabupatenCode',
            'kabupatenName',
            'provinceCode',
            'provinceName'
        ];

        $formOptions['kabupatenObjectMap'] = RefUtil::toObjectMap( RefUtil::getKabupaten() , 'kabupatenName', $kmap );

        $formOptions['kecamatanOptions'] = [];

        $formOptions['kelurahanOptions'] = [];

        $formOptions['cityOptions'] = [];

        $formOptions['new_password'] = '""';
        $formOptions['new_confirm_password'] = '""';
        $formOptions['new_pin'] = '""';
        $formOptions['new_confirm_pin'] = '""';

        $formOptions['mobileCountryOptions'] = config('util.mobile_countries');
        $formOptions['relativeMobileCountryOptions'] = config('util.mobile_countries');

        $formOptions['minDob'] = Carbon::now( env('DEFAULT_TIME_ZONE'))->subYears(17)->endOfYear()->toDateString();
        
        $tahun = Carbon::now()->isoFormat('YYYY');
        $year = [];
        foreach (range( $tahun, 1900) as $yr){
            $year[] = [ 'text'=>$yr, 'value'=>$yr ];
        }

        $formOptions['establishedSinceYearOptions'] = $year;
        $this->entity = $this->title;


        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __($this->entity);

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.profiles.penerbit.step_1';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('Edit').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.profiles.penerbit.step_1';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        $this->bottom_action = true;

        $this->save_button_label = 'Next';

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->view_title_fields = $this->entity;

        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('View').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->viewer_layout = 'ecf.profiles.penerbit.view_layout';

        $this->runAcl();
        $this->runUrlSet('view');
        $this->runPageViewSet('view');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
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

    public function postEdit($_id, $data = null, Request $request)
    {
        //override postEdit to inject these parameters
        $this->upsert_mode = true;
        $this->is_step_page = true;
        $this->add_page_base = $this->controller_base;
        $current_step = $this->current_step;

        return parent::postEdit($_id, $data, $request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        if( AuthUtil::isAdmin() ){

        }else{
            $model = $model->where('ownerId', '=', Auth::user()->_id );
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
        $data['ownerId'] = Auth::user()->_id;
        $userId = Auth::user()->_id;
        $data['ownerName'] = Auth::user()->name;
        $tahun = Carbon::now()->isoFormat('YYYY');
        $lamaBerdiri = $tahun - $data['establishedSinceYear'];
        if ($data['typeOfFunding'] != 'Lainnya') {
            $data['typeOfFundingDetail'] = $data['typeOfFunding'];
        }
            
            $profile_data = [
                'bizTradeMark',
                'bizAddress',
                'bizType',
                'bizRegisteredName',
                'bizCompanyType',
                'bizIdType',
                'bizIdNumber',
                'legality',
                'haveLegalitas'.
                'attAktaPerusahaan',
                'attNIB',
                'attSKKemenhumham',
                'attTDP',
                'noNPWP',
                'attNPWP',
                'slikOJK',
                'productServices',
                'productServicesDescription',
                'establishedSinceYear',
                'attCompanyProfile',
                'monthlyGrossRevenue',
                'monthlyNettRevenue',
                'attFinancialReports',
                'bizPlanTriennial',
                'attBizPlan',
                'idPic',
                'ownerIdCard',
                'directorIdCard',
                'requiredFunding',
                'typeOfFunding'
            ];
            $bizprofile = BizProfile::where('ownerId', '=', $data['ownerId'])->first();
            // $bizprofile = "tes";

            if( AuthUtil::isFilled($profile_data) && $bizprofile == null){
            $biz = new BizProfile();
            $biz->bizTradeMark = $data['bizTradeMark'];
            $biz->bizCompanyType = $data['bizCompanyType'];
            $biz->bizRegisteredName = $data['bizRegisteredName'];
            $biz->bizIdType = $data['bizIdType'];
            $biz->bizIdNumber = $data['bizIdNumber'];
            $biz->bizAddress = $data['bizAddress'];
            $biz->bizType = $data['bizType'];
            $biz->email = $data['email'];
            $biz->name = $data['name'];
            $biz->position = $data['position'];
            $biz->contactWA = $data['contactWA'];
            @$biz->legality = $data['legality'];
            @$biz->haveLegalitas = $data['haveLegalitas'];
            @$biz->attAktaPerusahaan = $data['attAktaPerusahaan'];
            @$biz->attAktaPerusahaanObjects = $data['attAktaPerusahaanObjects'];
            @$biz->attNIB = $data['attNIB'];
            @$biz->attNIBObjects = $data['attNIBObjects'];
            @$biz->attSKKemenhumham = $data['attSKKemenhumham'];
            @$biz->attSKKemenhumhamObjects = $data['attSKKemenhumhamObjects'];
            @$biz->attTDP = $data['attTDP'];
            @$biz->attTDPObjects = $data['attTDPObjects'];
            @$biz->attNPWP = $data['attNPWP'];
            @$biz->attNPWPObjects = $data['attNPWPObjects'];
            @$biz->noNPWP = $data['noNPWP'];
            @$biz->slikOJK = $data['slikOJK'];
            @$biz->slikOJKObjects = $data['slikOJKObjects'];
            @$biz->productServices = $data['productServices'];
            @$biz->establishedSinceYear = $data['establishedSinceYear'];
            @$biz->establishedYear = $lamaBerdiri . " " . "Tahun";
            @$biz->attCompanyProfile = $data['attCompanyProfile'];
            @$biz->attCompanyProfileObjects = $data['attCompanyProfileObjects'];
            @$biz->idPic = $data['idPic'];
            @$biz->ownerIdCard = $data['ownerIdCard'];
            @$biz->directorIdCard = $data['directorIdCard'];
            @$biz->noOfBranches = $data['noOfBranches'];
            @$biz->productServicesDescription = $data['productServicesDescription'];
            @$biz->marketingFunnels = $data['marketingFunnels'];
            @$biz->monthlyGrossRevenue = $data['monthlyGrossRevenue'];
            @$biz->monthlyNettRevenue = $data['monthlyNettRevenue'];
            @$biz->attFinancialReports = $data['attFinancialReports'];
            @$biz->attFinancialReportsObjects = $data['attFinancialReportsObjects'];
            @$biz->bizPlanTriennial = $data['bizPlanTriennial'];
            @$biz->bizPlanTriennialObjects = $data['bizPlanTriennialObjects'];
            @$biz->attBizPlan = $data['attBizPlan'];
            @$biz->attBizPlanObjects = $data['attBizPlanObjects'];
            @$biz->requiredFunding = $data['requiredFunding'];
            @$biz->typeOfFunding = $data['typeOfFunding'];
            // @$biz->contractReference = $data['contractReference'];
            @$biz->covidStrategy = $data['covidStrategy'];
            @$biz->getToKnowInvestar = $data['getToKnowInvestar'];
            $biz->ownerId = $data['ownerId'];
            $biz->ownerName = $data['ownerName'];

            $biz->save();

            $this->model->where("_id","=", $userId)
            ->update(
                ["isComplete" => true]
            );
            }

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
