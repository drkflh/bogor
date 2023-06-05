<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Sms\ProcurementLogistic;

use App\Helpers\App\DmsUtil;
use App\Helpers\Injector;
use App\Helpers\App\SmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Helpers\WorkflowUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Sms\ProcurementLogistic\PurchaseRequisition;
use App\Models\Reference\ExchangeRate;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PurchaseRequisitionController extends AdminController

{

    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/sms/procurementlogistic';
        $this->yml_file = 'purchaserequisition_controller';

        $this->entity = 'Purchase Request';
        $this->auth_entity = 'purchase-requisition';

        $this->controller_base = 'sms/procurement-logistics/purchase-requisition';

        $this->view_base = 'sms.procurementlogistic.purchaserequisition';

        $this->with_workflow = true;

        $this->model = new PurchaseRequisition();

        $this->print_template = 'purchase-request-template';
        $this->print_modal_size = 'xl';

    }

    public function getIndex()
    {
        $this->title = '<img class="d-none d-md-inline-block"  style="width:38px;height:auto;margin-top:-10px;margin-right:3px" src="'.url('images/icons/purchasereq.png').'" /> Purchase Request Register';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;

        $this->viewer_layout = 'sms.procurementlogistic.purchaserequisition.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sms.procurementlogistic.purchaserequisition.formlayout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_clone = false;
        $this->can_multi_clone = false;

        $this->view_item_url = $this->controller_base.'/pdf';

        $this->viewer_as_document = false;

        $this->add_as_page = true;
        $this->edit_as_page = true;
        $this->revise_as_page = true;
        $this->view_as_page = true;

        $this->add_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ "%s : Purchase Requisition" + "</h4></div>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:42px;height:auto;\"/>', __('Add') );
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">%s "+" PR "+ this.jobNo + "</h4></div>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:42px;height:auto;\"/>', __('View') );
        $this->update_title_fields = sprintf('"<h4>%s %s "  + " PR " + this.jobNo + "</h4>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:50px;height:auto;margin-top:-18px;\"/>', __('Edit') );

        return parent::getIndex();
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'sms.procurementlogistic.purchaserequisition.formlayout';

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

        $this->item_id = $id;

        $this->title = __('Edit').' '.$item->requestNo;

        /* Use custom form layout */
        $this->form_layout = 'sms.procurementlogistic.purchaserequisition.formlayout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_redirect_after_save = true;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getRevise(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $id;

        $this->title = __('Revise').' '.$item->requestNo;

        /* Use custom form layout */
        $this->form_layout = 'sms.procurementlogistic.purchaserequisition.formlayout';

        $this->runAcl();
        $this->runUrlSet('revise');
        $this->runPageViewSet('revise');

        $this->page_redirect_after_save = true;

        return parent::getRevise($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $id;

        $this->title = __('View').' '.$item->requestNo;

        /* Use custom form layout */
        $this->viewer_view = 'form.viewhtml'; // use plain html
        $this->viewer_layout = 'sms.procurementlogistic.purchaserequisition.view_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('view');

        $this->viewer_can_print = true;

        $this->page_redirect_after_save = true;

        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['currencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(),'name','name', false);
        $formOptions['costCenterOptions'] = SmsUtil::toOptions(SmsUtil::getCostCenter(),'costCenterCode','costCenterCode', false);
        $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false);
        $formOptions['vendorObjectOptions'] = SmsUtil::toOptions( SmsUtil::getVendors(), 'vendorCode', '_object', true );
        $formOptions['companyObjectOptions'] = SmsUtil::toOptions( SmsUtil::getCompanies(), 'companyName', '_object', true );
        $formOptions['companyCodeOptions'] = SmsUtil::toOptions( SmsUtil::getCompanies(), 'companyName', 'companyCode', true );
        $formOptions['jobNoOptions'] = SmsUtil::toOptions(SmsUtil::getPrJobNumber(), ['jobNo', 'tenderTitle'], 'jobNo', true);

        $formOptions['companyCodeMap'] = SmsUtil::getCompanyCodeMap();

        $formOptions['incoTermOptions'] =SmsUtil::toOptions( SmsUtil::getIncoterm(), 'name', 'name', true );

        $formOptions['modaShipmentOptions'] = [
            [ 'text'=> 'Land Freight', 'value'=> 'Land Freight' ],
            [ 'text'=> 'Sea Freight', 'value'=> 'Sea Freight' ],
            [ 'text'=> 'Air Freight', 'value'=> 'Air Freight' ],
            [ 'text'=> 'Pick Up', 'value'=> 'Pick Up' ]
        ];

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupApprovalParams($formOptions)
    {
        $formOptions['reportByOptions'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['requestByOptions'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['recomendedByOptions'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['auditedByOptions'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['authorizedByOptions'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['reviewedBy1Options'] = WorkflowUtil::getDefaultApproverIds();
        $formOptions['reviewedBy2Options'] = WorkflowUtil::getDefaultApproverIds();

        $formOptions['reportByObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['requestByObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['recomendedByObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['auditedByObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['authorizedByObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['reviewedBy1ObjMap'] = WorkflowUtil::getDefaultApproverMap();
        $formOptions['reviewedBy2ObjMap'] = WorkflowUtil::getDefaultApproverMap();

        $formOptions['approvalDetailTemplate'] = '`'.view('sms.procurementlogistic.purchaserequisition.approvaldetail')->render().'`';
        $formOptions['approvalDetail'] = "{}";

        return $formOptions;
    }

    public function setupInjector($uiOptions, $data = null)
    {
        $uiOptions = Injector::setObject('details') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    [ 'label'=>'Product', 'key'=>'ProductID', 'class'=>'text-100' , 'type'=>'String' , 'validator'=>'required'  ],
                    [ 'label'=>'Descriptions', 'key'=>'Descriptions', 'class'=>'text-200', 'type'=>'String', 'validator'=>'required'  ],
                    [ 'label'=>'Notes', 'key'=>'Notes', 'class'=>'text-150', 'type'=>'String' , 'validator'=>''  ],
                    [ 'label'=>'Delivery', 'key'=>'Delivery', 'class'=>'text-75 text-center', 'type'=>'Number','format'=>'integer', 'validator'=>'required'  ],
                    [ 'label'=>'Period', 'key'=>'Period', 'class'=>'text-75 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                    [ 'label'=>'Qty', 'key'=>'QTY', 'class'=>'text-100 text-center', 'type'=>'Number', 'format'=>'integer' , 'validator'=>'required' ],
                    [ 'label'=>'UoM', 'key'=>'uom', 'class'=>'text-50 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                    [ 'label'=>'Unit Price', 'key'=>'UnitPrice', 'class'=>'text-150 text-right', 'type'=>'Number', 'format'=>'currency' , 'validator'=>'required' ],
                    [ 'label'=>'Amount Ordered', 'key'=>'AmountOrdered', 'class'=>'text-150 text-right', 'type'=>'Number', 'format'=>'currency' , 'validator'=>'' ]
                ]
            )->setObjDef( // set object default
                [
                    'ProductID'=>'',
                    'Descriptions'=>'',
                    'Notes'=>'',
                    'Delivery'=> 0,
                    'Period'=>'',
                    'QTY'=> 0,
                    'uom'=> '',
                    'UnitPrice'=> 0,
                    'AmountOrdered'=> 0
                ]
            )->setObjParams(
                [
                    'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
                ]
            )
            ->setObjTemplate(view('sms.procurementlogistic.purchaserequisition.doc')->render()) // set template
            ->injectObject($uiOptions); // inject

        //start $adddocument
        $uiOptions = Injector::setObject('addDocument') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
                    [ 'label'=>'Name', 'key'=>'Name', 'class'=>'text-100' , 'type'=>'String' ],
                ]
            )->setObjDef( // set object default
                [
                    'Name'=>'',
                ]
            )->setObjParams(
                [
                    'Name' => $formOptions['NameOptions'] = RefUtil::toOptions(RefUtil::getDocName(),'name','name', false),
                ]
            )
            ->setObjTemplate( view('sms.procurementlogistic.purchaserequisition.addDoc')->render() ) // set template
            ->injectObject($uiOptions); // inject

        //start $picContacts
        // use injector to provide parameter for simpletablemodaltemplate / simpletable
        $uiOptions = Injector::setObject('invitationToBid') // name variable / field yang akan diinject
            ->setObjFields( // mwnambahkan setting field untuk table
                [
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
                ]
            )
            ->setObjParams(
                [
                    'baseUrl' => url('/'),
                    'uploadUrl' => url('api/v1/core/upload')
                ]
            )
            ->setObjTemplate(file_get_contents(resource_path('views/sms/procurementlogistic/purchaserequisition/item.html'))) // set template
            ->injectObject($uiOptions); // inject into uiOption array

        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
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

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    public function beforeUpdateForm($population)
    {
        if(!isset($population['requestNoPrefix']) || $population['requestNoPrefix'] == '' ){
            $rp = explode('-', $population['requestNo'] );
            array_pop($rp);
            $rp = implode('-', $rp);
            $population['requestNoPrefix'] = $rp;
        }
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $currency = request()->get('curr');
        $curr = ExchangeRate::where('currencyCode', '=', trim($currency))->first();
        if($curr){
            $this->def_param = $curr->toArray();
        }
        $this->def_param['currency'] = 'IDR';
        $this->def_param['rev'] = 0;
        $this->def_param['UnitPrice'] = 'IDR';
        $this->def_param['discountSwitch'] = true;
        $this->def_param['discountPercentage'] = 0;
        $this->def_param['vat'] = 0;
        $this->def_param['total'] = 0;
        $this->def_param['totalDisc'] = 0;
        $this->def_param['totalVat'] = 0;
        $this->def_param['grandTotal'] = 0;

        $this->def_param['requestDate'] = Carbon::now(env('DEFAULT_TIME_ZONE'))->toDateString();

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function processApprovalData($data, $request)
    {
        $selected = $data['selectedApprovalItems'];

        $idx = 0;
        $decisionListObj = [];
        foreach ($selected as $sel){
//            print $sel['_id']."\r\n";
//            print_r($sel);
            $decision = $sel['decisionList'] ?? [];

            if($data['approvalSignature'] == 'specimen'){
                $data['approvalSignature'] = $this->getSpecimen();
            }

            if($data['approvalInitial'] == 'specimen'){
                $data['approvalInitial'] = $this->getSpecimen('initial');
            }

            $sign = [
                '_id'=> Auth::user()->_id,
                'approvalInitial'=> $data['approvalInitial'],
                'approvalSignature'=> $data['approvalSignature'],
                'changeDate'=> Carbon::now( env('DEFAULT_TIME_ZONE')),
                'changeRemarks'=> $data['changeRemarks'],
                'changeStatusTo'=> $data['changeStatusTo'],
                'currentStatus'=> $data['currentStatus'],
                'signType'=> $data['signType'],
                'decideAs'=> $sel['decideAs']
            ];

            $decision[] = $sign;

            $doc = $this->model->find($sel['_id']);
            if($doc){
                $doc->decisionList = $decision;
                // simple rule to make approval on one final approver ( authorizer )
                if( $sel['decideAs'] == 'authorizedBy' && $data['changeStatusTo'] == 'APPROVED'){
                    $doc->approvalStatus = $data['changeStatusTo'];
                    $doc->revLock = 1;
                }
                $doc->save();
                $decisionListObj[ $sel['_id'] ] = $decisionListObj[ $sel['_id'] ] ?? [];
                $decisionListObj[ $sel['_id'] ] = $sign;
            }

        }

        $data['decisionList'] = $decisionListObj;

        return parent::processApprovalData($data, $request); // TODO: Change the autogenerated stub
    }


    public function approvalItemQuery($model, Request $request)
    {
        $model = $model->where('requestByObj.value.email', '=', Auth::user()->email)
            ->orWhere('authorizedByObj.value.email', '=', Auth::user()->email)
            ->orWhere('auditedByObj.value.email', '=', Auth::user()->email)
            ->orWhere('recomendedByObj.value.email', '=', Auth::user()->email);

        return parent::approvalItemQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function approvalItemTransform($items)
    {
        $its = [];
        foreach ($items as $item){
            $item['approvalTitle'] = $item['requestNo'] ?? '-';
            $item['approvalDescription'] = $item['purposeOfPurchase'] ?? '-';

            $as = '';
            $sign = false;
            $initial = false;
            if ($item['reviewedBy1'] == Auth::user()->_id){
                $as = 'reviewedBy1';
                $initial = true;
            }
            if ($item['reviewedBy2'] == Auth::user()->_id){
                $as = 'reviewedBy2';
                $initial = true;
            }
            if ($item['requestBy'] == Auth::user()->_id){
                $as = 'requestBy';
                $sign = false;
            }
            if ($item['recomendedBy'] == Auth::user()->_id){
                $as = 'recomendedBy';
                $sign = true;
            }
            if ($item['auditedBy'] == Auth::user()->_id){
                $as = 'auditedBy';
                $sign = true;
            }
            if ($item['authorizedBy'] == Auth::user()->_id){
                $as = 'authorizedBy';
                $sign = true;
            }

            $item['decideAs'] = $as;
            $item['needSigning'] = $sign;
            $item['needReview'] = $initial;

            $its[] = $item;
        }

        $items = $its;

        return parent::approvalItemTransform($items); // TODO: Change the autogenerated stub
    }


    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        $as = false;
        $sign = false;
        $initial = false;
        $showpad = true;
        $approverName = Auth::user()->name;
        $changeDate = Carbon::now( env('DEFAULT_TIME_ZONE'))->toDateTimeString();
        if ( isset($row['reviewedBy1']) && ($row['reviewedBy1'] == Auth::user()->_id || $row['reviewedBy1'] == Auth::user()->name)){
            $as = 'reviewedBy1';
            $initial = true;
            $showpad = true;
        }
        if ( isset($row['reviewedBy2']) && ($row['reviewedBy2'] == Auth::user()->_id || $row['reviewedBy2'] == Auth::user()->name)){
            $as = 'reviewedBy2';
            $initial = true;
            $showpad = true;
        }
        if ( isset($row['requestBy']) && ($row['requestBy'] == Auth::user()->_id || $row['requestBy'] == Auth::user()->name)){
            $as = 'requestBy';
            $sign = true;
            $showpad = false;
        }
        if ( isset($row['recomendedBy']) && ($row['recomendedBy'] == Auth::user()->_id || $row['recomendedBy'] == Auth::user()->name)){
            $as = 'recomendedBy';
            $sign = true;
            $showpad = true;
        }
        if ( isset($row['auditedBy']) && ($row['auditedBy'] == Auth::user()->_id || $row['auditedBy'] == Auth::user()->name)){
            $as = 'auditedBy';
            $sign = true;
            $showpad = true;
        }
        if ( isset($row['authorizedBy']) && ($row['authorizedBy'] == Auth::user()->_id || $row['authorizedBy'] == Auth::user()->name)){
            $as = 'authorizedBy';
            $sign = true;
            $showpad = true;
        }

        $row['decideAs'] = $as;
        $row['decideAsTitle'] = \Illuminate\Support\Str::headline($as);
        $row['needSigning'] = $sign;
        $row['needReview'] = $initial;
        $row['showSignPad'] = $showpad;
        $row['approverName'] = $approverName;
        $row['changeDate'] = $changeDate;

        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    /** function untuk post get sequence purchase rquisition number */

    public function postGetSeq(Request $request)
    {
        $entity = $request->get('entity');

        $company = $request->get('company');

        if( $request->has('padding') ){
            $padding = $request->get('padding')??env('NUM_PAD', 1);
        }else{
            $padding = env('NUM_PAD', 1);
        }

        if( is_null($entity) && $entity != ''){
            $seq = false;
        }else{
            $rec = $this->model->where('PurchaseReqPrefix', '=', $entity)->max('purchaseSequence');
            $seq = $rec + 1;
        }

        //$seq = CedarUtil::getSequence($entity);

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

}
