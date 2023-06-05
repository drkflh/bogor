<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Sms\SalesOperation;

use App\Helpers\App\DmsUtil;
use App\Helpers\App\SmsUtil;
use App\Helpers\TimeUtil;
use App\Models\Core\Mongo\ApprovalStatusLog;
use App\Models\Core\Mongo\ChangeStatusLog;
use App\Models\Workflow\Time\SpentTime;
use Carbon\Carbon;
use App\Helpers\Injector;
use App\Helpers\App\SalesopUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Sms\SalesOperation\JobRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class JobRegisterController extends AdminController

{

    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/sms/salesoperation';

        $this->yml_file = 'jobregister_controller';

        $this->entity = 'Job Register';

        $this->auth_entity = 'job-register';

        $this->controller_base = 'sms/sales-operation/job-register';

        $this->view_base = 'sms.salesoperation.jobregister';

        $this->model = new JobRegister();
    }

    public function getIndex()
    {
        $this->title = '<img class="d-none d-md-inline-block"  style="width:55px;height:auto;margin-top:-10px;margin-right:3px" src="'.url('images/icons/icon-job.png').'" /> Job Register';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'sms.salesoperation.jobregister.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sms.salesoperation.jobregister.form_layout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);
        //advanced search
        $this->with_advanced_search = true;

        $this->extra_query= [
            'jobNo'=>'',
            'participatingCompany'=>'',
            'area'=>'',
            'bidYear'=>date( 'Y',time()),
            'bidYearUntil'=>date( 'Y',time()),
            'status'=>'',
            'bidStatusOp'=>'EQ',
            'bidStatus'=>'',
            'jobStatusOp'=>'EQ',
            'jobStatus'=>'',
            'company'=>'',
            'projectOwner'=>'',
            'project'=>'',
            'scope'=>'',
            'brand'=>'',
        ];

        $this->print_as_pdf = true;
        $this->print_download_xls = true;

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->add_title_fields = '"<h4><img class=\"d-none d-md-inline-block \" src=\"'.url('images/icons/icon-job.png').'\" / style=\"width:65px;height:auto;margin-top:-18px;\"/> Add: New Job No</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ this.jobNo + "</h4></div>"',  '<img src=\"'.url('images/icons/icon-job.png').'\" style=\"width:65px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update "  + " Job ID: " + this.jobNo + "</h4>"',  '<img src=\"'.url('images/icons/icon-job.png').'\" style=\"width:65px;height:auto;margin-top:-18px;\"/>' );


        $this->print_summary_template = 'job-register-summary-template';

        $this->print_template = [
            ['label'=>'Job Item','template'=>'job-register-item-template', 'modal'=>'xl'],
            ['label'=>'Summary','template'=> $this->print_summary_template , 'modal'=>'xl'],
        ];

        $this->print_modal_size = 'xl';

        $this->add_as_page = true;
        $this->edit_as_page = true;

        $this->add_filler = true;

        return parent::getIndex();
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sms.salesoperation.jobregister.form_layout';

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

        $this->title = __('Edit').' '.$item->jobNo;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sms.salesoperation.jobregister.form_layout';

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

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['jobStatusOptions'] = RefUtil::toOptions(RefUtil::getJobStatus('jobStatus'),'name','name', true);
        $formOptions['bidStatusOptions'] = RefUtil::toOptions(RefUtil::getJobStatus('bidStatus'),'name','name', true);
        $formOptions['operatorOptions'] = config('app.params.equalityOperator');

        $formOptions['custIncotermsOptions'] = SmsUtil::toOptions(SmsUtil::getIncoterm(),['name','description'],'name', false);
        $formOptions['pricipalIncoOptions'] = SmsUtil::toOptions(SmsUtil::getIncoterm(),['name','description'],'name', false);
        $formOptions['participatingCompanyOptions'] = SmsUtil::toOptions(RefUtil::getGroupCompany(),['companyCode','companyName'],'companyCode', true);
        $formOptions['scopeOptions'] = RefUtil::toOptions(RefUtil::getScope('Job Register'),'name','name', true);
        $formOptions['areaOptions'] = [ [ 'text'=> "", 'value'=> "" ], [ 'text'=> "Jakarta", 'value'=> "Jakarta" ], [ 'text'=> "Balikpapan", 'value'=> "Balikpapan" ] ];
        $formOptions['statusOptions'] = [ ['text' => "Firm Buying", 'value' => "Firm Buying"] , ['text' => "Budgetary", 'value' => "Budgetary"] ];
        $formOptions['typeOfSupplyOptions'] = [ ['text' => "Materials", 'value' => "Materials"] , ['text' => "Services", 'value' => "Services"], ['text' => "Material & Services", 'value' => "Material & Services"] ];

        $formOptions['withPrebidMeetingOptions'] = [ [ 'text'=> "Yes", 'value'=> true ], [ 'text'=> "No", 'value'=> false ] ];
        $formOptions['partialQuoteOptions'] = [ [ 'text'=> "Not allowed", 'value'=> "Not allowed" ], [ 'text'=> "Allowed", 'value'=> "Allowed" ] ];
        $formOptions['partialDeliveryOptions'] = [ [ 'text'=> "Not allowed", 'value'=> "Not allowed" ], [ 'text'=> "Allowed", 'value'=> "Allowed" ] ];
        $formOptions['alternativeQuotationOptions'] = [ [ 'text'=> "Not allowed", 'value'=> "Not allowed" ], [ 'text'=> "Allowed", 'value'=> "Allowed" ] ];

        $formOptions['amlOptions'] = [ [ 'text'=> "As per AML", 'value'=> "As per AML" ], [ 'text'=> "Open Brand", 'value'=> "Open Brand" ] ];

        $formOptions['ownerEstimateCurrencyOptions'] = [ [ 'text'=> "IDR", 'value'=> "IDR" ], [ 'text'=> "USD", 'value'=> "USD" ], [ 'text'=> "EUR", 'value'=> "EUR" ] ];
        $formOptions['quotationCurrencyOptions'] = [ [ 'text'=> "IDR", 'value'=> "IDR" ], [ 'text'=> "USD", 'value'=> "USD" ], [ 'text'=> "EUR", 'value'=> "EUR" ] ];
        $formOptions['awardPoCurrencyOptions'] = [ [ 'text'=> "IDR", 'value'=> "IDR" ], [ 'text'=> "USD", 'value'=> "USD" ], [ 'text'=> "EUR", 'value'=> "EUR" ] ];

        $formOptions['masterListOptions']  = [ [ 'text'=> "No", 'value'=> "No" ], [ 'text'=> "Yes", 'value'=> "Yes" ] ];
        $formOptions['bidDeliveryPeriodOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['bidWarrantyPeriodOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['principalDeliveryPeriodOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['principalWarrantyPeriodOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['itbIkppValidityPeriodOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];

        $formOptions['sourceStatusOptions'] = [ [ 'text'=> "EX PRODUCTION - IMPORT", 'value'=> "EX PRODUCTION - IMPORT" ], [ 'text'=> "EX PRODUCTION - LOCAL", 'value'=> "EX PRODUCTION - LOCAL" ], [ 'text'=> "EX STOCK - IMPORT", 'value'=> "EX STOCK - IMPORT" ], [ 'text'=> "EX STOCK - LOCAL", 'value'=> "EX STOCK - LOCAL" ] ];
        $formOptions['shipmentByOptions'] = [ [ 'text'=> "Land Freight", 'value'=> "Land Freight" ], [ 'text'=> "Sea Freight", 'value'=> "Sea Freight" ], [ 'text'=> "Air Freight", 'value'=> "Air Freight" ], [ 'text'=> "Pick Up", 'value'=> "Pick Up" ]  ] ;

        $formOptions['bidBondPeriodUnitOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['performBondPeriodUnitOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['warrantyBondPeriodUnitOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];
        $formOptions['penaltyMaxPeriodUnitOptions'] = [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ];

        $formOptions['participatingCompanyFilterOptions'] = $formOptions['participatingCompanyOptions'] ;
        $formOptions['statusFilterOptions'] = [ [ 'text'=> "", 'value'=> "" ],[ 'text'=> "Firm Buying", 'value'=> "Firm Buying" ], [ 'text'=> "Budgetary", 'value'=> "Budgetary" ] ];
        $formOptions['areaFilterOptions'] = [ [ 'text'=> "", 'value'=> "" ], [ 'text'=> "Jakarta", 'value'=> "Jakarta" ], [ 'text'=> "Balikpapan", 'value'=> "Balikpapan" ] ];

        $formOptions['docCategoryMap'] = RefUtil::getDocCategoryMap();
        $formOptions['docTopicMap'] = RefUtil::getDocTopicMap();



        $formOptions['principalTermsTopics'] = DmsUtil::toOptions( RefUtil::getDocCategory('Principal Terms'), 'Category', '_object', false );
        $formOptions['bidDocumentTopics'] = DmsUtil::toOptions( RefUtil::getDocCategory('Bid Documents'), 'Category', '_object', false );
        $formOptions['commercialTopics'] = DmsUtil::toOptions( RefUtil::getDocCategory('Commercial'), 'Category', '_object', false );

        $formOptions['docHistory'] = [];
        $formOptions['docHistoryTitle'] = '""';

        $years = [];
        foreach (range( 1997, 2050 ) as $yr){
            $years[] = [ 'text'=>$yr, 'value'=>$yr ];
        }

        $formOptions['bidYearOptions'] = $years;

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }


    public function setupInjector($uiOptions, $data = null)
    {
        $uiOptions = Injector::setObject('showPost') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    [ 'label'=>'', 'key'=>'Judul', 'class'=>'text-100'],
                    [ 'label'=>'', 'key'=>'Dokumen'],


                ]
            )->setObjDef( // set object default
                [
                    'Judul'=>'',
                    'Dokumen'=>'',
                ]
            )
            ->setObjTemplate(file_get_contents( resource_path('views/sms/salesoperation/jobregister/doc.html') )) // set template
            ->injectObject($uiOptions); // inject into uiOption array
        //end $picContacts
        $uiOptions = Injector::setObject('technicalClarification') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    [ 'label'=>'', 'key'=>'docType', 'class'=>'text-100'],
                    [ 'label'=>'', 'key'=>'docRef', 'class'=>'text-100'],
                    [ 'label'=>'', 'key'=>'docDate', 'class'=>'text-100'],
                    [ 'label'=>'', 'key'=>'Subject', 'class'=>'text-100'],
                    [ 'label'=>'', 'key'=>'callCode', 'class'=>'text-100']
                ]
            )->setObjDef( // set object default
                [
                    'docType'=>'',
                    'docRef'=>'',
                    'docDate'=> '',
                    'Subject'=> '',
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                ]
            )
            ->setObjTemplate(file_get_contents( resource_path('views/sms/salesoperation/jobregister/doc.html') )) // set template
            ->injectObject($uiOptions); // inject into uiOption array
        //end $picContacts
        //start $picContacts
        // use injector to provide parameter for simpletablemodaltemplate / simpletable
        $uiOptions = Injector::setObject('invitationToBid') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Doc. Type', 'key' => 'DocType', 'class' => 'text-100'],
                    ['label' => 'Doc. Date', 'key' => 'DocDate', 'class' => 'text-100'],
                    ['label' => 'Doc. Ref', 'key' => 'DocRef', 'class' => 'text-100'],
                    ['label' => 'Subject', 'key' => 'Subject', 'class' => 'text-100'],
                    ['label' => 'Call Code', 'key' => 'FCallCode', 'class' => 'text-100']
                ]
            )->setObjDef( // set object default
                [
                    'DocDate' => '',
                    'DocRef' => '',
                    'Subject' => '',
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate(file_get_contents(resource_path('views/sms/salesoperation/jobregister/item.html'))) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $principalTermsTemplate = Util::inflateYmlForm( 'principal_term_controller','models/controllers/sms/salesoperation/job_register', 'sms/salesoperation/jobregister/principal_term' );

        $uiOptions = Injector::setObject('principalTerms') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Quot. No', 'key' => 'quotationNo', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Quot. Date', 'key' => 'quotationDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Topic', 'key' => 'quotationTopic', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Source Status', 'key' => 'sourceStatus', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Source Coy', 'key' => 'sourcingCompany', 'class' => 'text-125 pl-0 pr-0'],
                    ['label' => 'Brand', 'key' => 'brand', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Incoterm', 'key' => 'pricipalInco', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Shipment By', 'key' => 'shipmentBy', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Delivery Point', 'key' => 'principalDeliveryPoint', 'class' => 'text-125'],
                    ['label' => 'Delivery', 'key' => 'principalDeliveryTime', 'class' => 'text-center text-50  pl-0 pr-0'],
                    ['label' => '', 'key' => 'principalDeliveryPeriod', 'class' => 'text-50 pl-0 pr-0'],
                    ['label' => 'Warranty', 'key' => 'principalWarrantyTime', 'class' => 'text-center text-75 pl-0 pr-0'],
                    ['label' => '', 'key' => 'principalWarrantyPeriod', 'class' => 'text-50 pl-0 pr-0']
                ]
            )->setObjDef( // set object default
                [
                    'quotationNo'=> '',
                    'quotationDate'=> '',
                    'quotationTopic'=> 'O-QT-01',
                    'sourceStatus' => '',
                    'brand' => '',
                    'sourcingCompany' => '',
                    'pricipalInco' => '',
                    'shipmentBy' => '',
                    'principalDeliveryTime' => '',
                    'principalDeliveryPeriod' => '',
                    'principalWarrantyTime' => '',
                    'principalWarrantyPeriod' => '',
                    'principalDeliveryPoint' => '',
                    'quotationCategoryOptions' => DmsUtil::toOptions( RefUtil::getDocCategory('Principal Terms'), 'Category', 'Category', false ),
                    'pricipalIncoOptions' => SmsUtil::toOptions(SmsUtil::getIncoterm(),['name','description'],'name', false),
                    'principalDeliveryPeriodOptions' => [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ],
                    'principalWarrantyPeriodOptions' => [ [ 'text'=> "Days", 'value'=> "Days" ], [ 'text'=> "Weeks", 'value'=> "Weeks" ], [ 'text'=> "Months", 'value'=> "Months" ] ],
                    'sourceStatusOptions' => [ [ 'text'=> "EX PRODUCTION - IMPORT", 'value'=> "EX PRODUCTION - IMPORT" ], [ 'text'=> "EX PRODUCTION - LOCAL", 'value'=> "EX PRODUCTION - LOCAL" ], [ 'text'=> "EX STOCK - IMPORT", 'value'=> "EX STOCK - IMPORT" ], [ 'text'=> "EX STOCK - LOCAL", 'value'=> "EX STOCK - LOCAL" ] ],
                    'shipmentByOptions' => [ [ 'text'=> "Land Freight", 'value'=> "Land Freight" ], [ 'text'=> "Sea Freight", 'value'=> "Sea Freight" ], [ 'text'=> "Air Freight", 'value'=> "Air Freight" ], [ 'text'=> "Pick Up", 'value'=> "Pick Up" ]  ],
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $principalTermsTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $commercialTemplate = Util::inflateYmlForm( 'commercial_controller','models/controllers/sms/salesoperation/job_register', 'sms/salesoperation/jobregister/commercial_term' );

        $uiOptions = Injector::setObject('commercial') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Document Type', 'key' => 'DocType', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Topic', 'key' => 'Topic', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Document Date', 'key' => 'DocDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Document Ref', 'key' => 'DocRef', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Job Number', 'key' => 'jobNo', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Currency', 'key' => 'currency', 'class' => 'text-50 pl-0 pr-0'],
                    ['label' => 'Amount', 'key' => 'amount', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Call Code', 'key' => 'FCallCode', 'class' => 'text-150 pl-0 pr-0']
                ]
            )->setObjDef( // set object default
                [
                    'DocType'=> '',
                    'Topic'=> '',
                    'DocDate'=> '',
                    'DocRef' => '',
                    'jobNo' => '',
                    'currency' => 'IDR',
                    'amount' => '',
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                    'DocTypeOptions' => DmsUtil::toOptions( RefUtil::getDocCategory('Commercial'), 'Category', 'Category', false ),
                    'currencyOptions' => [ [ 'text'=> "IDR", 'value'=> "IDR" ], [ 'text'=> "USD", 'value'=> "USD" ], [ 'text'=> "EUR", 'value'=> "EUR" ] ],
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $commercialTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $bidDocumentTemplate = Util::inflateYmlForm( 'biddocument_controller','models/controllers/sms/salesoperation/job_register', 'sms/salesoperation/jobregister/biddocument_term' );

        $uiOptions = Injector::setObject('bidDocument') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Document Type', 'key' => 'DocType', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Topic', 'key' => 'Topic', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Document Date', 'key' => 'DocDate', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Document Ref', 'key' => 'DocRef', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Job Number', 'key' => 'jobNo', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Subject', 'key' => 'subject', 'class' => 'text-50 pl-0 pr-0'],
                    ['label' => 'Call Code', 'key' => 'FCallCode', 'class' => 'text-150 pl-0 pr-0']
                ]
            )->setObjDef( // set object default
                [
                    'DocType'=> '',
                    'Topic'=> '',
                    'DocDate'=> '',
                    'DocRef' => '',
                    'jobNo' => '',
                    'subject' => '',
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                    'DocTypeOptions' => DmsUtil::toOptions( RefUtil::getDocCategory('Bid Documents'), 'Category', 'Category', false ),
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $bidDocumentTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $followUpTemplate = Util::inflateYmlForm( 'followup_controller','models/controllers/sms/salesoperation/job_register', 'sms/salesoperation/jobregister/followup_term' );

        $uiOptions = Injector::setObject('followUp') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    ['label' => 'Follow Up Date', 'key' => 'followUpDate', 'class' => 'text-75 pl-0 pr-0'],
                    ['label' => 'Contact Person', 'key' => 'contactPerson', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Contact Designation', 'key' => 'contactDesignation', 'class' => 'text-125 pl-0 pr-0'],
                    ['label' => 'Follow Up Notes', 'key' => 'followUpNotes', 'class' => 'text-200 pl-0 pr-0'],
                    ['label' => 'Follow Up By', 'key' => 'followUpBy', 'class' => 'text-100 pl-0 pr-0'],
                    ['label' => 'Call Code', 'key' => 'FCallCode', 'class' => 'text-150 pl-0 pr-0']
                ]
            )->setObjDef( // set object default
                [
                    'followUpDate'=> '',
                    'contactPerson' => '',
                    'contactDesignation' => '',
                    'followUpNotes' => '',
                    'followUpBy' => '',
                    'FCallCode' => '',
                    'docId' => '',
                    'docCallCode' => '',
                    'jobNo' => '',
                    'DocTypeOptions' => DmsUtil::toOptions( DmsUtil::getDocType(), 'DocType', 'DocType', false ),
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate( $followUpTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array


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

        $uiOptions = Injector::setObject('jobStatusChange') // name variable / field yang akan diinject
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
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('jobStatus'),'name','name', false),
            ]
        )->setObjParams(
            [
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('jobStatus'),'name','name', false),
            ]
        )
            //->setObjTemplate(view('sms.dialogs.change_bid_status')->render() ) // set template
            ->setObjTemplate( $changeStatusTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        $changeRemarkTemplate = Util::inflateYmlForm( 'changestatus_controller','models/controllers/sms/dialogs', 'sms/dialogs/change_job_remark' );

        $uiOptions = Injector::setObject('jobRemarkChange') // name variable / field yang akan diinject
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
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('jobStatus'),'name','name', false),
            ]
        )->setObjParams(
            [
                'changeStatusToOptions' => RefUtil::toOptions(RefUtil::getJobStatus('jobStatus'),'name','name', false),
            ]
        )
            //->setObjTemplate(view('sms.dialogs.change_bid_status')->render() ) // set template
            ->setObjTemplate( $changeRemarkTemplate ) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }


    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'Item';
