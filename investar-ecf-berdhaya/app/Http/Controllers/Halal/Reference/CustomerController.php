<?php

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Halal\Reference;

use App\Helpers\App\MmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Halal\Reference\Customer;
use App\Models\Core\Mongo\User;
use App\Models\Mms\MessageQueue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CustomerController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/halal/reference';

        $this->yml_file = 'customer_controller';

        $this->entity = 'Contact List';

        $this->auth_entity = 'customer';

        $this->controller_base = 'halal/admin/reference/customer';

        $this->view_base = 'halal.reference.customer';

        $this->model = new Customer();
    }

    public function getIndex()
    {
        $this->title = 'Contact List';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
         * Set form layout
         */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.reference.customer.form_layout';
        $this->form_dialog_size = 'md';

        /**
         * Set Viewer layout
         */
        $this->viewer_layout = 'halal.reference.customer.view_layout';
        $this->viewer_dialog_size = 'md';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_approve = false;
        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->add_filler = true;
        $this->view_title_fields = '"<h4>' . __('Lihat Kontak') . ' " + "</h4>"';
        $this->update_title_fields = '"<h4>' . __('Ubah Data Kontak') . ' " + "</h4>"';
        $this->with_advanced_search = false;
        return parent::getIndex();
    }

    public function setupInjector($uiOptions, $data = null)
    {
        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['queueTemplateId'] = "''";
        $formOptions['queueTemplateText'] = "''";
        $formOptions['queueSubject'] = "''";
        $formOptions['queueTemplateOptions'] = RefUtil::toOptions( MmsUtil::getNotificationTemplates(), 'title', 'slug', false );
        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add') . ' ' . $this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.reference.customer.form_layout';

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

        $this->title = __('Edit') . ' ' . $item->_id;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.reference.customer.form_layout';

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
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

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

    public function postSetBroadcast(Request $request)
    {
        $rows = $request->get('data');
        $templateId = $request->get('templateId');
        $subject = $request->get('subject');
        $auxText = $request->get('auxText');

        $broadcastId = Util::randomstring(8, 'alphanumeric');

        foreach ($rows as $row){

            $row['auxText'] = $auxText;

            if($row['email'] != ''){
                $mq = new MessageQueue();
                $mq->broadcastId = $broadcastId;
                $mq->msgId = Util::randomstring(8, 'alphanumeric');
                $mq->templateId = $templateId;
                $mq->data = $row;
                $mq->subject = $subject;
                $mq->to = $row['email'] ?? '';
                $mq->recName = $row['namaPemilik'] ?? '';
                $mq->gatewayType = 'EMAIL';
                $mq->status = 'PENDING';
                $mq->sendCount = 0;
                $mq->save();
            }
            if($row['noHp'] != ''){
                $mq = new MessageQueue();
                $mq->broadcastId = $broadcastId;
                $mq->msgId = Util::randomstring(8, 'alphanumeric');
                $mq->templateId = $templateId;
                $mq->data = $row;
                $mq->subject = $subject;
                $mq->to = '62'.$row['noHp'] ?? '';
                $mq->recName = $row['namaPemilik'] ?? '';
                $mq->gatewayType = 'WHATSAPP';
                $mq->status = 'PENDING';
                $mq->sendCount = 0;
                $mq->save();
            }
        }

        return response()->json([
            'result'=>'OK',
            'msg'=>'Queue Set'
        ], 200);


    }
}
