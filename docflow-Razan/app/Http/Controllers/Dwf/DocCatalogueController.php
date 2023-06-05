<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf;

use App\Helpers\App\DmsUtil;
use App\Helpers\App\DwfUtil;
use App\Helpers\App\SmsUtil;
use App\Helpers\AuthUtil;
use App\Helpers\CmsUtil;
use App\Helpers\ImportUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Directory\Knowledge\DocCatalogue;
use App\Models\Directory\Knowledge\ProductCatalogue;
use App\Models\Dwf\Admin\ArchiveType;
use App\Models\Sms\SalesOperation\JobRegister;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocCatalogueController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        // $this->res_path = 'views/dwf/doccatalogue';
        // $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'doc_catalogue_controller';

        $this->entity = 'Document';
        $this->auth_entity = 'product-catalogue';

        $this->controller_base = 'dwf/archive';

        $this->view_base = 'dwf.doccatalogue';

        $this->model = new DocCatalogue();
    }

    public function getIndex()
    {
        $this->title = 'Arsip Dokumen';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dwf.doccatalogue.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf/doccatalogue/formlayout';
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['mediaUrlObjects'] = [];
        $formOptions['FileUrlObjects'] = [];
        $formOptions['docGroupOptions'] = [];

        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4><img src=\"'.url('images/icons/icon2.png').'\" style=\"width:35px;height:auto;margin-top:-15px;\"/> Add Product Catalogue</h4>"';
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ this.product + "</h4><br>" + this.brand + " " + this.manufacturer + "</div>"',  '<img src=\"'.url('images/icons/icon2.png').'\" style=\"width:38px;height:auto;\"/>' );
        $this->update_title_fields = sprintf('"<h4>%s Update: " + this.product + "</h4>"',  '<img src=\"'.url('images/icons/icon2.png').'\" style=\"width:35px;height:auto;margin-top:-15px;\"/>' );

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $this->title = 'Arsip Dokumen';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $au = $keyword1 ?? $keyword0;
        $this->auth_entity = 'dwf-archive-'.trim( $au );

        $this->viewer_layout = 'dwf.doccatalogue.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf/doccatalogue/formlayout';
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_print = true;

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['mediaUrlObjects'] = [];
        $formOptions['docGroupOptions'] = CmsUtil::toOptions(CmsUtil::getGroup(), 'groupName', 'groupName' );

        $groupCode = $keyword0;
        $subGroupCode = $keyword1 ?? false;
        $docTypeTitle = '';

        if($subGroupCode){
            $group = ArchiveType::where('groupCode','=', $groupCode )
                ->where( 'subGroupCode','=', $subGroupCode)->first();
            if($group){
                $sectionTitle = $group->group;
                $categoryTitle = $group->subGroup;
            }else{
                $sectionTitle = '';
                $categoryTitle = '';
            }

        }else{
            $group = ArchiveType::where('groupCode','=', $groupCode)
                ->first();
            if($group){
                $sectionTitle = $group->group;
                $categoryTitle = '';
            }else{
                $sectionTitle = '';
                $categoryTitle = '';
            }

        }

        if(!is_null($keyword1) && $keyword1 != ''){
            $group = ArchiveType::where('callCode','=', $keyword1)->first();
            if($group){
                $sectionTitle = $group->group;
                $categoryTitle = $group->subGroup;
                $docTypeTitle = $group->docType;
                if($group->groupCode == '02' || $group->groupCode == '03' ){
                    $docTypeTitle = $group->subGroup;
                }
            }
        }

        //print_r(DwfUtil::getArchiveType($groupCode));

        $defaultRange = [
            Carbon::now()->startOfYear()->toDateString(),
            Carbon::now()->endOfYear()->toDateString(),
        ];

        $this->extra_query= [
            'dateRange'=>$defaultRange
            ];

        $this->print_summary_template = 'doc-archive-summary-template';
        $this->print_download_xls = true;

        $formOptions['categoryOptions'] = DwfUtil::toGroupOptions( DwfUtil::getArchiveType($groupCode), 'docType', '_object', 'subGroup' );

        $this->aux_data = $formOptions;

        $this->add_filler = true;

        $this->title = 'Arsip '.str_replace('-', ' ', $sectionTitle.( isset($categoryTitle) && $categoryTitle != '' ? ' &raquo; ': '').$docTypeTitle );

        $this->add_title_fields = '"<h4>Add '. strtoupper($keyword1) .'</h4>"';
        $this->view_title_fields = '"<h4>" + this.FCallCode +" "+ this.DocRef + "</h4>"';
        $this->update_title_fields = '"<h4>Update " + this.FCallCode +" "+ this.DocRef + "</h4>"';

        return parent::getList($request, $keyword0, $keyword1, $keyword2);
    }


    public function postIndex(Request $request)
    {
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;

        if($request->has('keywords')){
            $k = $request->get('keywords');

            if($k['keyword1'] != ''){
                $model = $model->where('category','=', $k['keyword1']);
            }
        }

        $model = $this->advQuery($model , $ext);

        return $model;
    }

    public function beforeSave($data)
    {
        $max = $this->model->where( 'category', '=', $data['category'] )->max('seq');
        $max++;
        $data['seq'] = $max;
        $data['FCallCode'] = $data['category'].'-'.str_pad( $max , 5, "0", STR_PAD_LEFT);
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $request = Request::capture();
        $this->def_param['group'] = $request->get('keyword0');
        $this->def_param['category'] = $request->get('keyword1');

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function advQuery($model , $ext){

        if( isset($ext['dateRange']) && is_array($ext['dateRange']) && count($ext['dateRange']) == 2 ){

            $model = $model->where(function($q) use($ext) {

                $start = Carbon::make( $ext['dateRange'][0] )->startOfDay();
                $end = Carbon::make( $ext['dateRange'][1] )->endOfDay();

                $q->whereBetween( 'createdAt', [$start, $end]);
            });

        }

        return $model;
    }


    public function prepareXlsHeadings($data, $template, $request)
    {
        $data = [
            'no'=>'No',
            'createdAt'=>'Tanggal',
            'group'=>"Group",
            'category'=>"Category",
            'FCallCode'=>"No Arsip",
            'DocRef'=>"Doc. No / Title",
            'Creator'=>"Dibuat",
            'Sender'=>"Pengirim",
            'Recipient'=>"Penerima",
        ];
        return $data;
        //return parent::prepareXlsHeadings($data, $template, $request); // TODO: Change the autogenerated stub
    }

    public function prepareXlsRows($data, $headings, $template, $request)
    {
        $rows = $data->content;

        $exrows = [];
        $count = 1;
        foreach($rows as $r){
            $r['Recipient'] = $r['Recipient'] ?? [];
            $exrows[] = [
                'no'=>$count,
                'createdAt'=>( TimeUtil::formatDate($r['createdAt'], 'm/d/Y' ) ?? '-' ),
                'group'=> ( $r['group'] ?? '-' ),
                'category'=>( $r['category'] ?? '-' ),
                'FCallCode'=>( $r['FCallCode'] ?? '-' ),
                'DocRef'=>( $r['DocRef'] ?? '-' ),
                'Creator'=>( $r['Creator'] ?? '-' ),
                'Sender'=>( $r['Sender'] ?? '-' ),
                'Recipient'=>( $this->arrayToString($r['Recipient']) ),
            ];
            $count++;
        }

        $data = $exrows;
        return $data;

        //return parent::prepareXlsRows($data, $headings, $template, $request); // TODO: Change the autogenerated stub
    }

    protected function arrayToString($arr){
        $lrr = [];
        foreach ($arr as $r){
            $lrr[] = $r['label'] ?? '';
        }
        return implode("\r\n", $lrr);
    }

    public function beforeSetPrintData(array $data, $template, $request = null)
    {
        if($template == 'doc-archive-summary-template'){
            $dm = new DocCatalogue();
            $this->print_as_pdf = true;
            $selection = $request->get('data');

            if(empty($data)){


                if($request->has('serverParams')){
                    $sp = $request->get('serverParams');
                    if(isset($sp['searchTerm']) && $sp['searchTerm'] != ''){

                        $sk = $sp['searchTerm'];

                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();

                        $dm = $this->filterBs4($dm, $sk, $searchFields);
                    }

                    if(isset($sp['extraData']) ){
                        $ext = $sp['extraData'];
                        $dm = $this->advQuery($dm , $ext);
                    }

                    if(isset($sp['keywords'])){
                        $k = $sp['keywords'];
                        if($k['keyword1'] != ''){
                            $dm = $dm->where('category','=', $k['keyword1']);
                        }
                    }


                }

                $data = $dm->get();
                $data = $data->toArray();
            }

        }

        return parent::beforeSetPrintData($data, $template, $request); // TODO: Change the autogenerated stub
    }


}
