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
use App\Models\Mms\MessageGateway;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MessageGatewayController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/mms';

        $this->yml_file = 'messagegateway_controller';

        $this->entity = 'Message Gateway';

        $this->auth_entity = 'message-gateway';

        $this->controller_base = 'mms/message-gateway';

        $this->view_base = 'mms.messagegateway';

        $this->model = new MessageGateway();
    }

    public function getIndex()
    {
        $this->title = 'Message Gateway';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'mms.messagegateway.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'mms.messagegateway.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['gatewayTypeOptions'] = [['value' => 'email', 'text' => 'E-Mail'], ['value' => 'sms', 'text' => 'SMS'], ['value' => 'fcm', 'text' => 'FCM']];

        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4> '.__('Add').' Message Gateway</h4>"';
        $this->view_title_fields = '"View"  + " " + this.gatewayName';
        $this->update_title_fields = '"Update" +  " " + this.gatewayName';

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

}
