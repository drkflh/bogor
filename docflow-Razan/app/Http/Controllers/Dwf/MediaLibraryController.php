<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf;

use App\Helpers\App\DmsUtil;
use App\Helpers\App\SmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Directory\Knowledge\VideoLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaLibraryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        // $this->res_path = 'views/dwf/library';
        // $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'library_controller';

        $this->entity = 'Video';
        $this->auth_entity = 'video-library';

        $this->controller_base = 'dwf/video-library';

        $this->view_base = 'dwf.medialibrary';

        $this->model = new VideoLibrary();
    }

    public function getIndex()
    {
        $this->title = '<img style="width:38px;height:auto;margin-top:-10px;margin-right:3px" src="'.url('images/icons/video-icon.png').'" height="70px;" /> Video Library';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dwf.medialibrary.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf/medialibrary/formlayout';
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['mediaUrlObjects'] = [];

        $this->aux_data = $formOptions;

        $this->add_filler = true;

        $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/video-icon.png').'\" style=\"width:40px;height:auto;margin-top:-15px;margin-right:5px;\"/> Add Video</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\" ><h4 style=\"margin-bottom: 0px;\" >" + this.videoDescription + "</h4><br>" + this.videoSource + "</div>"',  '<img src=\"'.url('images/icons/video-icon.png').'\" style=\"width:40px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update: " + this.videoDescription + "</h4>"',  '<img src=\"'.url('images/icons/video-icon.png').'\" style=\"width:40px;height:auto;margin-top:-15px;margin-right:5px;\"/>' );

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $this->title = '<img style="width:32px;height:auto;margin-top:-10px;margin-right:3px" src="'.url('images/icons/icon2.png').'" /> Product Catalogue';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dwf.medialibrary.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf.medialibrary.formlayout';
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'fs';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['grupCatalogueOptions'] = [ [ 'text'=> "Valve A", 'value'=> "Valve A" ],[ 'text'=> "Valve B", 'value'=> "Valve B" ], [ 'text'=> "Valve C", 'value'=> "Valve C" ] ];
        $formOptions['mediaUrlObjects'] = [];
        $this->aux_data = $formOptions;

        $this->title = str_replace('-', ' ', Str::title($keyword0).' &raquo; '.Str::title($keyword1) );

        $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/icon2.png').'\" style=\"width:35px;height:auto;margin-top:-15px;\"/> Add '. Str::title($keyword1).'</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ this.videoDescription + "</h4><br><span style=\"font-size: 12pt;\">" + this.section + " &raquo; "+ this.category + "</span></div>"',  '<img src=\"'.url('images/icons/icon2.png').'\" style=\"width:38px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update: " + this.videoDescription + "</h4>"',  '<img src=\"'.url('images/icons/icon2.png').'\" style=\"width:35px;height:auto;margin-top:-15px;\"/>' );

        $this->add_filler = true;

        return parent::getList($request, $keyword0, $keyword1, $keyword2);
    }


    public function postIndex(Request $request)
    {
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        if($request->has('keywords')){
            $k = $request->get('keywords');
            $model = $model->where('section','=', $k['keyword0'] );
            $model = $model->where('category','=', $k['keyword1'] );
        }
        if($request->has('keyword1')){
            $section = $request->get('keyword1');
        }
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        debug($data);
        if(isset($data['keywords'])){
            $data['section'] = $data['keywords']['keyword0'];
            $data['category'] = $data['keywords']['keyword1'];
        }
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {
        // $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        // $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        // $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        // $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $request = Request::capture();
        $this->def_param['section'] = $request->get('keyword0');
        $this->def_param['category'] = $request->get('keyword1');

        return parent::getParam(); // TODO: Change the autogenerated stub
    }


}
