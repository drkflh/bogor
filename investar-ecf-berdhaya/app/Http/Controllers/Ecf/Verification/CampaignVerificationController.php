<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Verification;

use App\Helpers\App\EcfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\App\MmsUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Helpers\RefUtil;
use App\Http\Controllers\Core\AdminController;
use App\Models\Ecf\BizProfile;
use App\Models\Ecf\Campaign;
use App\Models\Ecf\BizType;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CampaignVerificationController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf';

        $this->yml_file = 'campaignverification_controller';

        $this->entity = 'Verifikasi Kampanye';

        $this->auth_entity = 'campaign-verif';

        $this->controller_base = 'ecf/campaign/verif';

        $this->view_base = 'ecf.campaignverification';

        $this->title_fields = 'name';

        $this->model = new Campaign();
    }

    public function getIndex()
    {
        $this->title = 'Verifikasi Campaign';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
         * Set form layout
         */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.campaignverification.form_layout';
        $this->form_dialog_size = 'lg';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'ecf.campaignverification.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_multi_approve = false;
        //$this->with_advanced_search = false;
        $this->with_advanced_search = true;

        $this->add_as_page = true;
        $this->edit_as_page = true;
        // $this->can_add = false;
        $this->can_add = true;
        $this->can_approve = true;

        $this->add_filler = false;

        return parent::getIndex();
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        // $formOptions['approvalDetailTemplate'] = '`' . view('ecf.campaignverification.approvaldetail')->render() . '`';
        // $formOptions['approvalDetail'] = "{}";
        $masterId = Auth::user()->masterId ?? '';

        $formOptions['legalityOptions'] = [
            ['text'=>'YA', 'value'=>'YA'],
            ['text'=>'CONFIRMED', 'value'=>'CONFIRMED'],
        ];
        //Jenis Usaha
        $formOptions['bizTypeOptions'] = EcfUtil::toOptions( EcfUtil::getbizType(), 'name', 'name', false ) ;
        //Jalur Pemasaran
        $formOptions['marketingFunnelsOptions'] = EcfUtil::toOptions( EcfUtil::getmarketingFunnels(), 'name', 'name', false ) ;
        //Jenis Pendanaan
        $formOptions['typeOfFundingOptions'] = EcfUtil::toOptions( EcfUtil::getfundingType(), 'name', 'name', false ) ;

        $formOptions['bizCompanyTypeOptions'] = RefUtil::toOptions(RefUtil::getCompanyTypes(),'companyType','companyType', false);
        $formOptions['noOfBranchesOptions'] = RefUtil::toOptions(EcfUtil::getNoOfBranches(),'seq','seq', false);

        $formOptions['contractReferenceOptions'] = [
            ['text'=>'Memiliki', 'value'=>'Memiliki'],
            ['text'=>'Tidak Memiliki', 'value'=>'Tidak Memiliki'],
        ];
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }
    
    public function setupApprovalParams($formOptions)
    {

        $formOptions['approvalDetailTemplate'] = '`' . view('ecf.campaignverification.approvaldetail')->render() . '`';
        $formOptions['approvalDetail'] = "{}";

        $formOptions['docHistory'] = [];
        $formOptions['docHistoryTitle'] = '""';
        return $formOptions;
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add') . ' ' . $this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.campaignverification.form_layout';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge($uiOptions, $formOptions);

        $this->page_redirect_after_save = true;

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        //$this->title = __('Edit') . ' ' . $item->_id;
        $this->title = __('Edit') . ' ' . $item->name;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.campaignverification.form_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge($uiOptions, $formOptions);

        $this->page_redirect_after_save = true;

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
        $model = $model->where('campaignStatus', 'DRAFT')->orderBy('updatedAt', 'desc');
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

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function processApprovalData($data, $request)
    {
        $selected = $data['selectedApprovalItems'];

        $chg = $data['changeStatusTo'];
        $note = $data['changeRemarks'];
        $aux = $request->get('aux');

        $data['approvalStatus'] = $chg;
        $idx = 0;
        $decisionListObj = [];
        foreach ($selected as $sel) {
            //            print $sel['_id']."\r\n";
            //            print_r($sel);
            $decision = $sel['decisionList'] ?? [];

            if ($data['approvalSignature'] == 'specimen') {
                $data['approvalSignature'] = $this->getSpecimen();
            }

            if ($data['approvalInitial'] == 'specimen') {
                $data['approvalInitial'] = $this->getSpecimen('initial');
            }

            $today =  Carbon::now()->toDateTimeString();
            $sign = [
                '_id' => Auth::user()->_id,
                'approvalInitial' => $data['approvalInitial'],
                'approvalSignature' => $data['approvalSignature'],
                'changeDate' => Carbon::now(env('DEFAULT_TIME_ZONE'))->toDateTimeString(),
                'createdAt' => $today,
                'changeRemarks' => $data['changeRemarks'],
                'changeStatusTo' => $data['changeStatusTo'],
                'changeTo' => $data['approvalStatus'],
                'currentStatus' => $data['currentStatus'],
                'signType' => $data['signType'],
                'actorName' => Auth::user()->name,
                'decideAs' => $sel['decideAs']
            ];

            $decision[] = $sign;

            $doc = $this->model->find($sel['_id']);
            if ($doc) {
                $doc->decisionList = $decision;
                $doc->campaignStatus = $data['approvalStatus'];
                $doc->approvalStatus = $data['approvalStatus'];
                $doc->revLock = 1;
                $doc->save();
                $decisionListObj[$sel['_id']] = $decisionListObj[$sel['_id']] ?? [];
                $decisionListObj[$sel['_id']] = $sign;
            }
        }

        $data['decisionList'] = $decisionListObj;
        
        $obj = $this->model::find($aux['id']);
        $nameandemail = User::where('_id', '=',  $obj['ownerId'])->first();
        $email = $nameandemail->email;
        $name = $nameandemail->name;

            $rec['to'] =  $email;
            $rec['name'] = $name;
            $rec['cc'] = [];
            $rec['bcc'] = [];

            $datas['role'] = 'Penyelenggara';
            if ($data['approvalStatus'] == 'VERIFIED') {
                $datas['type'] = 'CAMPAIGN-VERIFIED';
            }
            if ($data['approvalStatus'] == 'DECLINED') {
                $datas['type'] = 'CAMPAIGN-DECLINED';
                $datas['declinedNote'] = $note;
            }
            
            $datas['campaignTitle'] = $obj['campaignTitle'];
            $datas['ownerName'] = $name;
            $datas['campaignStatus'] = $data['approvalStatus'];
            
            $title = "Campaign Verification";
            if ($data['approvalStatus'] == 'VERIFIED') {
                MmsUtil::sendEmail($rec, $title , $datas, 'verification-campaign');
            }
            if ($data['approvalStatus'] == 'DECLINED') {
                MmsUtil::sendEmail($rec, $title , $datas, 'declined-campaign');
            }
                
            $rec_users = User::where('_id',  $obj['ownerId'])
            ->get();
            if ($data['approvalStatus'] == 'VERIFIED') {
                MmsUtil::sendNotification($rec_users, \App\Notifications\RecipientNotification::class, $obj, 'CAMPAIGN-VERIFIED');
            }
            if ($data['approvalStatus'] == 'DECLINED') {
                MmsUtil::sendNotification($rec_users, \App\Notifications\RecipientNotification::class, $obj, 'CAMPAIGN-DECLINED');
            }


        return parent::processApprovalData($data, $request); // TODO: Change the autogenerated stub
    }


    public function approvalItemTransform($items)
    {
        $its = [];
        foreach ($items as $item) {
            $item['approvalTitle'] = $item['name'] ?? '-';
            $item['approvalDescription'] = $item['approvalStatus'] ?? '-';

            $as = '';
            $initial = false;

            $as = 'auditedBy';
            $sign = false;

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
        $initial = false;
        $approverName = Auth::user()->name;
        $changeDate = Carbon::now(env('DEFAULT_TIME_ZONE'))->toDateTimeString();

        $as = 'verifBy';
        $sign = true;
        $showpad = false;

        $row['decideAs'] = $as;
        $title = $row['name'] ?? "-";
        $row['decideAsTitle'] = $title;
        $row['needSigning'] = $sign;
        $row['needReview'] = $initial;
        $row['showSignPad'] = $showpad;
        $row['approverName'] = $approverName;
        $row['changeDate'] = $changeDate;

        return parent::rowPostProcess($row);
    }

    public function getHistory(Request $request)
    {

        $id = $request->itemId;
        $history = $this->model::where('_id', '=', $id)->first();

        if ($history) {
            $this->def_param = $history->toArray();
            $decisionList = array_reverse($this->def_param['decisionList']);

            return response()->json(
                [
                    'result' => 'OK',
                    'msg' => 'OK',
                    'id' => $id,
                    'requestNo' => $history->requestNo,
                    'data' => $decisionList
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'result' => 'ERR',
                    'msg' => 'ERR',
                    'id' => $id,
                    'data' => []
                ],
                415
            );
        }
    }

}
