<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Mms;

use App\Helpers\App\FmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Mms\NotificationSub;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class NotificationSubController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/mms';

        $this->yml_file = 'notificationsub_controller';

        $this->entity = 'Notification Sub';

        $this->auth_entity = 'notification-sub';

        $this->controller_base = 'mms/notification-sub';

        $this->view_base = 'mms.notificationsub';

        $this->model = new NotificationSub();
    }

    public function getIndex()
    {
        $this->title = 'Notification Sub';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'mms.notificationsub.form_layout';
        $this->form_dialog_size = 'md';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'mms.notificationsub.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['messageTypeOptions'] = [
            ['text'=>'WA', 'value'=>'WA'],
            ['text'=>'SMS', 'value'=>'SMS'],
            ['text'=>'Email', 'value'=>'EMAIL'],
        ];
        $formOptions['channelOptions'] = [
            ['text'=>'Default', 'value'=>'Default'],
        ];
        $formOptions['topicOptions'] = [
            ['text'=>'Default', 'value'=>'Default'],
        ];
        $formOptions['hourOptions'] = range(0, 23, 1);
        $formOptions['minutesOptions'] = range(0, 55, 5);
        $formOptions['priorityOptions'] = range(0, 4, 1);

        $days = [
            1 => 'Sun',
            2 => 'Mon',
            3 => 'Tues',
            4 => 'Wed',
            5 => 'Thu',
            6 => 'Fri',
            7 => 'Sat'
        ];

        $dow = [];
        foreach (range(0,7, 1) as $d){
            if($d == 0){
                $dow[] = [ 'text'=>'All week', 'value'=>$d ];
            }else{
                $dow[] = [ 'text'=>$days[$d], 'value'=>$d ];
            }
        }

        $formOptions['dayOfWeekOptions'] = $dow;

        $formOptions['farmIdOptions'] = FmsUtil::toOptions( FmsUtil::getFarms( Auth::user()->_id ), 'farmName', '_id', true ) ;
        $formOptions['officerIdOptions'] = FmsUtil::toOptions( FmsUtil::getOfficers( Auth::user()->_id ), 'name', '_id', true ) ;


        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4> '.__('Add').' Notification Sub</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.namaLansia';
        $this->update_title_fields = '"Update" +  " " + this.namaLansia';

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
