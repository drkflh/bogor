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

class PemodalController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf/profiles';

        $this->yml_file = 'pemodal_profile_controller';

        $this->entity = 'Investor Profile';

        $this->auth_entity = 'biz-profile';

        $this->controller_base = 'ecf/profile/pemodal';

        $this->view_base = 'ecf.profiles.pemodal';

        $this->model = new User();
    }

    public function getIndex()
    {
        $this->title = 'Profil Pemodal';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = false;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.profiles.pemodal.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.profiles.pemodal.view_layout';
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
        $personal_data1 = [
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

        if( !AuthUtil::isFilled($personal_data1) ){
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
        $profile_data = [
            'idNumber',
            'name',
            'firstName',
            'gender',
            'placeOfBirth',
            'dateOfBirth',
            'userAge',
            'citizenship',
            'IdCardAddress',
            'address',
            'incomeSource',
            'currentJobDesc',
            'incomeSourceDesc',
            'idPic',
            'idCardSelfie',
            'bankName',
            'bankNo',
            'bankNoOwner',
        ];
        if( AuthUtil::isFilled($profile_data) && Auth::user()->userAge >= 17){
            return redirect('ecf/dashboard');
        }
        $this->title = __($this->entity);
        $this->is_step_page = true;
        $this->model = new User();
        $this->yml_file = 'pemodal_profile_controller';
        $this->res_path = 'models/controllers/ecf/profiles';
        $this->nav_file = 'new_user_nav';
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

        $formlayout = 'ecf.profiles.pemodal.step_'.$step;

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
                'title'=>'Personal Info',
                'description'=>'Personal Identity Informations',
                'active'=>( $this->current_step >= 1 )
            ],
            [
                'title'=>'Document',
                'description'=>'Id card and other',
                'active'=>( $this->current_step >= 2 )
            ],
            [
                'title'=>'Bank',
                'description'=>'Bank Account',
                'active'=>( $this->current_step >= 3 )
            ],
            [
                'title'=>'Preference',
                'active'=>( $this->current_step >= 4 )
            ],
        ];
        $this->save_button_label = 'Lanjut ke Data Kerabat';
        $this->page_save_redirect = 'ecf/dashboard';

        return parent::getStep($request, $step, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
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

        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['roleIdOptions'] = Util::toSelectOptions(new Role(), true, 'rolename', '_id');
        $formOptions['provinceOptions'] = RefUtil::toOptions(RefUtil::getProvince(),'provinceName','provinceName', false);
        $formOptions['companyNameOptions'] = RefUtil::toOptions(WorkflowUtil::getClient(),'companyName','companyName', false);
        $formOptions['statusEmployeeOptions'] = config('util.employee_status');
        $formOptions['genderOptions'] = [[ 'value'=> 'L', 'text'=> 'pria' ],[ 'value'=> 'P', 'text'=> 'wanita']];

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
        // $formOptions['maritalStatusOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Menikah', 'value'=>'Menikah'],
        //     ['text'=>'Cerai Hidup', 'value'=>'Cerai Hidup'],
        //     ['text'=>'Cerai Mati', 'value'=>'Cerai Mati'],
        //     ['text'=>'Belum Menikah', 'value'=>'Belum Menikah']
        // ];
        // $formOptions['lastEducationOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'SD', 'value'=>'SD'],
        //     ['text'=>'SMP', 'value'=>'SMP'],
        //     ['text'=>'SMA / Sederajat', 'value'=>'SMA / Sederajat'],
        //     ['text'=>'D3', 'value'=>'D3'],
        //     ['text'=>'D4', 'value'=>'D4'],
        //     ['text'=>'S1', 'value'=>'S1'],
        //     ['text'=>'S2', 'value'=>'S2'],
        //     ['text'=>'S3', 'value'=>'S3'],
        //     ['text'=>'Lainnya', 'value'=>'Lainnya']
        // ];
        // $formOptions['currentJobOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Pekerjaan A', 'value'=>'Pekerjaan A'],
        //     ['text'=>'Pekerjaan B', 'value'=>'Pekerjaan B'],
        //     ['text'=>'Pekerjaan C', 'value'=>'Pekerjaan C']
        // ];
        // $formOptions['riskOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Systematic Risk', 'value'=>'Systematic Risk'],
        //     ['text'=>'Unsystematic Risk', 'value'=>'Unsystematic Risk']
        // ];
        // $formOptions['relativeRelationOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Keluarga', 'value'=>'Keluarga'],
        //     ['text'=>'Kerabat', 'value'=>'Kerabat'],
        //     ['text'=>'Teman', 'value'=>'Teman']
        // ];
        // $formOptions['heirRelationOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Anak Kandung', 'value'=>'Anak Kandung'],
        //     ['text'=>'Anak Angkat', 'value'=>'Anak Angkat'],
        //     ['text'=>'Adik/Kakak', 'value'=>'Adik/Kakak']
        // ];
        // $formOptions['getToKnowInvestarOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Kerabat', 'value'=>'kerabat'],
        //     ['text'=>'Teman', 'value'=>'teman'],
        //     ['text'=>'Iklan', 'value'=>'iklan'],
        //     ['text'=>'Lainnya', 'value'=>'Lainnya']
        // ];
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

        $formOptions['legalityOptions'] = [
            ['text'=>'YA', 'value'=>'YA']
        ];
        // $formOptions['investorTypeOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Investor Konservatif', 'value'=>'Investor Konservatif'],
        //     ['text'=>'Investor Moderat', 'value'=>'Investor Moderat'],
        //     ['text'=>'Investor Agresif', 'value'=>'Investor Agresif']
        // ];
        // $formOptions['investmentGoalOptions'] = [
        //     ['text'=>'Tujuan A', 'value'=>'Tujuan A'],
        //     ['text'=>'Tujuan B', 'value'=>'Tujuan B'],
        //     ['text'=>'Tujuan C', 'value'=>'Tujuan C']
        // ];
        // $formOptions['investmentPreferenceOptions'] = [
        //     ['text'=>'Risk Averse (Menjauhi Risiko)', 'value'=>'Risk Averse'],
        //     ['text'=>'Risk Neutral (Netral Terhadap Risiko)', 'value'=>'Risk Neutral'],
        //     ['text'=>'Risk Seeker (Toleran Terhadap Risiko)', 'value'=>'Risk Seeker']
        // ];
        // $formOptions['monthlyIncomeOptions'] = [
        //     ['text'=>'', 'value'=>''],
        //     ['text'=>'Rp. 0 - Rp. 100.000', 'value'=>'low'],
        //     ['text'=>'Rp. 100.000 - Rp. 1.000.000', 'value'=>'mid'],
        //     ['text'=>'Rp. 1.000.000 - Rp. 10.000.000', 'value'=>'high'],
        //     ['text'=>'Lebih dari Rp. 10.000.000', 'value'=>'very high']
        // ];
        // $formOptions['investmentBudgetOptions'] = [
        //     ['text'=>'Rp. 0 - Rp. 100.000', 'value'=>'low'],
        //     ['text'=>'Rp. 100.000 - Rp. 1.000.000', 'value'=>'mid'],
        //     ['text'=>'Rp. 1.000.000 - Rp. 10.000.000', 'value'=>'high'],
        //     ['text'=>'Lebih dari Rp. 10.000.000', 'value'=>'very high']
        // ];
        // $formOptions['incomeSourceOptions'] = [
        //     ['text'=>'Pekerjaan', 'value'=>'Pekerjaan']
        // ];
        $formOptions['citizenshipOptions'] = [
            ['text'=>'WNI Tinggal Di Indonesia', 'value'=>'WNI Tinggal Di Indonesia'],
            ['text'=>'WNI Tinggal Di Luar Negeri', 'value'=>'WNI Tinggal Di Luar Negeri'],
            ['text'=>'WNA Tinggal Di Indonesia', 'value'=>'WNA Tinggal Di Indonesia'],
            ['text'=>'WNA Tinggal Di Luar Negeri', 'value'=>'WNA Tinggal Di Luar Negeri']
        ];
        // $formOptions['bankNameOptions'] = [
        //     ['text'=>'Bank JAGO', 'value'=>'JAGO'],
        //     ['text'=>'Bank BCA', 'value'=>'BCA'],
        //     ['text'=>'Bank Mandiri', 'value'=>'Mandiri']
        // ];

        $formOptions['placeOfBirthOptions'] = RefUtil::toGroupOptions2( RefUtil::getKabupaten() , 'kabupatenName', 'kabupatenName', 'provinceName', true );

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
        $formOptions['phoneCountryOptions'] = config('util.mobile_countries');

        $formOptions['minDob'] = Carbon::now( env('DEFAULT_TIME_ZONE'))->subYears(17)->endOfYear()->toDateString();

        $this->entity = $this->title;


        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __($this->entity);

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.profiles.pemodal.step_1';

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
        $this->form_layout = 'ecf.profiles.pemodal.step_1';

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
        $this->viewer_layout = 'ecf.profiles.pemodal.view_layout';

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
        $data['phoneString'] = $data['phoneCountry'].$data['phone'];
        $tahun = Carbon::now();
        $usiaPemodal = $tahun->diff($data['dateOfBirth'])->y;
        $userId = Auth::user()->_id;
        $data['userAge'] = $usiaPemodal;
        if( $usiaPemodal >= 17){
            $data['ageStatus'] = "";
        }else{
            $data['ageStatus'] = "Usia Anda Belum Cukup Untuk Membuat Akun Investar";
        }

            $profile_data = [
                'idNumber',
                'name',
                'firstName',
                'gender',
                'placeOfBirth',
                'dateOfBirth',
                'userAge',
                'citizenship',
                'IdCardAddress',
                'address',
                'incomeSource',
                'currentJobDesc',
                'incomeSourceDesc',
                'idPic',
                'idCardSelfie',
                'bankName',
                'bankNo',
                'bankNoOwner',
        ];

        if( AuthUtil::isFilled($profile_data)){
            if( $usiaPemodal >= 17){
                $this->model->where("_id","=", $userId)
                ->update(
                    ["isComplete" => true]
                );
            }else{
                $this->model->where("_id","=", $userId)
                ->update(
                    ["isComplete" => false]
                );
            }
        }
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function postGetAge(Request $request)
    {
        $tahun = Carbon::now();
        $dob = $request->get('dateOfBirth');
        $usiaPemodal = $tahun->diff($dob)->y;
        
        if($usiaPemodal >= 17){
            $status = '';
        }else{
            $status = 'Usia Anda Belum Cukup Untuk Membuat Akun Investar';
        }
        

            return response()->json([
                'result'=>'OK',
                'userAge'=>$usiaPemodal ?? 0,
                'dob'=>$dob,
                'requestBy'=> Auth::user()->_id ?? '',
                'requestName'=> Auth::user()->name ?? '',
                'status' => $status ?? '',
            ]);
        
        // }else{
        //     return response()->json([
        //         'result'=>'ERR',
        //         'msg'=>'NOENTITY-YA'
        //     ]);
        // }

    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}
