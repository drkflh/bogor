<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Mms;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Mms\MessageQueue;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class MessageQueueController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/mms';

        $this->yml_file = 'messagequeue_controller';

        $this->entity = 'Message Queue';

        $this->auth_entity = 'messagequeue';

        $this->controller_base = 'mms/message-queue';

        $this->view_base = 'mms.messagequeue';

        $this->model = new MessageQueue();
    }

    public function getIndex()
    {
        $this->title = 'Message Queue';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'mms.messagequeue.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'mms.messagequeue.view_layout';

        // $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();

        $this->can_add = false;
        $this->can_update = false;
        $this->can_request_approval = false;
        $this->can_approve = false;
        $this->can_revise = false;
        $this->can_upload = false;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4> '.__('Add').' Message Queue</h4>"';
        $this->view_title_fields = '"View"  + " " + this.subject';
        $this->update_title_fields = '"Update" +  " " + this.subject';

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }


    public function getParam()
    {

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

    public function postExecuteQueue(Request $request)
    {
        $rows = $request->get('data');
        $exitCode = [];
        foreach ($rows as $row){
            $exitCode[$row['broadcastId']] = Artisan::call('broadcast:execute', [
                '--bid' => $row['broadcastId']
            ]);
        }

        return response()->json([
            'result'=>'OK',
            'msg'=>$exitCode
        ], 200);

    }

}
