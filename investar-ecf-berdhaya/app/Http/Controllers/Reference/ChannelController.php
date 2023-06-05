<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Reference;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Product;
use App\Models\Core\Mongo\User;
use App\Models\Reference\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ChannelController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/reference';
        $this->yml_file = 'channel_controller';

        $this->entity = 'Channel';

        $this->auth_entity = 'channel';

        $this->controller_base = 'reference/channel';

        $this->view_base = 'reference.channel';

        $this->model = new Channel();
    }

    public function getIndex()
    {
        $this->title = 'Channel';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'reference.channel.formlayout';

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference.channel.formlayout';
        $this->form_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_request_approval = false;
        $this->can_approve = false;
        $this->can_revise = false;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_print = false;


        $this->add_title_fields = '"<h4> Add Channel</h4>"';
        $this->view_title_fields = '"View"  + " " + this.channelName';
        $this->update_title_fields = '"Update" +  " " + this.channelName';

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        //$this->defOrderField = 'IODate';
        //$this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
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
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    // Transform fields before commited into the database collection ( xls import )
    public function beforeImportCommit($data)
    {
        //example : transform imported data to datetime field
        // $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        // $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        // $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        // $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