//        $this->defOrderDir = 'asc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;
        if( $adv && $ext &&  (isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){
            // query hanya dilakukan jika advanced search aktif dan panel terbuka
            $model = $this->advQuery($model , $ext);
        }

        return $model;
    }

    public function advQuery($model , $ext){

        $bidStatusOp = $ext['bidStatusOp'] ?? 'EQ';
        $jobStatusOp = $ext['jobStatusOp'] ?? 'EQ';


        if( isset($ext['area']) && $ext['area'] != '' ){
            $model = $model->where('area','=',$ext['area']);
        }
        if( isset($ext['jobNo']) && $ext['jobNo'] != '' ){
            $model = $model->where('jobNo','like', '%'.$ext['jobNo'].'%');
        }
        if( isset($ext['participatingCompany']) && $ext['participatingCompany'] != '' ){
            $model = $model->where('participatingCompany','=',$ext['participatingCompany']);
        }
        if( isset($ext['status']) && $ext['status'] != '' ){
            $model = $model->where('status','=',$ext['status']);
        }
        if( isset($ext['bidStatus']) && $ext['bidStatus'] != '' ){
            if($bidStatusOp == 'EQ'){
                $model = $model->where('bidStatus','=',$ext['bidStatus']);
            }else{
                $model = $model->where('bidStatus','!=',$ext['bidStatus']);
            }
        }
        if( isset($ext['jobStatus']) && $ext['jobStatus'] != '' ){
            if($jobStatusOp == 'EQ'){
                $model = $model->where('jobStatus','=',$ext['jobStatus']);
            }else{
                $model = $model->where('jobStatus','!=',$ext['jobStatus']);
            }
        }
        if( isset($ext['project']) && $ext['project'] != '' ){
            $model = $model->where('project','like','%'.$ext['project'].'%');
        }
        if( isset($ext['company']) && $ext['company'] != '' ){
            $model = $model->where('company','like','%'.$ext['company'].'%');
        }
        if( isset($ext['projectOwner']) && $ext['projectOwner'] != '' ){
            $model = $model->where('projectOwner','like','%'.$ext['projectOwner'].'%');
        }
        if( isset($ext['scope']) && $ext['scope'] != '' ){
            $model = $model->where('scope','like','%'.$ext['scope'].'%');
        }
        if( isset($ext['brand']) && $ext['brand'] != '' ){
            $model = $model->where('brand','like','%'.$ext['brand'].'%');
        }
        if( isset($ext['bidYear']) && $ext['bidYear'] != '' ){

            $model = $model->where(function($q) use($ext) {

                $start = Carbon::make( $ext['bidYear'].'-01-01' )->startOfYear();

                if($ext['bidYear'] == $ext['bidYearUntil']){
                    $end = Carbon::make( $ext['bidYear'].'-01-01' )->endOfYear();
                }else{
                    $end = Carbon::make( $ext['bidYearUntil'].'-01-01' )->endOfYear();
                }

                $q->where('inquiryDate','like','%'.$ext['bidYear'].'%')
                    ->orWhereBetween( 'inquiryDate', [$start, $end]);
            });

        }

        $model = $model->orderBy('participatingCompany', 'asc')
            ->orderBy('status', 'asc')
            ->orderBy('inquiryDate', 'desc')
            ->orderBy('jobNo', 'desc');

        return $model;
    }

    /**
     *
     * orderBy('participatingCompany', 'asc' )
      *          ->orderBy('inquiryDate', 'desc')
        *        ->orderBy('area', 'asc');
     */
    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        $data['Urut'] = intval($data['Urut']);
        return parent::beforeSave($data);
    }


    public function getParam()
    {
        $today = date('Y-m-d H:i:s', time());
//        $this->def_param['DocType'] = 'Invitation To Bid';
//        $this->def_param['jobStatus'] = 'In Progress';
//        $this->def_param['currency'] = 'IDR';
//        $this->def_param['ownerEstimateCurrency'] = 'IDR';
//        $this->def_param['quotationCurrency'] = 'IDR';
//        $this->def_param['awardPoCurrency'] = 'IDR';
//        $this->def_param['xrate'] = 15000;
//        $this->def_param['actualDelivery'] = $today;
//        $this->def_param['requestDelivery'] = $today;

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {
        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {
        $data['requestDelivery'] = ImportUtil::excelDateToNormal($data['requestDelivery']);
        $data['actualDelivery'] = ImportUtil::excelDateToNormal($data['actualDelivery']);
        $data['bidOpeningDate'] = ImportUtil::excelDateToNormal($data['bidOpeningDate']);
        $data['bidSubmission'] = ImportUtil::excelDateToNormal($data['bidSubmission']);

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function postDlxl(Request $request)
    {
        $this->collection_name = 'job_register';
        $this->connection_name = 'mongodb';
        return parent::postDlxl($request); // TODO: Change the autogenerated stub
    }

    public function prepareXlsHeadings($data, $template, $request)
    {
        $data = [
            'no'=>'No',
            'jobNo'=>'Job No',
            'participatingCompany'=>"Company",
            'area'=>"Area",
            'inquiryDate'=>"Inquiry Date",
            'rfqReference'=>"RFQ Reference",
            'project'=>"Project",
            'scope'=>"Scope",
            'company'=>"Buying Company",
            'projectOwner'=>"Project End User",
            'quotationNo'=>"Quotation No.",
            'commercialDate'=>"Quotation Date",
            'quotationCurrency'=>"Quotation Curr.",
            'quotationAmount'=>"Quotation Amount",
            'awardPoNo'=>"Client PO No.",
            'awardPoNoDate'=>"Client PO Date",
            'awardPoCurrency'=>"PO Curr.",
            'awardPoAmount'=>"PO Amount",
            'bidStatus'=>"Bid Status",
            'bidStatusRemarks'=>"Bid Status Remarks",
            'jobStatus'=>"Job Status",
            'jobStatusRemarks'=>"Job Status Remarks",
        ];
        return $data;
        //return parent::prepareXlsHeadings($data, $template, $request); // TODO: Change the autogenerated stub
    }

    public function prepareXlsRows($data, $headings, $template, $request)
    {
        $rows = $data->content;

        $exrows = [];
        $count = 1;
        foreach($rows as $r){
            $exrows[] = [
                'no'=>$count,
                'jobNo'=> ($r['jobNo'] ?? ''),
                'participatingCompany'=> ( $r['participatingCompany'] ?? '-' ),
                'area'=> ( $r['area'] ?? '-' ),
                'inquiryDate'=>( TimeUtil::formatDate($r['inquiryDate'], 'm/d/Y' ) ?? '-' ),
                'rfqReference'=>( $r['rfqReference'] ?? '-' ),
                'project'=>( $r['project'] ?? '-' ),
                'scope'=>( $r['scope'] ?? '-' ),
                'company'=>( $r['company'] ?? '-' ),
                'projectOwner'=>( $r['projectOwner'] ?? '-' ),
                'quotationNo'=>( $r['quotationNo'] ?? '-' ),
                'commercialDate'=>( TimeUtil::formatDate($r['commercialDate'], 'm/d/Y')  ?? '-' ),
                'quotationCurrency'=>( $r['quotationCurrency'] ?? '' ),
                'quotationAmount'=>( $r['quotationAmount'] ?? 0 ),
                'awardPoNo'=>( $r['awardPoNo'] ?? '-' ),
                'awardPoNoDate'=>( TimeUtil::formatDate($r['awardPoNoDate'], 'm/d/Y')  ?? '-' ),
                'awardPoCurrency'=>( $r['awardPoCurrency'] ?? '' ),
                'awardPoAmount'=>( $r['awardPoAmount'] ?? 0 ),
                'bidStatus'=>( $r['bidStatus'] ?? '-' ),
                'bidStatusRemarks'=>( $r['bidStatusRemarks'] ?? '-' ),
                'jobStatus'=>( $r['jobStatus'] ?? '-' ),
                'jobStatusRemarks'=>( $r['jobStatusRemarks'] ?? '-' ),
            ];
            $count++;
        }

        $data = $exrows;
        return $data;

        //return parent::prepareXlsRows($data, $headings, $template, $request); // TODO: Change the autogenerated stub
    }


    public function postChgStat(Request $request)
    {
        $auth = $request->get('auth');
        $aux = $request->get('aux');
        $data = $request->get('data');

        if( Hash::check($auth, Auth::user()->pin) ){

            $obj = JobRegister::find($aux['id']);
            if($obj){
                $field = $aux['field'];
                $obj->{$field} = $data['changeStatusTo'];
                $obj->{$field.'Remarks'} = $data['changeRemarks'];
                $obj->{$field.'Date'} = $data['changeDate'];

                if($obj->save())
                {
                    Util::log(Auth::user()->toArray(), $request->url(), 'CHANGE_STATUS' ,$request->toArray(), 'SUCCESS', $this->auth_entity, Auth::user()->id );
                    Util::statuslog(Auth::user()->toArray(), $data, $this->entity , $this->auth_entity, $aux['id'] );

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

    public function postChgRemark(Request $request)
    {
        $auth = $request->get('auth');
        $aux = $request->get('aux');
        $data = $request->get('data');

        if( Hash::check($auth, Auth::user()->pin) ){

            $obj = JobRegister::find($aux['id']);
            if($obj){

                $obj->jobRemark = $data['changeRemarks'];
                $obj->jobRemarkDate = $data['changeDate'];

                $rem = [
                    'jobRemark' => $data['changeRemarks'],
                    'jobRemarkDate' => $data['changeDate'],
                    'changeBy'=>$data['changeBy'],
                ];

                $progs = $obj->progressRemarks ?? [];
                $progs[] = $rem;

                $obj->progressRemarks = $progs;

                $data['currentStatus'] = $data['currentStatus'] ?? '';
                $data['changeStatusTo'] = $data['changeStatusTo'] ?? '';

                if($obj->save())
                {
                    Util::log(Auth::user()->toArray(), $request->url(), 'CHANGE_REMARK' ,$request->toArray(), 'SUCCESS', $this->auth_entity, Auth::user()->id );
                    Util::statuslog(Auth::user()->toArray(), $data, $this->entity , $this->auth_entity, $aux['id'] );

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

    public function postGetSeq(Request $request)
    {
        $entity = $request->get('entity');
        $company = $request->get('company');

        if( $request->has('padding') ){
            $padding = $request->get('padding')??env('NUM_PAD', 3);
        }else{
            $padding = env('NUM_PAD', 3);
        }

        if( is_null($entity) && $entity != ''){
            $seq = false;
        }else{
            $rec = $this->model->where('jobNoPrefix', '=', $entity)->max('Urut');
            $seq = $rec + 1;
        }

        if($seq){
            return response()->json([
                'result'=>'OK',
                'entity'=>$entity,
                'seq'=>$seq,
                'padded'=> str_pad($seq, $padding , '0', STR_PAD_LEFT )
            ]);

        }else{
            return response()->json([
                'result'=>'ERR',
                'msg'=>'NOENTITY'
            ]);
        }
    }

    public function beforeSetPrintData(array $data, $template, $request = null)
    {
        if($template == 'job-register-summary-template'){
            $dm = new JobRegister();
            $this->print_as_pdf = true;
            $selection = $request->get('data');
            if(empty($data)){
                if($request->has('serverParams')){
                    $sp = $request->get('serverParams');
                    if(isset($sp['searchTerm']) && $sp['searchTerm'] != ''){

                        $sk = $sp['searchTerm'];

//                    if(strpos($this->yml_file, '_controller') === false){
//                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();
//                    }else{
                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();
//                    }

                        $dm = $this->filterBs4($dm, $sk, $searchFields);
                    }

                    if(isset($sp['extraData']) ){
                        $ext = $sp['extraData'];
                        $dm = $this->advQuery($dm , $ext);
                    }

                }

                $data = $dm->get();
                $data = $data->toArray();
            }


        }

        return parent::beforeSetPrintData($data, $template, $request); // TODO: Change the autogenerated stub
    }

    public function getHistory(Request $request){

        $id = $request->get('itemId');
        $status = $request->get('status', 'all');

        if($status == 'all'){
            $history = ChangeStatusLog::where('item', '=', $id)
                ->orderBy('createdAt','desc')
                ->get();
        }else{
            $history = ChangeStatusLog::where('itemId', '=', $id)
                ->where('changeTo','=', strtoupper($status))
                ->orderBy('createdAt','desc')
                ->get();
        }

        if($history){
            return response()->json(
                [
                    'result'=>'OK',
                    'msg'=>'OK',
                    'data'=>$history->toArray()
                ],
                200
            );
        }else{
            return response()->json(
                [
                    'result'=>'ERR',
                    'msg'=>'ERR',
                    'data'=>[]
                ],
                415
            );

        }

    }


}
