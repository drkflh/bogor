<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dms;

use App\Helpers\App\DmsUtil;
use App\Helpers\App\FileUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Dms\Doc;
use App\Models\Core\Mongo\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Laravel\File;

class RepositoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

//        $this->res_path = 'views/dms/repository';
//        $this->yml_file = 'fields';

        $this->res_path = 'models/controllers/dms';
        $this->yml_file = 'repository_controller';

        $this->entity = 'Document';

        // this must be set to use ACL
        $this->auth_entity = 'dms-repository';

        // set controller path
        $this->controller_base = 'dms/repository';

        // set view base to include standard slot
        $this->view_base = 'dms.repository';
        $this->model = new Doc();
    }

    public function getIndex()
    {
        $this->title = '<img src="'.url('images/icons/yellow-file.png').'" /> Document Repository';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;
        $this->viewer_layout = 'dms.repository.viewlayout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dms.repository.formlayout';
        $this->form_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();


        $this->can_clone = false;
        $this->can_multi_clone = false;

        $this->print_template = 'document-label';
        $this->print_modal_size = 'lg';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $years = [];
        foreach (range( 1997, 2050 ) as $yr){
            $years[] = [ 'text'=>$yr, 'value'=>$yr ];
        }

        $formOptions['docYearOptions'] = $years;

        $formOptions['IOOptions'] = [ ['text'=>'Incoming', 'value'=>'Incoming'], ['text'=>'Outgoing', 'value'=>'Outgoing'] ];
        $formOptions['TipeOptions'] = DmsUtil::toOptions( DmsUtil::getDocType(), 'DocType', 'DocType', false );
        $formOptions['CoyOptions'] = DmsUtil::toOptions( DmsUtil::getCompany(), 'CoyName', 'CoyCode', false );
        $formOptions['RetPerOptions'] = DmsUtil::toOptions( DmsUtil::getYearOptions(), 'Desc', 'DisYr', false );
        $formOptions['DispPerOptions'] = DmsUtil::toOptions( DmsUtil::getYearOptions(), 'Desc', 'DisYr', false );

        $formOptions['TopicObjectOptions'] = DmsUtil::toOptions( DmsUtil::getTopics(), 'Topic', '_object', false );
        $formOptions['timeCriteriaOptions'] = config('app.params.timeEventOperator');
        $formOptions['booleanOptions'] = config('app.params.booleanOperator');
        $formOptions['dmsFunctionOptions'] = [ ['text'=>'F', 'value'=>'F'], ['text'=>'O', 'value'=>'O'] ];
        $formOptions['StatusOptions'] = [ ['text'=>'Active', 'value'=>'Active'], ['text'=>'Passive', 'value'=>'Passive'], ['text'=>'Disposed', 'value'=>'Disposed'] ];
        $formOptions['OriginFormatOptions'] = [ ['text'=>'Paper', 'value'=>'Paper'], ['text'=>'Digital', 'value'=>'Digital'] ];

        $formOptions['selectedSheets'] = 0;
        $formOptions['boxIdInput'] = "``";

        $formOptions['sourceDir'] = "'".env('DEFAULT_SOURCE_DIR')."'";
        $formOptions['scanMode'] = "'copy'";
        $formOptions['scanning'] = "false";

        $formOptions['labelTemplate'] = "`".view('dms.repository.labeltemplate')->render()."`";
        $formOptions['printTemplate'] = "`".view('dms.repository.printtemplate')->render()."`";
        $formOptions['printLabelData'] = "``";

        $this->table_advanced_search_size = 'md';
        $this->title_fields = 'FCallCode';
        $this->pdf_title_fields = 'FCallCode';

        $this->aux_data = $formOptions;

        //advanced search
        $this->with_advanced_search = true;


        $this->extra_query= [
            'Coy'=>'',
            'Topic'=>'',
            'Function'=>'',
            'Feature'=>'',
            'HasLink'=>'',
            'HasExpiry'=>'',
            'Status'=>'',
            'RetCriteria'=>'',
            'RetDate'=>'',
            'RetPer'=>'',
            'DispCriteria'=>'',
            'DispDate'=>'',
            'DispPer'=>'',
            'Location'=>'',
            'Store'=>'',
            'OriginFormat'=>'',
            'DocRef'=>'',
            'Subject'=>'',
            'docYear'=>date( 'Y',time()),
            'docYearUntil'=>date( 'Y',time()),
        ];

        $this->print_summary_template = 'dms-repository-summary-template';

        $this->print_template = [
            ['label'=>'Summary','template'=> $this->print_summary_template , 'modal'=>'xl'],
        ];

        $this->print_modal_size = 'xl';
        $this->print_download_xls = true;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        $this->defOrderField = 'IODate';
        $this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        $today = date('Y-m-d H:i:s', time());
        $this->def_param['IO'] = 'Incoming';
        $this->def_param['Status'] = 'Active';
        $this->def_param['RetPer'] = 2;
        $this->def_param['DispPer'] = 5;
        $this->def_param['IODate'] = $today;

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function advQuery($model , $ext){

        if( isset($ext['Coy']) && $ext['Coy'] != '' ){
            $model = $model->where('Coy','=',$ext['Coy']);
        }
        if( isset($ext['Topic']) && $ext['Topic'] != '' ){
            $model = $model->where('Topic','like', '%'.$ext['Topic'].'%');
        }
        if( isset($ext['Function']) && $ext['Function'] != '' ){
            $model = $model->where('Function','=', $ext['Function']);
        }
        if( isset($ext['Feature']) && $ext['Feature'] != '' ){
            $model = $model->where('Feature','like', '%'.$ext['Feature'].'%');
        }
        if( isset($ext['Location']) && $ext['Location'] != '' ){
            $model = $model->where('Location','like', '%'.$ext['Location'].'%');
        }
        if( isset($ext['Store']) && $ext['Store'] != '' ){
            $model = $model->where('Store','like', '%'.$ext['Store'].'%');
        }
        if( isset($ext['Subject']) && $ext['Subject'] != '' ){
            $model = $model->where('Subject','like', '%'.$ext['Subject'].'%');
        }
        if( isset($ext['DocRef']) && $ext['DocRef'] != '' ){
            $model = $model->where('DocRef','like', '%'.$ext['DocRef'].'%');
        }
        if( isset($ext['Status']) && $ext['Status'] != '' ){
            $model = $model->where('Status','=',$ext['Status']);
        }
        if( isset($ext['OriginFormat']) && $ext['OriginFormat'] != '' ){
            $model = $model->where('OriginFormat','=',$ext['OriginFormat']);
        }
        if( isset($ext['RetPer']) && $ext['RetPer'] != '' ){
            $model = $model->where('RetPer','=',$ext['RetPer']);
        }
        if( isset($ext['DispPer']) && $ext['DispPer'] != '' ){
            $model = $model->where('DispPer','=',$ext['DispPer']);
        }
        if( isset($ext['DispCriteria']) && $ext['DispCriteria'] != '' && isset($ext['DispDate']) && $ext['DispDate'] != ''  ){
            if( $ext['DispCriteria'] == 'Before'){
                $model = $model->where('DispDate','<',$ext['DispDate']);
            }
            if( $ext['DispCriteria'] == 'After'){
                $model = $model->where('DispDate','>',$ext['DispDate']);
            }
            if( $ext['DispCriteria'] == 'From'){
                $model = $model->where('DispDate','>=',$ext['DispDate']);
            }
            if( $ext['DispCriteria'] == 'Until'){
                $model = $model->where('DispDate','<=',$ext['DispDate']);
            }
        }
        if( isset($ext['RetCriteria']) && $ext['RetCriteria'] != '' && isset($ext['RetDate']) && $ext['RetDate'] != ''  ){
            if( $ext['RetCriteria'] == 'Before'){
                $model = $model->where('RetDate','<',$ext['RetDate']);
            }
            if( $ext['RetCriteria'] == 'After'){
                $model = $model->where('RetDate','>',$ext['RetDate']);
            }
            if( $ext['RetCriteria'] == 'From'){
                $model = $model->where('RetDate','>=',$ext['RetDate']);
            }
            if( $ext['RetCriteria'] == 'Until'){
                $model = $model->where('RetDate','<=',$ext['RetDate']);
            }
        }
        if( isset($ext['HasLink']) && $ext['HasLink'] != '' ){
            if($ext['HasLink'] == 'YES'){
                $model = $model->where(function($q){
                    $q->where('FileUrl', 'exists', true)
                        ->whereNotNull('FileUrl')
                        ->where('FileUrl', '!=', '');
                });
            }
            if($ext['HasLink'] == 'NO'){
                $model = $model->where(function($q){
                    $q->whereNull('FileUrl')
                        ->orWhere('FileUrl', 'exists', false)
                        ->orWhere('FileUrl', '=', '');
                });
            }
        }
        if( isset($ext['HasExpiry']) && $ext['HasExpiry'] != '' ){
            if($ext['HasExpiry'] == 'YES'){
                $model = $model->where(function($q){
                    $q->where('ExpDate', 'exists', true)
                        ->whereNotNull('ExpDate')
                        ->where('ExpDate', '!=', '');
                });
            }
            if($ext['HasExpiry'] == 'NO'){
                $model = $model->where(function($q){
                    $q->whereNull('ExpDate')
                        ->orWhere('ExpDate', 'exists', false)
                        ->orWhere('ExpDate', '=', '');
                });
            }
        }

        if( isset($ext['docYear']) && $ext['docYear'] != '' ){

//            $model = $model->where(function($q) use($ext) {
//
//                $start = Carbon::make( $ext['docYear'].'-01-01' )->startOfYear();
//
//                if($ext['docYear'] == $ext['docYearUntil']){
//                    $end = Carbon::make( $ext['docYear'].'-01-01' )->endOfYear();
//                }else{
//                    $end = Carbon::make( $ext['docYearUntil'].'-01-01' )->endOfYear();
//                }
//
//                $q->where('DocDate','like','%'.$ext['docYear'].'%')
//                    ->orWhereBetween( 'DocDate', [$start, $end]);
//            });

        }

        $model = $model->orderBy('Coy', 'asc')
            ->orderBy('DocDate', 'desc')
            ->orderBy('RetDate', 'desc')
            ->orderBy('DispDate', 'desc');

        return $model;
    }

    public function postGetSeq(Request $request)
    {
        $entity = $request->get('entity');

        if( $request->has('padding') ){
            $padding = $request->get('padding')??env('NUM_PAD', 5);
        }else{
            $padding = env('NUM_PAD', 5);
        }

        if( is_null($entity) && $entity != ''){
            $seq = false;
        }else{
            $rec = $this->model->where('CallCode', '=', $entity)->max('Urut');
            $seq = $rec + 1;
        }

        if($seq){
            return response()->json([
                'result'=>'OK',
                'entity'=>$entity,
                'seq'=>$seq,
                'padded'=> str_pad($seq, $padding , '0', STR_PAD_LEFT )
            ]);

        }else{
            return response()->json([
                'result'=>'ERR',
                'msg'=>'NOENTITY'
            ]);
        }


    }

    public function getScan(Request $request)
    {
        $this->res_path = 'models/controllers/dms';
        $this->yml_file = 'scanin_controller';

        $this->nav_path = 'views/partials/app/dms';
        $this->nav_file = 'nav';

        $this->title = 'Scan In';

        $this->show_title = false;

        $this->item_id = '';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'dms.repository.scanlayout';

        $this->item_data_url = 'dms/repository/param';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_print = true;

        $this->print_template = 'doc-label';

        $this->print_modal_size = 'md';

        $this->can_lock = false;

        $this->page_methods_view = 'dms.repository.scan_methods';
        $this->page_computed_view = 'dms.repository.scan_computed';
        $this->page_watch_view = 'dms.repository.scan_watch';

        $this->show_print_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['docListItemTemplate'] = '`'.file_get_contents( resource_path('views/dms/repository/item_template.html') ).'`';

        $formOptions['scanResult'] = '{}';

        $formOptions['docUploadObjects'] = [];

        $formOptions['docSelected'] = '{}';

        $formOptions['DocBaseName'] = '``';
        $formOptions['DocBase'] = '``';
        $formOptions['DocPath'] = '``';

        $this->aux_data = $formOptions;

        return parent::formGenerator();
    }

    public function postScan(Request $request)
    {
        Util::ajaxDebug();

        $q = $request->get('q');

        $aux = $request->all();

        $name = $aux['aux'] ?? 'docname';

        $extraData = $request->get('extraData') ?? [];

        $result = false;

        $fileUtil = new FileUtil();

        if(env('STORAGE_DRIVER') == 'local'){

            $srcpath = env('DEFAULT_SCANTEMP_DIR');

            $file = explode('/', $name);

            $file = array_pop($file);

            $mode = 'move';

            $result = $fileUtil->linkFile(trim($q), $file, $srcpath, $mode  );
        }else{
            $bucket = $extraData['bucket'] ?? 'tmp';
            $selected = $extraData['selected'] ?? [];
            $addQR = $extraData['addQR'] ?? false;
            $result = $fileUtil->linkCloudFile(trim($q), $bucket, $selected['filepath'], 'docs', trim($q).'.pdf', $addQR );
        }

        if($result){
            return response()->json([
                'result'=>'OK',
                'data'=>['name'=> $name, 'file'=>$result ]
            ]);
        }else{
            return response()->json([
                'result'=>'NOK',
                'message'=>'Document not found',
                'data'=>['name'=> $name ]
            ]);

        }
    }

    public function postScanLink(Request $request)
    {
        Util::ajaxDebug();

        $sourceDir = $request->get('sourceDir');
        $scanMode = $request->get('scanMode');

        $exitCode = Artisan::call('doc:scanlink', [
            '--dir'=> $sourceDir, '--mode' => $scanMode
        ]);

        if($exitCode == 0){
            return response()->json(['result'=>'OK']);
        }else{
            return response()->json(['result'=>'ERR']);
        }

    }

    public function additionalQuery($model, Request $request)
    {
        $adv = $request->get('advancedSearch') ?? false;
        $ext = $request->get('extraData') ?? false;
        if( $adv && $ext &&  (isset($adv['enable']) && $adv['enable']) && $adv['isOpen']){
            // query hanya dilakukan jika advanced search aktif dan panel terbuka
            $model = $this->advQuery($model , $ext);
        }
        $model = $model->orderBy('updated_at','desc');
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    public function beforeImportCommit($data)
    {
        $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);
        $data['ExpDate'] = ImportUtil::excelDateToNormal($data['ExpDate']);

        $data['Status'] = $data['Status'] ?? 'Active';

        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }

    public function beforeSetPrintData(array $data, $template, $request = null)
    {
        if($template == 'dms-repository-summary-template'){
            $dm = new Doc();
            $this->print_as_pdf = true;
            $selection = $request->get('data');
            if(empty($data)){
                if($request->has('serverParams')){
                    $sp = $request->get('serverParams');
                    if(isset($sp['searchTerm']) && $sp['searchTerm'] != ''){

                        $sk = $sp['searchTerm'];

//                    if(strpos($this->yml_file, '_controller') === false){
//                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColFieldSearchable();
//                    }else{
                        $searchFields =  \App\Helpers\Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFieldSearchable();
//                    }

                        $dm = $this->filterBs4($dm, $sk, $searchFields);
                    }

                    if(isset($sp['extraData']) ){
                        $ext = $sp['extraData'];
                        $dm = $this->advQuery($dm , $ext);
                    }

                }

                $data = $dm->get();
                $data = $data->toArray();
            }


        }

        return parent::beforeSetPrintData($data, $template, $request); // TODO: Change the autogenerated stub
    }

    public function prepareXlsHeadings($data, $template, $request)
    {
        $data = [
            'no'=>'No',
            'Coy'=>'Coy',
            'Function'=>"Function",
            'IODate'=>"IODate",
            'DocDate'=>"Doc Date",
            'Feature'=>"Feature",
            'FCallCode'=>"Call Code",
            'DocRef'=>"Doc Ref",
            'Topic'=>"Topic",
            'IO'=>"IO",
            'Tipe'=>"Type",
            'Class'=>"Doc Class",
            'NoPage'=>"No of Page",
            'NoSheet'=>"No of Sheet",
            'Location'=>"Location",
            'Store'=>"Store",
            'Status'=>"Status",
            'RetPer'=>"Retain Period",
            'RetDate'=>"Retain Date",
            'DispPer'=>"Disposal Period",
            'DispDate'=>"Disposal Date",
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
            $exrows[] = [
                'no'=>$count,
                'Coy'=> ($r['Coy'] ?? ''),
                'Function'=> ( $r['Function'] ?? '-' ),
                'IODate'=> ( TimeUtil::formatDate($r['IODate'], 'm/d/Y' ) ?? '-' ),
                'DocDate'=>( TimeUtil::formatDate($r['DocDate'], 'm/d/Y' ) ?? '-' ),
                'Feature'=>( $r['Feature'] ?? '-' ),
                'FCallCode'=>( $r['FCallCode'] ?? '-' ),
                'DocRef'=>( $r['DocRef'] ?? '-' ),
                'Topic'=>( $r['Topic'] ?? '-' ),
                'IO'=>( $r['IO'] ?? '-' ),
                'Tipe'=>( $r['Tipe'] ?? '-' ),
                'DocClass'=>$r['Class'],
                'NoPage'=>( $r['NoPage'] ?? '' ).' pages',
                'NoSheet'=>( $r['NoSheet'] ?? 0 ).' sheets',
                'Location'=>( $r['Location'] ?? '-' ),
                'Store'=>( $r['Store'] ?? '-' ),
                'Status'=>( $r['Status'] ?? '' ),
                'RetPer'=>( $r['RetPer'] ?? 0 ).' years',
                'RetDate'=>( TimeUtil::formatDate($r['RetDate'], 'm/d/Y' ) ?? '-' ),
                'DispPer'=>( $r['DispPer'] ?? 0 ).' years',
                'DispDate'=>( TimeUtil::formatDate($r['DispDate'], 'm/d/Y' ) ?? '-' ),
            ];
            $count++;
        }

        $data = $exrows;
        return $data;

        //return parent::prepareXlsRows($data, $headings, $template, $request); // TODO: Change the autogenerated stub
    }



}
