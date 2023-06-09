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
use App\Models\Mms\Notification;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use MongoDB\BSON\ObjectId;

class NotificationController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/mms';

        $this->yml_file = 'notification_controller';

        $this->entity = 'Notification';

        $this->auth_entity = 'notification';

        $this->controller_base = 'mms/notification';

        $this->view_base = 'mms.notification';

        $this->model = new Notification();
    }

    public function getIndex()
    {
        $this->title = 'Notification';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'mms.notification.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'mms.notification.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_update = false;
        $this->can_add = false;


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        $this->can_add = false;
        $this->can_print = false;
        $this->can_update = false;
        $this->can_request_approval = false;
        $this->can_approve = false;
        $this->can_revise = false;
        $this->can_upload = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_delete = false;
        $this->can_multi_delete = false;

        $this->runMoreMenu();

        $this->add_filler = false;

        $this->add_title_fields = '"<h4> '.__('Add').' Notification</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.namaLansia';
        $this->update_title_fields = '"Update" +  " " + this.namaLansia';

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        if(AuthUtil::isRoot()){

        }else{
            $model = $model->where(function($q){
                    $q->where( 'notifiable_id','=', Auth::user()->_id )
                        ->orWhere('notifiable_id','=', new ObjectId( Auth::user()->_id));
                })
                ->orderBy('created_at','desc')->get();
        }
        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
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
