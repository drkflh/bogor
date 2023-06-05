<?php

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Halal;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\WorkflowUtil;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Halal\FundingRequest;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class FundingDraftController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/halal';

        $this->yml_file = 'fundingdraft_controller';

        $this->entity = 'Funding Draft';

        $this->auth_entity = 'funding-draft';

        $this->controller_base = 'halal/funding-draft';

        $this->view_base = 'halal.fundingdraft';

        $this->model = new FundingRequest();
    }

    public function getIndex()
    {
        $this->title = 'Funding Draft';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
         * Set form layout
         */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.fundingdraft.form_layout';
        $this->form_dialog_size = 'lg';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'halal.fundingdraft.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_multi_approve = false;
        $this->with_advanced_search = false;

        $this->can_add = false;

        $this->add_as_page = true;
        $this->edit_as_page = true;

        $this->add_filler = false;

        return parent::getIndex();
    }
    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('Edit') . ' ' . $item->_id;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.fundingdraft.form_layout';

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
    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }
    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['approvalDetailTemplate'] = '`' . view('halal.fundingdraft.approvaldetail')->render() . '`';
        $formOptions['approvalDetail'] = "{}";

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }
    public function setupApprovalParams($formOptions)
    {

        $formOptions['approvalDetailTemplate'] = '`' . view('halal.fundingdraft.approvaldetail')->render() . '`';
        $formOptions['approvalDetail'] = "{}";

        $formOptions['docHistory'] = [];
        $formOptions['docHistoryTitle'] = '""';
        return $formOptions;
    }
    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        $data['approvalStatus'] = "AUDIT";
        return parent::beforeSave($data);
    }
    public function processApprovalData($data, $request)
    {
        $selected = $data['selectedApprovalItems'];

        $chg = $data['changeStatusTo'];

        if ($chg == 'APPROVED') {
            // Kalkulasi disini
            $overBudget = 0;
            if ($overBudget > 0) {
                $data['approvalStatus'] = 'APPROVED-OVER';
            } else {
                $data['approvalStatus'] = 'AUDIT';
            }
        } else {
            $data['approvalStatus'] = 'DECLINE';
        }

        $idx = 0;
        $decisionListObj = [];
        foreach ($selected as $sel) {
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
                'changeDate' => Carbon::now(env('DEFAULT_TIME_ZONE')),
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
                $doc->approvalStatus = $data['approvalStatus'];
                $doc->revLock = 1;
                $doc->save();
                $decisionListObj[$sel['_id']] = $decisionListObj[$sel['_id']] ?? [];
                $decisionListObj[$sel['_id']] = $sign;
            }
        }

        $data['decisionList'] = $decisionListObj;

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
            $sign = true;

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

        $as = 'auditedBy';
        $sign = true;
        $showpad = false;

        $row['decideAs'] = $as;
        $title = $row['requestNo'] ?? "Funding Draft";
        $row['decideAsTitle'] = $title;
        $row['needSigning'] = $sign;
        $row['needReview'] = $initial;
        $row['showSignPad'] = $showpad;
        $row['approverName'] = $approverName;
        $row['changeDate'] = $changeDate;

        return parent::rowPostProcess($row);
    }
    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        $model = $model->where('approvalStatus', 'NEW')->orderBy('updatedAt', 'desc');
        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
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
