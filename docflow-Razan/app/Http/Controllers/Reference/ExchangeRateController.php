<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */

namespace App\Http\Controllers\Reference;

use App\Helpers\App\DmsUtil;
use App\Helpers\Injector;
use App\Helpers\App\SalesopUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Reference\ExchangeRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExchangeRateController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/reference';
        $this->yml_file = 'exchangerate_controller';

        $this->entity = 'Exchange Rate';
        $this->auth_entity = 'exchange-rate';

        $this->controller_base = 'sms/reference/exchange-rate';

        $this->view_base = 'reference.exchangerate';

        $this->model = new ExchangeRate();
    }

    public function getIndex()
    {
        $this->title = '<img style="width:38px;height:auto;margin-top:-8px;margin-right:5px" src="'.url('images/icons/purchasereq.png').'" /> Exchange Rate';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'reference.exchangerate.view_layout';
        $this->viewer_dialog_size = 'md';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'reference/exchangerate/formlayout';
        $this->form_dialog_size = 'md';



        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();
        $formOptions['currencyCodeOptions'] = [ [ 'text'=> "IDR", 'value'=> "IDR" ],[ 'text'=> "USD", 'value'=> "USD" ],[ 'text'=> "EUR", 'value'=> "EUR" ] ];

        $uiOptions = [];


        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        // $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/purchasereq.png').'\" /> Add : Purchase Requisition</h4>"';
        $this->add_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ "Add : Exchange Rate" + "</h4></div>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:45px;height:auto;\" />' );
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ this.currencyCode + "</h4></div>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:45px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update "  + this.currencyCode + "</h4>"',  '<img src=\"'.url('images/icons/purchasereq.png').'\" style=\"width:45px;height:auto;margin-top:-15px;\"/>' );


        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {

        return $model;
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data);
    }

    public function getParam()
    {
        $this->def_param['currency'] = 'IDR';
        $this->def_param['xrate'] = 15000;
        return parent::getParam(); // TODO: Change the autogenerated stub
    }


    protected function rowPostProcess($row)
    {


        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {


        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


}
