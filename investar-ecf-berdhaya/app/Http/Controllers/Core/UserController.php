<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/11/19
 * Time: 21.43
 */
namespace App\Http\Controllers\Core;

use App\Helpers\App\DwfUtil;
use App\Helpers\App\MmsUtil;
use App\Helpers\App\EcfUtil;
use App\Helpers\Injector;
use App\Helpers\AuthUtil;
use App\Helpers\RefUtil;
use App\Helpers\App\CentralUtil;
use App\Helpers\WorkflowUtil;
use App\Helpers\Util;
use App\Models\Core\Mongo\Role;
use App\Models\Core\Mongo\User;
use App\Models\Dwf\Admin\GroupAlias;
use App\Models\Dwf\Admin\JobGroup;
use App\Models\Halal\BizProfile;
use App\Models\Reference\JobTitle;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidDateException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class UserController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

//        $this->res_path = 'views/core/user';
//        $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_model_controller';

        $this->entity = 'User';

        // this must be set to use ACL
        $this->auth_entity = 'all-users';

        // set controller path
        $this->controller_base = 'user';

        // set view base to include standard slot
        $this->view_base = 'core.user';

        $this->model = new User();
    }

    public function getIndex()
    {
        $this->title = 'Users';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'core.user.formlayout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_print = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_delete = true;
        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;

        $this->with_revision = false;
        $this->with_workflow = false;

        $this->viewer_layout = $this->form_layout;
        $this->viewer_dialog_size = $this->form_dialog_size;

        // $this->with_advanced_search = false;
        $this->with_advanced_search = true;

        $this->extra_query = [
            'dobFrom'=>'',
            'dobUntil'=>'',
            'roleName'=>'',
            'statusEmployee'=>'',
            'companyName'=>'',
        ];

        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions = $this->setupFormOptions($formOptions);

        $this->print_template = [
            [
                'template'=>'user-detail',
                'modal'=>'xl',
                'label'=>'Print Detail'
            ],
            [
                'template'=>'user-card',
                'modal'=>'xl',
                'label'=>'Print Card'
            ]
        ];

        $this->aux_data = $formOptions;
        $this->view_title_fields='this.name';
        $this->update_title_fields = '"<h4>'.__('Edit').' " + this.name + "</h4>"' ;
        $this->add_title_fields = '"<h4>'.__('Create').' '.$this->entity.'</h4>"';

        $this->add_filler = true;

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;
        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'core.user.formlayout';
        $this->form_dialog_size = 'xl';

        $template_name = strtolower($keyword0);

        $this->title = __("Profile");
        if($keyword0 != ''){
            // $layout = str_replace('-', '_', $keyword0);
            //     $form_layout = $layout;
                if ($keyword0 == 'owner') {
                    $this->form_dialog_size = 'xl';
                    $this->title = __("Profile Pengusaha");
                    $this->with_advanced_search = false;
                }
                if ($keyword0 == 'validator') {
                    $this->form_dialog_size = 'xl';
                    $this->title = __("Profile Pendamping");
                    $this->with_advanced_search = false;
                }
                if ($keyword0 == 'sponsor') {
                    $this->form_dialog_size = 'xl';
                    $this->title = __("Profile Sponsor & Partner");
                    $this->with_advanced_search = false;
                }

        }

        // $this->form_layout = 'core.user.'.$form_layout;

        $this->viewer_layout = $this->form_layout;
        $this->viewer_dialog_size = $this->form_dialog_size;

        $this->form_view = 'form.html'; // use plain html

        $this->auth_entity = 'fms-'.trim($keyword0);

        $this->can_update = true;
        $this->can_view = true;
        $this->can_add = true;

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_print = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        // $this->can_multi_print = false;

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        $this->edit_as_page = false;
        $this->add_as_page = false;

        $this->add_filler = true;

        $this->viewer_as_document = false;

        $this->print_template = $template_name;

        $exclude = null;

//        $this->title = str_replace('-', ' ', Str::title($keyword0) );

        if(strpos($this->yml_file, '_controller') === false){
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false, $this->show_actions, $this->add_filler);
        }else{
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false, $this->show_actions, $this->add_filler, $exclude);
        }

        $this->entity = $this->title;

        $this->title_fields = 'name';

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupInjector($uiOptions, $data = null)
    {

        $uiOptions = Injector::setObject('outlet') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama Outlet', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Alamat', 'key'=>'alamat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Kab/Kota', 'key'=>'kab_kota', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Provinsi', 'key'=>'provinsi', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Negara', 'key'=>'negara ', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Kode Pos', 'key'=>'kode_pos', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [
                'id_pu'=>'',
                'nama'=>'',
                'alamat'=>'',
                'kab_kota'=>'',
                'provinsi'=> '',
                'negara'=>'',
                'kode_pos'=> ''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('core.user.outlet')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('pabrik') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama Pabrik', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Alamat', 'key'=>'alamat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Kab/Kota', 'key'=>'kab_kota', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Provinsi', 'key'=>'provinsi', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Negara', 'key'=>'negara', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Kode Pos', 'key'=>'kode_pos', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Status', 'key'=>'status_milik', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [
                'id_pu'=>'',
                'nama'=>'',
                'alamat'=>'',
                'kab_kota'=>'',
                'provinsi'=> '',
                'negara'=>'',
                'kode_pos'=> '',
                'status_milik'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('core.user.factories')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('pu_aspek_legal') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Jenis', 'key'=>'jenis_surat', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Jenis Surat Lainnya', 'key'=>'jenis_surat_lainnya', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'No Surat', 'key'=>'no_surat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Tanggal', 'key'=>'tgl_surat', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Masa Berlaku', 'key'=>'masa_berlaku', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Instansi Penerbit', 'key'=>'instansi_penerbit', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [
                'id_pu'=>'',
                'jenis_surat'=>'',
                'jenis_surat_lainnya'=>'',
                'no_surat'=>'',
                'tgl_surat'=>'',
                'masa_berlaku'=> '',
                'instansi_penerbit'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('core.user.aspeklegal')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('penyelia') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'No KTP', 'key'=>'no_ktp', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'No. SK Penyelia', 'key'=>'no_sertifikat', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Tgl SK', 'key'=>'tgl_sertifikat', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'No Sk', 'key'=>'no_sk', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Tgl SK ', 'key'=>'tgl_sk', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Kontak', 'key'=>'no_kontak', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'KTP', 'key'=>'file_ktp', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Agama', 'key'=>'agama', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [
                'id_pu'=>'',
                'nama'=>'',
                'no_ktp'=>'',
                'no_sertifikat'=>'',
                'tgl_sertifikat'=> '',
                'no_sk'=>'',
                'tgl_sk'=>'',
                'no_kontak'=> '',
                'file_ktp'=>'',
                'agama'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('core.user.penyeliahalal')->render()) // set template
        ->injectObject($uiOptions);

        $changeStatusTemplate = Util::inflateYmlForm( 'changestatus_controller','models/controllers/sms/dialogs', 'sms/dialogs/change_bid_status' );

        $uiOptions = Injector::setObject('bidStatusChange') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                ['label' => 'Doc. Type', 'key' => 'DocType', 'class' => 'text-100'],
            ]
        )->setObjDef( // set object default
            [
                'changeDate' => '',
                'changeBy' => '',
                'changeStatusTo' => '',
                'currentStatus' => '',
                'changeRemarks' => '',
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('bidStatus'),'name','name', false),
            ]
        )->setObjParams(
            [
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('bidStatus'),'name','name', false),
            ]
        )
            //->setObjTemplate(view('sms/salesoperation/jobregister/change_bid_status')->render() ) // set template
            ->setObjTemplate( $changeStatusTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

            $changeRemarkTemplate = Util::inflateYmlForm( 'changestatus_controller','models/controllers/sms/dialogs', 'sms/dialogs/change_status' );

            $uiOptions = Injector::setObject('mobileStatusChange') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Mobile', 'key' => 'mobile', 'class' => 'text-200'],
                ]
            )->setObjDef( // set object default
                [
                    'changeDate' => '',
                    'changeBy' => '',
                    'changeById' => '',
                    'mobile' => '',
                ]
            )->setObjParams(
                [
                ]
            )
                //->setObjTemplate(view('sms.dialogs.change_bid_status')->render() ) // set template
                ->setObjTemplate( $changeRemarkTemplate ) // set template
                ->injectObject($uiOptions); // inject into uiOption array

                $changeEmailTemplate = Util::inflateYmlForm( 'changestatus_controller','models/controllers/sms/dialogs', 'sms/dialogs/change_email_status' );

                $uiOptions = Injector::setObject('emailStatusChange') // name variable / field yang akan diinject
                ->setObjFields( // mwnambahkan setting field untuk table
                    [
                        ['label' => 'Email', 'key' => 'email', 'class' => 'text-200'],
                    ]
                )->setObjDef( // set object default
                    [
                        'changeDate' => '',
                        'changeBy' => '',
                        'changeById' => '',
                        'email' => '',
                    ]
                )->setObjParams(
                    [
                    ]
                )
                    //->setObjTemplate(view('sms.dialogs.change_bid_status')->render() ) // set template
                    ->setObjTemplate( $changeEmailTemplate ) // set template
                    ->injectObject($uiOptions); // inject into uiOption array


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

        $formOptions['bizCompanyTypeOptions'] = RefUtil::toOptions(RefUtil::getCompanyType(),'companyType','companyType', false);
        $formOptions['bizIdTypeOptions'] = [
            ['text'=>'NIB', 'value'=>'NIB']
        ];

        $kmap = [
            '_id',
            'kabupatenCode',
            'kabupatenName',
            'provinceCode',
            'provinceName'
        ];

        $formOptions['getToKnowInvestarOptions'] = RefUtil::toOptions(EcfUtil::getKnowInvestar(),'name','name', false);
        $formOptions['currentJobOptions'] = RefUtil::toOptions(EcfUtil::getCurrentJob(),'name','name', false);
        $formOptions['riskOptions'] = RefUtil::toOptions(EcfUtil::getRisk(),'name','name', false);
        $formOptions['bankOptions'] = RefUtil::toOptions(EcfUtil::getBank(),'name','name', false);
        $formOptions['investorTypeOptions'] = RefUtil::toOptions(EcfUtil::getInvestorType(),'name','name', false);
        $formOptions['investmentPreferenceOptions'] = RefUtil::toOptions(EcfUtil::getInvestmentPreference(),'name','name', false);
        $formOptions['incomeSourceOptions'] = RefUtil::toOptions(EcfUtil::getIncomeSource(),'name','name', false);
        $formOptions['bankNameOptions'] = RefUtil::toOptions(EcfUtil::getBank(),'name','name', false);
        $formOptions['heirRelationOptions'] = RefUtil::toOptions(EcfUtil::getHeirRelation(),'name','name', false);
        $formOptions['relativeRelationOptions'] = RefUtil::toOptions(EcfUtil::getRelativeRelation(),'name','name', false);
        $formOptions['lastEducationOptions'] = RefUtil::toOptions(EcfUtil::getLastEducation(),'name','name', false);
        $formOptions['maritalStatusOptions'] = RefUtil::toOptions(EcfUtil::getMaritalStatus(),'name','name', false);

        $formOptions['investmentGoalOptions'] = RefUtil::toOptions(EcfUtil::getInvestmentGoal(),'name','name', false);
        $formOptions['monthlyIncomeOptions'] = RefUtil::toOptions(EcfUtil::getMonthlyIncome(),'name','value', false);
        $formOptions['investmentBudgetOptions'] = RefUtil::toOptions(EcfUtil::getInvestmentBudget(),'name','value', false);
        $formOptions['marketingFunnelsOptions'] = RefUtil::toOptions(EcfUtil::getMarketingFunnels(),'name','name', false);
        $formOptions['typeOfFundingOptions'] = RefUtil::toOptions(EcfUtil::getFundingType(),'name', 'name', false);
        $formOptions['noOfBranchesOptions'] = RefUtil::toOptions(EcfUtil::getNoOfBranches(),'name', 'name', false);
        $formOptions['contactWACountryOptions'] = [
            ['text'=>'+62', 'value'=>'+62'],
            ['text'=>'+61', 'value'=>'+61']
        ];
        $formOptions['positionOptions'] = RefUtil::toOptions(EcfUtil::getPositionInCompany(),'name', 'name', false);

        $tahun = Carbon::now()->isoFormat('YYYY');
        $year = [];
        foreach (range( $tahun, 1900) as $yr){
            $year[] = [ 'text'=>$yr, 'value'=>$yr ];
        }
        $formOptions['legalityOptions'] = [
            ['text'=>'YA', 'value'=>'CONFIRMED']
        ];

        $formOptions['establishedSinceYearOptions'] = $year;
        $formOptions['citizenshipOptions'] = [
            ['text'=>'WNI Tinggal Di Indonesia', 'value'=>'WNI Tinggal Di Indonesia'],
            ['text'=>'WNI Tinggal Di Luar Negeri', 'value'=>'WNI Tinggal Di Luar Negeri'],
            ['text'=>'WNA Tinggal Di Indonesia', 'value'=>'WNA Tinggal Di Indonesia'],
            ['text'=>'WNA Tinggal Di Luar Negeri', 'value'=>'WNA Tinggal Di Luar Negeri']
        ];

        $formOptions['placeOfBirthOptions'] = RefUtil::toGroupOptions2( RefUtil::getKabupaten() , 'kabupatenName', 'kabupatenName', 'provinceName', true );


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
        $formOptions['bizTypeOptions'] = RefUtil::toOptions(EcfUtil::getBizType(),'name','name', false);

        $formOptions['minDob'] = Carbon::now( env('DEFAULT_TIME_ZONE'))->subYears(17)->endOfYear()->toDateString();

        $this->entity = $this->title;


        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch');
        $ext = $request->get('extraData');
        if((isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){ // query hanya dilakukan jika advanced search aktif dan panel terbuka
            if( $ext['dobFrom'] != '' && $ext['dobUntil'] != '' ){

                $dobFrom = Carbon::parse($ext['dobFrom']);
                $dobUntil = Carbon::parse($ext['dobUntil']);

                $model = $model->whereBetween('dateOfBirth', [ $dobFrom , $dobUntil ] );
            }

            if( $ext['roleName'] != '' ){
                $role = $ext['roleName'];
                $model = $model->where('roleId', $role);
            }

            if( $ext['statusEmployee'] != '' ){
                $statEmployee = $ext['statusEmployee'];
                $model = $model->where('statusEmployee', $statEmployee);
            }

            if( $ext['companyName'] != '' ){
                $company = $ext['companyName'];
                $model = $model->where('companyName', $company);
            }
        }


        if($request->has('keywords')){
            $k = $request->get('keywords');
            if($k['keyword0'] != ''){
                $model = $model->where('roleSlug','=', $k['keyword0'] );
            }
        }

        if(AuthUtil::is('owner')){
            $model = $model->where('masterId','=', Auth::user()->_id );
        }

        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        $population['password'] = '';

        if(isset($population['jobTitleCode']) && $population['jobTitleCode'] != '' ){
            $jobObject = JobTitle::where( 'jobCode','=', $population['jobTitleCode'] )->first([
                'description','jobCode', 'jobTitle','subGroup'
            ]);
            if($jobObject){
                $jo =  $jobObject->toArray();
                $jo['_id'] = ['jobCode'=>$jo['jobCode'] ];
                $population['jobObject'] = $jo;
            }else{
                $population['jobObject'] = null;
            }
        }else{
            $population['jobObject'] = null;
        }

        $defaultDoB = Carbon::now( env('DEFAULT_TIME_ZONE'))->subYears(17)->endOfYear();


        try {
            $dob = $population['dateOfBirth'] ?? false;
            if($dob){
                $dob = Carbon::make( $population['dateOfBirth']);
                if( $dob->gt( $defaultDoB ) ){
                    $population['dateOfBirth'] = $defaultDoB;
                }
            }else{
                $population['dateOfBirth'] = $defaultDoB;
            }
        }catch (InvalidDateException $invalidDateException){
            $population['dateOfBirth'] = $defaultDoB;
        }


        if(isset($population['bizDefaultId']) && $population['bizDefaultId'] != '' )
        {
            $biz = BizProfile::find($population['bizDefaultId']);
            if($biz){
                $population['bizTradeMark'] =  $biz->bizTradeMark;
                $population['bizCompanyType'] =  $biz->bizCompanyType;
                $population['bizRegisteredName'] =  $biz->bizRegisteredName;
                $population['bizIdType'] =  $biz->bizIdType;
                $population['bizIdNumber'] =  $biz->bizIdNumber;
                $population['bizAddress'] =  $biz->bizAddress;
                $population['bizType'] =  $biz->bizType;
                $population['bizPicEmail'] =  $biz->bizPicEmail;
                $population['bizPicName'] =  $biz->bizPicName;
                $population['bizPicPosition'] =  $biz->bizPicPosition;
                $population['bizInstagram'] =  $biz->bizInstagram;
                $population['bizFacebook'] =  $biz->bizFacebook;
                $population['bizTwitter'] =  $biz->bizTwitter;
            }
        }

        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        if(isset($data['password']) && $data['password'] != ''){
            unset($data['confirm_password']);
            $data['password'] = Hash::make($data['password']);
        }else{
            unset($data['password']);
            unset($data['confirm_password']);
        }

        if(isset($data['pin']) && $data['pin'] != ''){
            unset($data['confirm_pin']);
            $data['pin'] = Hash::make($data['pin']);
        }else{
            unset($data['pin']);
            unset($data['confirm_pin']);
        }

        if(isset($data['roleId'])){
            $data['roleSlug'] = AuthUtil::getRoleSlug($data['roleId']);
            $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        }

        $data['memberReferralCode'] = $data['memberReferralCode'] ?? strtoupper( Util::randomstring(8, 'alphanumeric'));

        $data['mobileString'] = $data['mobileCountry'].$data['mobile'];
        $data['ownerId'] = Auth::user()->_id;
        $data['ownerName'] = Auth::user()->name;
        $tahun = Carbon::now();
        $usiaPemodal = $tahun->diff($data['dateOfBirth'])->y;
        $data['userAge'] = $usiaPemodal;
        if (Auth::user()->approvalStatus == 'DECLINED') {
            $data['approvalStatus'] = "UNVERIFIED";
        }
        // $data['relativeMobileString'] = $data['relativeMobileCountry'].$data['relativeMobile'];

        // if(isset($data['bizDefaultId']) && $data['bizDefaultId'] != '' ){
        //     $biz = BizProfile::find($data['bizDefaultId']);
        //     if($biz){

        //     }else{
        //         $biz = new BizProfile();
        //     }
        // if(AuthUtil::is('penerbit')){
        //     $profile_data = [
        //         'bizTradeMark',
        //         'bizCompanyType',
        //         'bizRegisteredName',
        //         'bizIdType',
        //         'bizIdNumber',
        //         'bizAddress',
        //         'bizType',
        //         'bizPicEmail',
        //         'bizPicName',
        //         'bizPicPosition',
        //         'getToKnowInvestar',
        //         'relativeName',
        //         'relativeMobile',
        //         'relativeAddress',
        //         'relativeKabupaten',
        //         'relativeProvince',
        //         'relativeZIP'
        //     ];
        //     $bizprofile = BizProfile::where('ownerId', '=', $data['ownerId'])->first();
            // $bizprofile = "tes";

            // if( AuthUtil::isFilled($profile_data) && $bizprofile == null){
            // $biz = new BizProfile();
            // $biz->bizTradeMark = $data['bizTradeMark'];
            // $biz->bizCompanyType = $data['bizCompanyType'];
            // $biz->bizRegisteredName = $data['bizRegisteredName'];
            // $biz->bizIdType = $data['bizIdType'];
            // $biz->bizIdNumber = $data['bizIdNumber'];
            // $biz->bizAddress = $data['bizAddress'];
            // $biz->bizType = $data['bizType'];
            // $biz->bizPicEmail = $data['bizPicEmail'];
            // $biz->bizPicName = $data['bizPicName'];
            // $biz->bizPicPosition = $data['bizPicPosition'];
            // $biz->contactWA = $data['contactWA'];
            // $biz->ownerId = $data['ownerId'];
            // $biz->ownerName = $data['ownerName'];

            // $biz->save();
            // }
        // }
            // if($biz->_id){
            //     $data['bizDefaultId'] = $biz->_id;
            // }
        // }
            //$data['username'] = $data['mobile'];

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function postEdit($_id, $data = null, Request $request)
    {
        if( isset($data['password']) && $data['password'] == ''){
            unset($data['password']);
            unset($data['confirm_password']);
        }

        if( isset($data['pin']) && $data['pin'] == ''){
            unset($data['pin']);
            unset($data['confirm_pin']);
        }

        //override postEdit to inject these parameters
        $this->upsert_mode = true;
        $this->is_step_page = true;
        $this->add_page_base = 'biz-profile';

        return parent::postEdit($_id, $data, $request); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {
        unset($data['confirm_password']);
        unset($data['confirm_pin']);

        if(isset($data['password'])){
            $data['password'] = Hash::make($data['password']);
        }

        if(isset($data['pin'])){
            $data['pin'] = Hash::make($data['pin']);
        }

        $data['roleName'] = AuthUtil::getRoleName($data['roleId']);
        $data['roleSlug'] = AuthUtil::getRoleSlug($data['roleId']);

        if(AuthUtil::is('owner') || AuthUtil::isAdmin()){
            $data['masterId'] = Auth::user()->_id;
            $data['masterName'] = Auth::user()->name;
        }

        $data['mobileString'] = $data['mobileCountry'].$data['mobile'];

        $data['memberReferralCode'] = $data['memberReferralCode'] ?? strtoupper( Util::randomstring(8, 'alphanumeric'));

        //$data['username'] = $data['mobile'];

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function changePassword(Request $request)
    {
        $id = $request->get('id') ?? Auth::user()->_id;
        $user = $this->model->find($id);
        $password = Hash::make($request->get('password'));

        $user->password = $password;

        if( $user->save() )
        {
            return response()->json([
                'result'=>'OK',
                'msg'=>'Password changed successfuly',
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'Failed to change Password'
            ]);
        }
    }

    public function changePin(Request $request)
    {
        $id = $request->get('id') ?? Auth::user()->_id;

        //$id = $id ?? Auth::user()->id;
        $user = $this->model->find($id);

        $pin = Hash::make($request->get('pin'));

        $user->pin = $pin;

        if( $user->save() )
        {
            return response()->json([
                'result'=>'OK',
                'msg'=>'Pin changed successfuly',
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'msg'=>'Pin failed to change'
            ]);
        }
    }

    public function getCity(Request $request)
    {
        $getCity = RefUtil::toOptions(RefUtil::getCity($request->get('province')),'cityName','cityName', false);
        return $getCity;
    }

    public function getParam()
    {
        $request = Request::capture();

        $allRoles = Util::toSelectOptions(new Role(), true , 'rolename');
        $this->sel_options['roles'] = $allRoles;

        $this->def_param['avatar'] = url( env('DEFAULT_AVATAR') );
        $this->def_param['idPic'] = url( env('DEFAULT_CARD_IMAGE') );

        $this->def_param['pin'] = '';
        $this->def_param['confirm_pin'] = '';

        $this->def_param['gender'] = 'L';

        $roleSlug = $request->get('keyword0');

        $this->def_param['roleSlug'] = $roleSlug;

        $roleId = AuthUtil::getRoleId($roleSlug);

        $this->def_param['roleId'] = $roleId;

        $this->def_param['dateOfBirth'] = Carbon::now( env('DEFAULT_TIME_ZONE'))->subYears(17)->endOfYear();


        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function getData($id, $additional_data = null)
    {
        $allRoles = Util::toSelectOptions(new Role(), true , 'rolename');
        $this->sel_options['roles'] = $allRoles;

        return parent::getData($id, $additional_data); // TODO: Change the autogenerated stub
    }

    public function postDlxl(Request $request)
    {
        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        return parent::postDlxl($request); // TODO: Change the autogenerated stub
    }

    public function rowPostProcess($row)
    {
//        $row['roleName'] = ( $rolename = AuthUtil::getRoleName( $row['roleId'] ) )? $rolename : 'No Role';
        return $row;
    }

    public function beforeImportCommit($data)
    {

        $uniqUser = $this->model->where( 'username', '=', $data['username'] )
            ->orWhere( 'email', '=', $data['email'] )
            ->orWhere( 'employeeId', '=', ($data['employeeId'] ?? null) )
            ->count();

        if($uniqUser > 0){
            return false;
        }else{

            unset($data['id']);

            if(isset($data['password']) && $data['password'] != '' ){
                $data['password'] = Hash::make($data['password']);
            }else{
                $data['password'] = Hash::make( env('DEFAULT_NEW_PASS', '87654321') );
            }
            if(isset($data['pin']) && $data['pin'] != '' ){
                $data['pin'] = Hash::make($data['pin']);
            }else{
                $data['pin'] = Hash::make( env('DEFAULT_NEW_PIN', '876543') );
            }

            if(isset($data['roleName']) && $data['roleName'] != '' ){
                $data['roleId'] = AuthUtil::getRoleId( $data['roleName'] );
            }else{
                $data['roleId'] = AuthUtil::getRoleId( 'Employee' );
            }

            $data['memberReferralCode'] = $data['memberReferralCode'] ?? strtoupper( Util::randomstring(8, 'alphanumeric'));

            if(isset($data['jobTitleCode']) && $data['jobTitleCode'] != '' ){
                $jobObject = JobTitle::where( 'jobCode','=', $data['jobTitleCode'] )->first();
                if($jobObject){
                    $data['jobObject'] = $jobObject->toArray() ;
                }else{
                    $data['jobObject'] = null;
                }
            }else{
                $data['jobObject'] = null;
            }

            if(isset($data['jobTitleCode']) && $data['jobTitleCode'] != '' ){
                $jobObject = JobTitle::where( 'jobCode','=', $data['jobTitleCode'] )->first([
                    'description','jobCode', 'jobTitle','subGroup'
                ]);
                if($jobObject){
                    $jo =  $jobObject->toArray();
                    $jo['_id'] = ['jobCode'=>$jo['jobCode'] ];
                    $data['jobObject'] = $jo;
                }else{
                    $data['jobObject'] = null;
                }
            }else{
                $data['jobObject'] = null;
            }


        }

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function setDispoKey($group){
        $eid = [];
        $kgroup = [];
        foreach ($group as $g){
            $e = $g['employeeId'] ?? 'noid';
            if($e != 'noid'){
                $eid[] =
                $kgroup[$e] = $g;
            }
        }

        $users = User::whereIn('employeeId', $eid)->get();
        if($users){
            foreach ($users->toArray() as $usr){
                if(isset( $kgroup[$usr['employeeId']] )){
                    $kgroup[$usr['employeeId']]['_id'] = $usr['_id'];
                }
            }
        }

        $grp = [];
        foreach ($kgroup as $k=>$v){
            $grp[] = $v;
        }

        return $grp;
    }

    public function getAutoUser(Request $request)
    {
        $q = $request->get('q');

        $ext = $request->get('extraData');

        $res = [];

        $key0 = $ext['keyword0'] ?? '';
        $mdl = $ext['model'] ?? '';

        $users = User::where( 'name', 'like', '%'.$q.'%' )
            ->orWhere( 'username', 'like', '%'.$q.'%' )
            ->orWhere( 'mobile', 'like', '%'.$q.'%' )
            ->orWhere( 'email', 'like', '%'.$q.'%' )
            ->get();

        $users = $users->toArray();

        foreach ($users as $g){
            $res[] = [
                'text'=>$g['name'],
                'value'=>[
                    '_id'=>$g['_id'],
                    'email'=>$g['email'],
                    'name'=>$g['name'],
                    'mobile'=>( $g['mobileString'] ?? '' ),
                    'username'=>($g['username'] ?? '' ),
                    'roleName'=>($g['roleName'] ?? ''),
                    'roleId'=>($g['roleId'] ?? ''),
                    'avatar'=>($g['avatar'] ?? ''),
                    'datatype'=>'person'
                ]
            ];

        }

        return response()->json([
            'result' => 'OK',
            'data' =>$res,
            'q'=>$q
        ], 200);

//        return response()->json([
//            'result' => 'OK',
//            'data' =>$res,
//        ], 200);


    }
    public function getAutoIBUser(Request $request)
    {
        $q = $request->get('q');

        $ext = $request->get('extraData');

        $res = [];

        $key0 = $ext['keyword0'] ?? '';
        $mdl = $ext['model'] ?? '';

        $farmNo = $ext['farmNo'] ?? '';

        $users = User::where('roleSlug','=','ib-officer')
//            ->where(function($qa) use ($farmNo){
//                $qa->where('access','=','public')
//                    ->orWhere(function($qp) use ($farmNo){
//                        $qp->where('access','=','private')
//                            ->where('farmNo', '=', $farmNo);
//                    });
//            })
            ->where(function($qx) use ($q){
                $qx->where( 'name', 'like', '%'.$q.'%' )
                    ->orWhere( 'username', 'like', '%'.$q.'%' )
                    ->orWhere( 'mobile', 'like', '%'.$q.'%' )
                    ->orWhere( 'email', 'like', '%'.$q.'%' );
            })
            ->get();

        $users = $users->toArray();

        foreach ($users as $g){
            $res[] = [
                'text'=>$g['name'],
                'value'=>[
                    '_id'=>$g['_id'],
                    'email'=>$g['email'],
                    'name'=>$g['name'],
                    'mobile'=>( $g['mobileString'] ?? '' ),
                    'username'=>($g['username'] ?? '' ),
                    'roleName'=>($g['roleName'] ?? ''),
                    'roleId'=>($g['roleId'] ?? ''),
                    'avatar'=>($g['avatar'] ?? ''),
                    'datatype'=>'person'
                ]
            ];

        }

        return response()->json([
            'result' => 'OK',
            'data' =>$res,
            'q'=>$q
        ], 200);


    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function getSetting($id = null)
    {
        if(is_null($id)){
            if(Auth::check()){
                $id = Auth::user()->id;
            }else{
                return redirect('login');
            }
        }

        $user = $this->model->find($id);

        if($user){
            $this->title = $user->name;
        }else{
            return redirect('login');
        }

        $this->table_view = 'core.user.setting';

        return $this->pageGenerator();

    }

    public function editProfile(Request $request, $id = null, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        if (Auth::user()->roleSlug == 'penerbit') {
            $this->res_path = 'models/controllers/ecf/profiles';
            $this->yml_file = 'penerbit_profile_controller';
        }elseif (Auth::user()->roleSlug == 'pemodal') {
            $this->res_path = 'models/controllers/ecf/profiles';
            $this->yml_file = 'pemodal_profile_controller';
        }else{
            $this->res_path = 'models/controllers/core';
            $this->yml_file = 'user_profile_controller';
        }
        $this->view_base = 'core.user';

        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = $user->name;
        }else{
            return redirect('login');
        }

        $this->item_id = $id;

        $this->form_layout = 'core.user.formlayout_profile';

        $role = AuthUtil::getRoleSlug( Auth::user()->roleId ) ?? '';

        if($role != ''){
            $layout = str_replace('-', '_', $role);
            if( View::exists('core.user.'.$layout) ){
                $this->form_layout = 'core.user.'.$layout;
            }
        }

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_modal_view = 'core.user.page_modal';

        $this->page_redirect_after_save = true;

        $this->page_cancel_redirect = 'profile';

        $this->page_save_redirect = 'profile';

        $this->page_additional_view = 'core.user.profile_page_additional';

        $this->backlink = 'profile';

        $this->page_class = 'container';

        $this->page_class = 'col-lg-8 col-md-12 col-xs-12';

        $this->bottom_action = true;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getProfile(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        if (Auth::user()->roleSlug == 'penerbit') {
            $this->res_path = 'models/controllers/ecf/profiles';
            $this->yml_file = 'penerbit_profile_view_controller';
        }elseif (Auth::user()->roleSlug == 'pemodal') {
            $this->res_path = 'models/controllers/ecf/profiles';
            $this->yml_file = 'pemodal_profile_view_controller';
        }else{
            $this->res_path = 'models/controllers/core';
            $this->yml_file = 'user_profile_controller';
        }

        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        $this->item_id = $id;

        $this->title = $user->name;

        $this->form_layout = 'core.user.formlayout_profile';

        $role = AuthUtil::getRoleSlug( Auth::user()->roleId ) ?? '';

        if($role != ''){
            $layout = str_replace('-', '_', $role);
            if( View::exists('core.user.'.$layout) ){
                $this->form_layout = 'core.user.'.$layout;
            }
        }

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->can_save = false;

        $this->viewer_can_print = true;

        $this->page_modal_view = 'core.user.page_modal';

        $this->page_redirect_after_save = true;

        $this->page_cancel_redirect = 'profile';

        $this->page_save_redirect = 'profile';

        $this->page_additional_view = 'core.user.profile_page_additional';

        $this->backlink = 'profile';

        $this->page_class = 'container';

        $this->page_class = 'col-lg-8 col-md-10 col-xs-12';

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function editPersonalProfile(Request $request, $id = null, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_profile_controller';

        $this->nav_file = 'new_user_nav';

        $this->view_base = 'core.user';

        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = 'Lengkapi Data Pribadi';
        }else{
            return redirect('login');
        }

        $this->item_id = $id;

        $this->form_layout = 'core.user.personal_profile';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_modal_view = 'core.user.page_modal';

        $this->page_redirect_after_save = true;

        $this->page_cancel_redirect = 'halal/dashboard';

        $this->page_save_redirect = 'halal/dashboard';

        $this->backlink = 'halal/dashboard';

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        $this->bottom_action = true;
        if(Auth::user()->isComplete == false){
            if(AuthUtil::is('Penerbit')){
                $this->save_button_label = 'Lanjut ke Profil Usaha';
                $this->page_save_redirect = 'ecf/profile/penerbit/step/1';
            }else{
                $this->save_button_label = 'Lanjut ke Profil Usaha';
                $this->page_save_redirect = 'ecf/profile/pemodal/step/1';
            
            }
        }else{
                $this->save_button_label = 'Save';
                $this->page_save_redirect = 'ecf/dashboard';
            }
        $this->can_cancel = false;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function editSecondProfile(Request $request, $id = null, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->res_path = 'models/controllers/core';
        $this->yml_file = 'user_profile_controller';

        $this->nav_file = 'new_user_nav';

        $this->view_base = 'core.user';

        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = 'Data Kerabat';
        }else{
            return redirect('login');
        }

        $this->item_id = $id;

        $this->form_layout = 'core.user.second_profile';

        $role = AuthUtil::getRoleSlug( Auth::user()->roleId ) ?? '';

        if($role != ''){
            $layout = str_replace('-', '_', $role);
            if( View::exists('core.user.'.$layout) ){
                $this->form_layout = 'core.user.'.$layout;
            }
        }

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_modal_view = 'core.user.page_modal';

        $this->page_redirect_after_save = true;

        $this->page_cancel_redirect = 'ecf/dashboard';

        $this->page_save_redirect = 'ecf/dashboard';

        $this->backlink = 'ecf/dashboard';

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        $this->bottom_action = true;

        $this->save_button_label = 'Selesai';

        $this->can_cancel = false;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function editBizProfile(Request $request, $id = null, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->res_path = 'models/controllers/core';

        $this->yml_file = 'user_profile_controller';

        $this->nav_file = 'new_user_nav';

        $this->view_base = 'core.user';

        $this->model = new User();

        $id = $id ?? Auth::user()->_id;

        $user = $this->model->find($id);

        if($user){
            $this->title = 'Profil Usaha';
        }else{
            return redirect('login');
        }

        $this->item_id = $id;

        $this->form_layout = 'core.user.biz_profile';

        $role = AuthUtil::getRoleSlug( Auth::user()->roleId ) ?? '';

        if($role != ''){
            $layout = str_replace('-', '_', $role);
            if( View::exists('core.user.'.$layout) ){
                $this->form_layout = 'core.user.'.$layout;
            }
        }

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_modal_view = 'core.user.page_modal';

        $this->page_redirect_after_save = true;

        $this->page_cancel_redirect = 'halal/dashboard';

        $this->page_save_redirect = 'halal/dashboard';

        $this->backlink = 'halal/dashboard';

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        $this->bottom_action = true;

        if(AuthUtil::is('Sponsor')){
            $this->form_layout = 'core.user.biz_profile';
            $this->save_button_label = 'Selesai';
            $this->page_save_redirect = 'halal/dashboard';
        }
        else{
            $this->save_button_label = 'Lanjut ke Data Kerabat';
            $this->page_save_redirect = 'second-profile';
        }

        $this->can_cancel = false;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function postMobileVerify(Request $request)
    {
        $auth = $request->get('auth');
        $aux = $request->get('aux');
        $data = $request->get('data');

        if( Hash::check($auth, Auth::user()->pin) ){

            $obj = $this->model::find($aux['id']);
            if($obj){
                $field = $aux['field'];
                // $obj->{$field} = $data['changeStatusTo'];
                $obj->{'mobileVerified'} = true;
                $obj->{'mobileVerifiedAt'} = $data['changeDate'];
                $obj->{'mobileVerification'} = true;
                $obj->{'mobileVerifiedBy'} = $data['changeById'];
                $obj->{'mobileVerifiedByName'} = $data['changeBy'];



                if($obj->save())
                {
                    // Util::log(Auth::user()->toArray(), $request->url(), 'CHANGE_STATUS' ,$request->toArray(), 'SUCCESS', $this->auth_entity, Auth::user()->id );
                    // Util::statuslog(Auth::user()->toArray(), $data, $this->entity , $this->auth_entity, $aux['id'] );

                    return response()->json([
                        'result'=>'OK',
                        'msg'=>'SUCCESS'
                    ]);
                }else{
                    return response()->json([
                        'result'=>'ERR',
                        'msg'=>'FAILEDSAVE'
                    ]);
                }


            }else{
                return response()->json([
                    'result'=>'ERR',
                    'msg'=>'NOENTITY'
                ]);
            }

        }else{
            return response()->json([
                'result'=>'AUTHERR',
                'msg'=>'Wrong PIN'
            ], 402);
        }

    }
    public function postEmailVerify(Request $request)
    {
        $auth = $request->get('auth');
        $aux = $request->get('aux');
        $data = $request->get('data');

        if( Hash::check($auth, Auth::user()->pin) ){

            $obj = $this->model::find($aux['id']);
            if($obj){
                $field = $aux['field'];
                // $obj->{$field} = $data['changeStatusTo'];
                $obj->{'emailVerified'} = true;
                $obj->{'emailVerifiedAt'} = $data['changeDate'];
                $obj->{'emailVerification'} = true;
                $obj->{'emailVerifiedBy'} = $data['changeById'];
                $obj->{'emailVerifiedByName'} = $data['changeBy'];



                if($obj->save())
                {
                    // Util::log(Auth::user()->toArray(), $request->url(), 'CHANGE_STATUS' ,$request->toArray(), 'SUCCESS', $this->auth_entity, Auth::user()->id );
                    // Util::statuslog(Auth::user()->toArray(), $data, $this->entity , $this->auth_entity, $aux['id'] );

                    return response()->json([
                        'result'=>'OK',
                        'msg'=>'SUCCESS'
                    ]);
                }else{
                    return response()->json([
                        'result'=>'ERR',
                        'msg'=>'FAILEDSAVE'
                    ]);
                }


            }else{
                return response()->json([
                    'result'=>'ERR',
                    'msg'=>'NOENTITY'
                ]);
            }

        }else{
            return response()->json([
                'result'=>'AUTHERR',
                'msg'=>'Wrong PIN'
            ], 402);
        }

    }

}
