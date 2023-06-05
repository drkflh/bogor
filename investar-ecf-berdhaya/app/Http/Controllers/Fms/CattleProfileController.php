<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Fms;

use App\Helpers\App\DwfUtil;
use App\Helpers\App\FmsUtil;
use App\Helpers\App\SmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Injector;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Fms\CattleProfile;
use App\Models\Fms\Farm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class CattleProfileController extends AdminController
{
    var $farms = [];

    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/fms';

        $this->yml_file = 'cattleprofile_controller';

        $this->entity = 'Cattle Profile';

        $this->auth_entity = 'fms-cattle-management';

        $this->controller_base = 'fms/cattle-profile';

        $this->view_base = 'fms.cattleprofile';

        $this->model = new CattleProfile();
    }

    public function getIndex()
    {
        $this->title = 'Cattle Profile';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'fms.cattleprofile.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'fms.cattleprofile.view_layout';
        $this->viewer_dialog_size = 'lg';
        $this->viewer_as_document = false;
        $this->viewer_can_print = true;


        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_print = true;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_multi_print = false;

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $masterId = Auth::user()->masterId ?? '';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        $this->add_filler = true;

        $this->title_fields = 'cattleId';
        $this->pdf_title_fields = 'cattleId';

        $this->print_template = 'cattle-profile';

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'fms.cattleprofile.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html

        $form_layout = 'form_layout';

        $template_name = strtolower($keyword0);

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('fms.cattleprofile.'.$layout) ){
                $form_layout = $layout;
            }
        }

        $this->form_layout = 'fms.cattleprofile.'.$form_layout;
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'fs';

        $this->auth_entity = 'fms-'.trim($keyword0);

        $this->can_update = true;
        $this->can_view = true;

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_print = true;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_multi_print = false;

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        //INJECTORS
        $uiOptions = [];


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];

        $this->edit_as_page = true;
        $this->add_as_page = true;
        $this->edit_page_base = "fms/cattle-profile/edit/'+ row.cattleCategory +'";
        $this->add_page_base = 'fms/cattle-profile/add/'.trim($keyword0);

        $formOptions['docHistory'] = [];
        $formOptions['sendDoc'] = '{}';
        $formOptions['sentTo'] = '{}';
        $formOptions['receiveDoc'] = '{}';

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
//        $this->aux_data = $formOptions;
        $this->print_template = 'data-card';
        $this->add_filler = true;

        $this->viewer_as_document = true;

        $this->print_template = $template_name;

        $exclude = null;

        if(strpos($this->yml_file, '_controller') === false){
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false, $this->show_actions, $this->add_filler);
        }else{
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false, $this->show_actions, $this->add_filler, $exclude);
        }

        $this->entity = $this->title;

        $this->title_fields = 'cattleId';
        $this->pdf_title_fields = 'cattleId';

        $this->print_template = 'cattle-profile';

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $masterId = Auth::user()->masterId ?? '';

        $formOptions['bornDiffOptions'] = [ [ 'text'=> "Normal", 'value'=> "Normal" ], [ 'text'=> "Ditarik", 'value'=> "Ditarik" ], [ 'text'=> "Distokia", 'value'=> "Distokia" ], [ 'text'=> "Caesar", 'value'=> "Caesar" ] ];
        $formOptions['farmObjectOptions'] = FmsUtil::toOptions( FmsUtil::getFarms( $masterId ), 'farmName', '_object', false ) ;
        $formOptions['sexOptions'] = [[ 'value'=> 'Male', 'text'=> 'Male' ],[ 'value'=> 'Female', 'text'=> 'Female']];
        $formOptions['cattleCategoryOptions'] = RefUtil::getSelectOptions('cattle-profile', 'cattle-category');
        $formOptions['breedOptions'] = FmsUtil::toOptions( FmsUtil::getBreeds(), 'breed', 'breed', false ) ;

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdateForm($population)
    {
        $population['itemId'] = $population['_id'];
        $population['officerId'] = Auth::user()->_id;
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
//        $farm = Farm::find($data['farmId']);
//        if($farm){
//            $data['farmName'] = $farm['farmName'];
//        }

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

//        $farm = Farm::find($data['farmId']);
//        if($farm){
//            $data['farmName'] = $farm['farmName'];
//        }
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        $next = [];
        $next['approverId'] = Auth::user()->_id;
        $next['approverName'] = Auth::user()->name;
        $next['authorizationSign'] = '';
        $next['initialSign'] = '';
        $next['note'] = '';
        $next['decision'] = 'CREATED';
        $next['approveAs'] = 'CREATOR';

        Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

        $data['isUSG'] = $data['isUSG'] ?? false;

        //FmsUtil::updatePregnant($data['farmNo'], $data['cattleId'], $data['isPregnant'], $data['isUSG'] , $data, $data['createdAt']);

        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }

    public function afterUpdate($id, $data = null)
    {
        $approveAs = (  isset($data['ownerId']) && $data['ownerId'] == Auth::user()->_id ? 'CREATOR' : 'UPDATER');

        $next = [];
        $next['approverId'] = Auth::user()->_id;
        $next['approverName'] = Auth::user()->name;
        $next['authorizationSign'] = '';
        $next['initialSign'] = '';
        $next['note'] = '';
        $next['decision'] = 'UPDATED';
        $next['approveAs'] = $approveAs;

        Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

        $data['isUSG'] = $data['isUSG'] ?? false;

        //FmsUtil::updatePregnant($data['farmNo'], $data['cattleId'], $data['isPregnant'], $data['isUSG'] ,$data, $data['createdAt']);

        return parent::afterUpdate($id, $data); // TODO: Change the autogenerated stub
    }



    public function additionalQuery($model, Request $request)
    {
        if(AuthUtil::isAdmin() || AuthUtil::is('owner')){
            $model = $model->where('masterId','=', Auth::user()->_id );
        }
        if( AuthUtil::is('field-officer') || AuthUtil::is('farm-admin')){
            if( isset(Auth::user()->bizUnitId) ){
                $model = $model->where('farmId','=', Auth::user()->bizUnitId );
            }else if(isset(Auth::user()->masterId) ){
                $model = $model->where('masterId','=', Auth::user()->masterId );
            }else{
                $model = $model->where('masterId','=', Auth::user()->_id );
            }
        }
        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function postCommit(Request $request)
    {
        $farms = Farm::where( 'masterId', '=', Auth::user()->masterId )
            ->orWhere( 'masterId', '=', Auth::user()->_id )
            ->get();
        $farmArr = [];

        foreach ($farms->toArray() as $v){
            $farmArr[$v['farmId']] = $v;
        }

        $this->farms = $farmArr;

        return parent::postCommit($request); // TODO: Change the autogenerated stub
    }

    public function beforeImportCommit($data)
    {
        if(isset($data['farmNo'])){
            $data['farmObject'] = $this->farms[ $data['farmNo'] ] ?? null;
            if(!is_null($data['farmObject'])){
                $data['farmName'] = $data['farmObject']['farmName'] ?? '';
                $data['farmId'] = $data['farmObject']['_id'] ?? '';
            }
        }

        if(isset($data['bdate']) && !is_null($data['bdate'])){
            $data['age'] = Carbon::make($data['bdate'])->diffInDays( Carbon::now() );
        }else{
            $data['age'] = 1;
        }

        $data['farmNo'] = isset($data['farmNo']) ? strval($data['farmNo']) : '';

        $data['farmNo'] = str_pad($data['farmNo'], 8, '0', STR_PAD_LEFT  );

        $data['cattleId'] = isset($data['cattleId']) ? strval($data['cattleId']) : '';

        $data['currentCycleCntUp'] = $data['currentCycleCntUp'] ?? 1 ;

        $data['currentCycle'] = $data['currentCycle'] ?? '';

        $data['currentCycleStart'] = $data['currentCycleStart'] ?? Carbon::now( env('DEFAULT_TIME_ZONE'));

        $data['waitInsemination'] = $data['waitInsemination'] ?? false ;

        $data['waitUSG'] = $data['waitUSG'] ?? false ;

        $data['waitAction'] = $data['waitAction'] ?? false ;

        $data['waitPregnantCheck'] = $data['waitPregnantCheck'] ?? false ;

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function getAddProfile(Request $request, $keyword0, $keyword1 = null,$keyword2 = null ){

        $this->res_path = 'models/controllers/fms';
        $this->yml_file = 'cattleprofile_controller';

        $this->nav_path = 'views/partials/app/fms';
        $this->nav_file = 'nav';

        $this->title = __('Add').' '.str_replace('-', ' ', Str::title($keyword0) );

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'fms/cattle-profile/add';

        $this->update_url = 'fms/cattle-profile/edit';

        $this->item_data_url = 'fms/cattle-profile/param';

        $this->autosave_url = 'fms/cattle-profile/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = '';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = false;

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('fms.cattleprofile.'.$layout) ){
                $form_layout = $layout;
            }
        }

        $this->form_layout = 'fms.cattleprofile.'.$form_layout;


        $this->page_methods_view = 'fms.cattleprofile.add_methods';
        $this->page_computed_view = 'fms.cattleprofile.add_computed';
        $this->page_watch_view = 'fms.cattleprofile.add_watch';

        $this->page_redirect_after_save = true;
        $this->page_save_redirect = 'fms/cattle-profile/list/'.trim($keyword0);
        $this->page_cancel_redirect = 'fms/cattle-profile/list/'.trim($keyword0);

        $this->show_print_button = true;

        //INJECTORS
        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['bornDiffOptions'] = [ [ 'text'=> "Normal", 'value'=> "Normal" ], [ 'text'=> "Ditarik", 'value'=> "Ditarik" ], [ 'text'=> "Distokia", 'value'=> "Distokia" ], [ 'text'=> "Caesar", 'value'=> "Caesar" ] ];

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        return parent::formGenerator();

    }

    public function setupInjector($uiOptions, $data = null){

        $birthTemplate = Util::inflateYmlForm( 'birth_controller','models/controllers/fms/cattleprofile', 'fms.birth.form_layout', true, 'value' );

        $cattleId = $data['_id'] ?? '';
        $farmId = $data['farmId'] ?? '';

        $uiOptions = Injector::setObject('birth') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'BDAT', 'key' => 'bdat', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Calf ID', 'key' => 'calfId', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Calf RFID', 'key' => 'calfRfid', 'class' => 'text-150 pl-0 pr-0'],
                    ['label' => 'Breed', 'key' => 'calfBreed', 'class' => 'text-150 pl-0 pr-0'],
                    ['label' => 'Sex', 'key' => 'calfSex', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Diff', 'key' => 'calfDiff', 'class' => 'text-150 pl-0 pr-0'],
                    ['label' => 'Notes', 'key' => 'notes', 'class' => 'pl-0 pr-0'],
                ]
            )->setObjDef( // set object default
                [
                    'cattleId' => $cattleId,
                    'farmId' => $farmId,
                    'officerId' => Auth::user()->_id,
                    'bdat' => '',
                    'calfId' => '',
                    'calfRfid' => '',
                    'temperature' => '',
                    'heartRate' => '',
                    'weight' => '',
                    'fdat' => '',
                    'calfSex' => '',
                    'calfSire' => '',
                    'calfBreed' => '',
                    'calfDiff' => '',
                    'notes' => '',
                    'calfDiffOptions' => [ [ 'text'=> "Normal", 'value'=> "Normal" ], [ 'text'=> "Ditarik", 'value'=> "Ditarik" ], [ 'text'=> "Distokia", 'value'=> "Distokia" ], [ 'text'=> "Caesar", 'value'=> "Caesar" ] ],

                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $birthTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $inseminationTemplate = Util::inflateYmlForm( 'insemination_controller','models/controllers/fms/cattleprofile', 'fms.insemination.form_layout' );

        $uiOptions = Injector::setObject('insemination') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Date', 'key' => 'reproDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Temp.', 'key' => 'temperature', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Heart Rate', 'key' => 'heartRate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Semen ID', 'key' => 'semenId', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Semen Detail', 'key' => 'semenDetail', 'class' => 'pl-0 pr-0'],
                ]
            )->setObjDef( // set object default
                [
                    'cattleId' => $cattleId,
                    'farmId' => $farmId,
                    'officerId' => Auth::user()->_id,
                    'temperature' => '',
                    'heartRate' => '',
                    'weight' => '',
                    'semenId' => '',
                    'semenDetail' => '',
                    'reproDate' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $inseminationTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $observationTemplate = Util::inflateYmlForm( 'observation_controller','models/controllers/fms/cattleprofile', 'fms.observation.form_layout' );

        $uiOptions = Injector::setObject('observation') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Date', 'key' => 'observationDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Type', 'key' => 'observationType', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Status', 'key' => 'observationStatus', 'class' => 'text-100 pl-0 pr-0'],
    //                ['label' => 'Temp.', 'key' => 'temperature', 'class' => 'text-50 pl-0 pr-0'],
    //                ['label' => 'Heart Rate', 'key' => 'heartRate', 'class' => 'text-50 pl-0 pr-0'],
    //                ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-50 pl-0 pr-0'],
                ]
            )->setObjDef( // set object default
                [
                    'cattleId' => $cattleId,
                    'farmId' => $farmId,
                    'officerId' => Auth::user()->_id,
                    'temperature' => '',
                    'heartRate' => '',
                    'weight' => '',
                    'observationDate' => '',
                    'temperature' => '',
                    'heartRate' => '',
                    'weight' => '',
                    'observationType' => '',
                    'observationStatus' => '',
                    'notes' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $observationTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $productionTemplate = Util::inflateYmlForm( 'dairyproduction_controller','models/controllers/fms/cattleprofile', 'fms.dairyproduction.form_layout' );

        $uiOptions = Injector::setObject('production') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Date', 'key' => 'prodDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Dim', 'key' => 'dim', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Milk', 'key' => 'milk', 'class' => 'pl-0 pr-0'],
                ]
            )->setObjDef( // set object default
                [
                    'cattleId' => $cattleId,
                    'farmId' => $farmId,
                    'officerId' => Auth::user()->_id,
                    'prodDate'=> '',
                    'dim' => '',
                    'milk' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $productionTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $weightLogTemplate = Util::inflateYmlForm( 'weightlog_controller','models/controllers/fms/cattleprofile', 'fms.weightlog.form_layout' );

        $uiOptions = Injector::setObject('weightLog') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Date', 'key' => 'checkDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-75 pl-0 pr-0'],
                ]
            )->setObjDef( // set object default
                [
                    'cattleId' => $cattleId,
                    'farmId' => $farmId,
                    'officerId' => Auth::user()->_id,
                    'checkDate'=> '',
                    'weight' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $weightLogTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $reproductionTemplate = Util::inflateYmlForm( 'reproduction_controller','models/controllers/fms/cattleprofile', 'fms/reproduction/form_layout' );

        $uiOptions = Injector::setObject('reproduction') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                ['label' => 'Date', 'key' => 'reproDate', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Temp.', 'key' => 'temperature', 'class' => 'text-75 pl-0 pr-0'],
                ['label' => 'Heart Rate', 'key' => 'heartRate', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-75 pl-0 pr-0'],
                ['label' => 'Note', 'key' => 'notes', 'class' => 'pl-0 pr-0'],
            ]
        )->setObjDef( // set object default
            [
                'cattleId' => $cattleId,
                'farmId' => $farmId,
                'officerId' => Auth::user()->_id,
                'temperature' => '',
                'heartRate' => '',
                'weight' => '',
                'semenId' => '',
                'semenDetail' => '',
            ]
        )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $reproductionTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $medicalTemplate = Util::inflateYmlForm( 'medicaltreatment_controller','models/controllers/fms/cattleprofile', 'fms/medicaltreatment/form_layout' );

        $uiOptions = Injector::setObject('medicalTreatment') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                ['label' => 'Date', 'key' => 'checkDate', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Temp.', 'key' => 'temperature', 'class' => 'text-75 pl-0 pr-0'],
                ['label' => 'Heart Rate', 'key' => 'heartRate', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Weight', 'key' => 'weight', 'class' => 'text-75 pl-0 pr-0'],
                ['label' => 'Note', 'key' => 'notes', 'class' => 'pl-0 pr-0'],
            ]
        )->setObjDef( // set object default
            [
                'cattleId' => $cattleId,
                'farmId' => $farmId,
                'officerId' => Auth::user()->_id,
                'temperature' => '',
                'heartRate' => '',
                'weight' => '',
                'diagnosis' => '',
                'anamnesis' => '',
                'action' => '',
                'medicine' => '',
                'references' => '',
                'notes' => '',
            ]
        )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $medicalTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $vaccinationTemplate = Util::inflateYmlForm( 'vaccination_controller','models/controllers/fms/cattleprofile', 'fms/vaccination/form_layout' );

        $uiOptions = Injector::setObject('vaccination') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [
                ['label' => 'Date', 'key' => 'administerTime', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Vaccine', 'key' => 'vaccineName', 'class' => 'text-150 pl-0 pr-0'],
                ['label' => 'DIN', 'key' => 'din', 'class' => 'text-100 pl-0 pr-0'],
                ['label' => 'Dosage', 'key' => 'dosageGiven', 'class' => 'text-50 pl-0 pr-0'],
                ['label' => 'Via', 'key' => 'administerVia', 'class' => 'text-150 pl-0 pr-0'],
                ['label' => 'Note', 'key' => 'notes', 'class' => 'pl-0 pr-0'],
            ]
        )->setObjDef( // set object default
            [
                'cattleId' => $cattleId,
                'farmId' => $farmId,
                'officerId' => Auth::user()->_id,
                'din' => '',
                'vaccineName' => '',
                'dosageGiven' => '',
                'administerTime' => '',
                'administerVia' => '',
                'notes' => '',
                'administerViaOptions' => [ [ 'text'=> "Oral", 'value'=> "Oral" ], [ 'text'=> "Subkutan", 'value'=> "Subkutan" ], [ 'text'=> "Intramuskular", 'value'=> "Intramuskular" ], [ 'text'=> "Intravena", 'value'=> "Intravena" ], [ 'text'=> "Intramamaria", 'value'=> "Intramamaria" ], [ 'text'=> "Intraperitonium", 'value'=> "Intraperitonium" ] ]
            ]
        )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $vaccinationTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array


        return $uiOptions;
    }

    public function getEditProfile(Request $request, $keyword0, $keyword1 = null,$keyword2 = null ){
        $this->res_path = 'models/controllers/fms';
        $this->yml_file = 'cattleprofile_controller';

        $this->nav_path = 'views/partials/app/fms';
        $this->nav_file = 'nav';

        $this->title = __('Update').' '.str_replace('-', ' ', Str::title($keyword0) );

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'fms/cattle-profile/add';

        $this->update_url = 'fms/cattle-profile/edit';

        $this->item_data_url = 'fms/cattle-profile/data';

        $this->autosave_url = 'clinic/operasi/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = $keyword1;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->js_load_transform = 'fms.cattleprofile.edit_load_transform';

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = true;

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        $entity = $this->model->find( $this->item_id );

        if($keyword0 != '' && $keyword0 != 'status'){

            $form = $entity->cattleCategory ?? 'cow';
            $layout = str_replace('-', '_', $form);
            if( View::exists('fms.cattleprofile.'.$layout) ){
                $form_layout = $layout;
            }
            $this->page_redirect_after_save = true;

            if($request->has('back')){
                $back = $request->get('back');
                $this->page_save_redirect = 'fms/cattle-profile/list/'.$back;
                $this->page_cancel_redirect = 'fms/cattle-profile/list/'.$back;
            }else{
                $this->page_save_redirect = 'fms/cattle-profile/list/'.trim($keyword0);
                $this->page_cancel_redirect = 'fms/cattle-profile/list/'.trim($keyword0);
            }

        }

        if( !is_null($keyword1) && $keyword1 != ''){
            $this->item_id = trim($keyword1);
            $this->title = 'Edit '.$entity->docNo;
        }

        $this->form_layout = 'fms.cattleprofile.'.$form_layout;

        $this->page_methods_view = 'fms.cattleprofile.edit_methods';
        $this->page_computed_view = 'fms.cattleprofile.edit_computed';
        $this->page_watch_view = 'fms.cattleprofile.edit_watch';

        $this->show_print_button = true;

        //INJECTORS
        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions, $entity->toArray());

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['bornDiffOptions'] = [ [ 'text'=> "Normal", 'value'=> "Normal" ], [ 'text'=> "Ditarik", 'value'=> "Ditarik" ], [ 'text'=> "Distokia", 'value'=> "Distokia" ], [ 'text'=> "Caesar", 'value'=> "Caesar" ] ];
//        $formOptions['attachmentsObjects'] = [];

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        return parent::formGenerator();

    }

    public function getDocNumber($data, $isObject = false)
    {
        if($isObject){

            if($data->formTemplate == 'surat-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'APPROVED' || $data->docStatus == 'REJECTED'){
                    $data->docNo = 'APL.' . $data->docStatus . '/' . $data->docClass  . '/' . $data->docYear  . '/' . $data->titleCode['jobCode'] . '-' . $data->confidentiality ;
                }

                if($data->docStatus == 'RELEASED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            ->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data->footer['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docSeq = $max;

                    $data->docNo = 'APL.' . $max . '/' . $data->docClass  . '/' . $data->docYear  . '/' . $data->titleCode['jobCode'] . '-' . $data->confidentiality ;
                }
            }
            if($data->formTemplate == 'nota-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'APPROVED' || $data->docStatus == 'REJECTED'){
                    $data->docNo = $data->titleCode['jobCode'] . '.' . $data->docStatus . '/' . $data->docClass  . '/' . $data->docYear  . '-' . $data->confidentiality ;
                }

                if($data->docStatus == 'RELEASED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            ->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data->footer['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo = $data->titleCode['jobCode'] . '.' . $max . '/' . $data->docClass  . '/' . $data->docYear  . '-' . $data->confidentiality ;
                }
            }
            if($data->formTemplate == 'lembar-disposisi' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'REJECTED'){
                    $data->docNo =  $data->titleCode['jobCode'] . '.' . $data->docStatus;
                }

                if($data->docStatus == 'APPROVED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate)
                            ->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo =  $data->titleCode['jobCode'] . '.' . $max;
                }
            }
            if($data->formTemplate == 'memo-internal' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'REJECTED'){
                    $data->docNo = 'MI.' . $data->docStatus . '/' . $data->titleCode['jobCode'] ;
                }

                if($data->docStatus == 'APPROVED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            //->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo = 'MI.' . $max . '/' . $data->titleCode['jobCode'] ;
                }
            }

        }else{


            if($data['formTemplate'] == 'surat-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'APPROVED' || $data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = 'APL.' . $data['docStatus'] . '/' . $data['docClass']  . '/' . $data['docYear']  . '/' . $data['titleCode']['jobCode'] . '-' . $data['confidentiality'] ;
                }

                if($data['docStatus'] == 'RELEASED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data['footer']['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = 'APL.' . $max . '/' . $data['docClass']  . '/' . $data['docYear']  . '/' . $data['titleCode']['jobCode'] . '-' . $data['confidentiality'] ;
                }
            }

            if($data['formTemplate'] == 'nota-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'APPROVED' || $data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = $data['titleCode']['jobCode'] . '.' . $data['docStatus'] . '/' . $data['docClass']  . '/' . $data['docYear']  . '-' . $data['confidentiality'] ;
                }

                if($data['docStatus'] == 'RELEASED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data['footer']['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = $data['titleCode']['jobCode'] . '.' . $max . '/' . $data['docClass']  . '/' . $data['docYear']  . '-' . $data['confidentiality'] ;
                }
            }

            if($data['formTemplate'] == 'lembar-disposisi' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'REJECTED'){
                    $data['docNo'] =  $data['titleCode']['jobCode'] . '.' . $data['docStatus'];
                }

                if($data['docStatus'] == 'APPROVED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode']) || isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate'])
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] =  $data['titleCode']['jobCode'] . '.' . $max;
                }
            }
            if($data['formTemplate'] == 'memo-internal' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = 'MI.' . $data['docStatus'] . '/' . $data['titleCode']['jobCode'] ;
                }

                if($data['docStatus'] == 'APPROVED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = 'MI.' . $max . '/' . $data['titleCode']['jobCode'] ;
                }
            }
        }

        return $data;
    }

    public function getParam()
    {
        $request = Request::capture();

        $ageType = $request->get('keyword0');

        $this->def_param['cattleCategory'] = $ageType;
        $this->def_param['officerId'] = Auth::user()->_id;
        $this->def_param['officerName'] = Auth::user()->name;
        $this->def_param['bornDiff'] = 'Normal';

        $this->def_param['farmObject'] = FmsUtil::getFarmObject( Auth::user()->bizUnitId );

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

    public function getAuto(Request $request)
    {
        $q = $request->get('q');

        $ext = $request->get('extraData');

        $farmNo = $ext['farmNo'] ?? '';

        if($farmNo == ''){
            $cattles = CattleProfile::where( 'cattleId', 'like', '%'.$q.'%' )
                ->where('sex', '=', 'Female' )
                ->orderBy('farmNo', 'asc')
                ->orderBy('cattleId', 'asc')
                ->get();
        }else{
            $cattles = CattleProfile::where( 'cattleId', 'like', '%'.$q.'%' )
                ->where('farmNo', '=', $farmNo)
                ->where('sex', '=', 'Female' )
                ->orderBy('farmNo', 'asc')
                ->orderBy('cattleId', 'asc')
                ->get();
        }

        $res = [];

        foreach ($cattles->toArray() as $c){
            $s = [];
            $s['text'] = $c['cattleId'];
            $s['value'] = $c;
            $res[] = $s;
        }

        return response()->json([
            'result' => 'OK',
            'data' =>$res,
            'q'=>$q
        ], 200);

    }
}
