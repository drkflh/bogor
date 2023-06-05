<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf;

use App\Helpers\App\DwfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\ApprovalStatusLog;
use App\Models\Dwf\Admin\GroupAlias;
use App\Models\Dwf\Admin\JobGroup;
use App\Models\Dwf\Document;
use App\Models\Core\Mongo\User;
use App\Models\Workflow\ApprovalLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;

class DocumentController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/dwf';

        $this->yml_file = 'document_controller';

        $this->entity = 'Document';

        $this->auth_entity = 'dwf-document';

        $this->controller_base = 'dwf/document';

        $this->view_base = 'dwf.document';

        $this->model = new Document();
    }

    public function getIndex()
    {
        $this->title = 'Document';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'dwf.document.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'dwf.document.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        $this->add_title_fields = '"<h4> Add Document</h4>"';
        $this->view_title_fields = '"Lihat"  + " " + this.namaLansia';
        $this->update_title_fields = '"Update" +  " " + this.namaLansia';

        return parent::getIndex();
    }

    public function getList(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {

        $cname = substr(strrchr(get_class($this), '\\'), 1);

        $this->controller_name = str_replace('Controller', '', $cname);

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'dwf.document.view_layout';

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html

        $form_layout = 'form_layout';

        $template_name = strtolower($keyword0);

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
        }

        $this->form_layout = 'dwf.document.'.$form_layout;
        $this->form_dialog_size = 'xl';
        $this->viewer_dialog_size = 'fs';

        $this->authorization_method_view = 'dwf.document.approval_function';

        $this->auth_entity = 'dwf-'.trim($keyword0);

        $this->can_update = true;
        $this->can_view = true;

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->can_print = true;
        $this->can_clone = false;
        $this->can_multi_clone = false;
        $this->can_multi_print = false;

        $s1 = (isset($keyword1) && !is_null($keyword1) && !$keyword1 == '') ? '/'.$keyword1 :'';
        $s2 = (isset($keyword2) && !is_null($keyword2) && !$keyword2 == '') ? '/'.$keyword2 :'';
        $this->data_url = $this->controller_base.'/list/'.$keyword0.$s1.$s2;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['docGroupOptions'] = [];
        $formOptions['confidentialityOptions'] = [ ['text'=>'B', 'value'=>'B'],['text'=>'R', 'value'=>'R'] ];

        $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode( $keyword0 ), 'jobCode', '_object', false ) ;

        $formOptions['docClassOptions'] = DwfUtil::toOptions( DwfUtil::getDocClass(), ['classCode','docClass'], 'classCode', false ) ;
        $formOptions['delegatesOptions'] = [ ['text'=>'Langsung', 'value'=>'Langsung'],['text'=>'a.n', 'value'=>'a.n'],['text'=>'a.n/u.b', 'value'=>'a.n/u.b']  ];
        $formOptions['dispositionContentOptions'] =  DwfUtil::toOptions( DwfUtil::getDispoItems(), 'description', 'itemName', false );
        $formOptions['docGroupOptions'] = [];
        $formOptions['footerOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), 'bizUnitName', '_object', false );

        $formOptions['archiveCategoryOptions'] = DwfUtil::toGroupOptions( DwfUtil::getArchiveType(), 'docType', 'callCode', 'subGroup' );

        $formOptions['archiveCategorySelection'] = "''";
        $formOptions['archiveCategoryDefault'] = "''";
        $formOptions['archiveCategoryDisabled'] = "'false'";

        $this->edit_as_page = true;
        $this->add_as_page = true;

        $grpCode = null;
        if( trim($keyword0) == 'status'){
            $this->edit_page_base = "dwf/document/edit/'+ row.formTemplate +'";
            $this->add_page_base = "dwf/document/add/";
            $this->can_add = false;
        }else{
            $this->edit_page_base = 'dwf/document/edit/'.trim($keyword0);
            $this->add_page_base = 'dwf/document/add/'.trim($keyword0);

            if($keyword0 == 'surat-dinas'){
                $grpCode = '02';
//                $formOptions['archiveCategorySelection'] = "'02-SUD001-01-01'" ;
//                $formOptions['archiveCategoryDefault'] = "'02-SUD001-01-01'";
//                $formOptions['archiveCategoryDisabled'] = "'false'";
            }
            if($keyword0 == 'nota-dinas'){
                $grpCode = '03';
//                $formOptions['archiveCategorySelection'] = "'03-NTD001-01-01'";
//                $formOptions['archiveCategoryDefault'] = "'03-NTD001-01-01'";
//                $formOptions['archiveCategoryDisabled'] = "'false'";
            }

            $roleSet = DwfUtil::getArchiveActiveRole($grpCode);
            $formOptions['archiveCategoryOptions'] = DwfUtil::toOptions( DwfUtil::getArchiveType($grpCode, $roleSet), ['group','subGroup'], 'callCode', false );


        }

        $formOptions['docHistory'] = [];
        $formOptions['sendDoc'] = '{}';
        $formOptions['sentTo'] = '{}';
        $formOptions['receiveDoc'] = '{}';

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }

        $this->aux_data = $formOptions;

        $defaultRange = [
            Carbon::now()->startOfYear()->toDateString(),
            Carbon::now()->endOfYear()->toDateString(),
        ];

        $this->extra_query= [
            'dateRange'=>$defaultRange
        ];

        $this->add_filler = true;

        $this->viewer_as_document = true;

        $this->print_template = $template_name;

        $exclude = null;

        if ($keyword0 == 'status'){
            $this->title = str_replace('-', ' ', Str::title($keyword1) );
            if( $keyword1 == 'signature'){
                $this->title = 'Penandatanganan';
            }
            $this->can_update = true;
            $this->can_view = false;
            $this->can_approve = false;
            if( $keyword1 == 'history'){
                $this->title = 'Riwayat';
                $this->can_update = false;
                $this->can_view = true;
            }
            if(in_array($keyword1, [ 'inbox', 'rejected', 'sent', 'draft','in-process'  ] )){
                $exclude = ['approvalAction', 'sendAction', 'archiveAction'];
            }
            if(in_array($keyword1, [ 'inbox', 'rejected', 'sent', 'draft'  ] )){
                $this->can_update = false;
            }
            if(in_array($keyword1, [ 'inbox', 'rejected', 'sent', 'draft', 'draft-review','signature','in-process'  ] )){
                $this->can_view = true;
            }
            if(in_array($keyword1, [ 'draft-review','signature','in-process'  ] )){
                $this->can_approve = true;
            }

            $this->backlink = 'dwf/document/list/'.$keyword0.'/'.$keyword1;

        }else{
            $this->title = str_replace('-', ' ', Str::title($keyword0) );
            if($keyword0 == 'lembar-disposisi'){
                $exclude = ['approvalAction', 'archiveAction'];
            }
            if($keyword0 == 'memo-internal'){
                $exclude = ['approvalAction', 'copy', 'archiveAction'];
            }
            if($keyword0 == 'surat-dinas'){
                $exclude = ['approvalAction','sender'];
            }
            if($keyword0 == 'nota-dinas'){
                $exclude = ['approvalAction','sender'];
            }
        }

        if(strpos($this->yml_file, '_controller') === false){
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColFields(false, $this->show_actions, $this->add_filler);
        }else{
            $this->table_column = Util::loadResYaml( $this->yml_file,$this->res_path )->toColumnFields(false, $this->show_actions, $this->add_filler, $exclude);
        }


        $this->entity = $this->title;

        $this->show_more_actions = true;

        $this->add_title_fields = '"<h4>Buat '. $this->title.'</h4>"';
        $this->update_title_fields = sprintf('"<h4>Update " + this.docNo + " " + this.subject + "</h4>"',  '' );
        $this->view_title_fields = sprintf('"%s<div style=\"float: right;padding-left: 8px;\"><h4 style=\"margin-bottom: 0px;\">"+ this.Subject + "</h4><br><span style=\"font-size: 12pt;\">" + this.section + " &raquo; "+ this.category + "</span></div>"',  '<img src=\"'.url('images/icons/icon2.png').'\" style=\"width:38px;height:auto;\"/>' );

        return parent::getList($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        $keywords = $request->get('keywords');
        $docType = $keywords['keyword0'];


        if($docType == 'status'){
            $docStatus = $keywords['keyword1'];
            // naskah masuk
            if($docStatus == 'inbox'){
                $model = $model->where('docStatus','=', 'RELEASED')
                    ->where('sendStatus','=', 'SENT');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where(function($q){
                        $q->where("sendRecipient.key",'=', Auth::user()->_id )
                            ->orWhere("copyRecipient.key",'=', Auth::user()->_id )
                            ->orWhere("sendRecipient.obj.email",'=', Auth::user()->email )
                            ->orWhere("copyRecipient.obj.email",'=', Auth::user()->email );
                    });
                }
            }
            if($docStatus == 'draft-review'){
                $model = $model->where('docStatus','=', 'DRAFT');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where("draftRecipient.key",'=', Auth::user()->_id );
                }
            }
            if($docStatus == 'signature'){
                $model = $model->where('docStatus','=', 'APPROVED');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where("signer.key",'=', Auth::user()->_id );
                }
            }

            if($docStatus == 'history'){
                $model = $model->where(function($q){
                    $q->where('docStatus','=', 'DRAFT')
                        ->orWhere('docStatus','=', 'RELEASED')
                        ->orWhere('docStatus','=', 'APPROVED');
                });

                if( !AuthUtil::isAdmin() ){
                    $model = $model->where(function($q){
                        $q->where("draftRecipient.key",'=', Auth::user()->_id )
//                            ->orWhere("recipient.key",'=', Auth::user()->_id )
                            ->orWhere("signer.key",'=', Auth::user()->_id );
                    });
                }
            }

            //naskah keluar
            if($docStatus == 'draft'){ // menunggu approval / reject
                $model = $model->where('docStatus','=', 'DRAFT');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where('ownerId','=', Auth::user()->_id);
                }
            }

            if($docStatus == 'in-process'){ //menunggu tanda tangan
                $model = $model->where('docStatus','=', 'APPROVED');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where('ownerId','=', Auth::user()->_id);
                }

            }
            if($docStatus == 'rejected'){ //menunggu tanda tangan
                $model = $model->where('docStatus','=', 'REJECTED');
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where('ownerId','=', Auth::user()->_id);
                }

            }
            if($docStatus == 'sent'){
                $model = $model->where( 'docStatus','=', 'RELEASED' );
                if( !AuthUtil::isAdmin() ){
                    $model = $model->where('ownerId','=', Auth::user()->_id);
                }
            }
        }else{
            $model = $model->where('docType','=', $docType);
            if( !AuthUtil::isAdmin() ){
                $model = $model->where('ownerId','=', Auth::user()->_id);
            }
        }

        $ext = $request->get('extraData') ?? false;

        if($ext){
            $model = $this->advQuery($model , $ext);
        }


        return parent::additionalQuery($model, $request); // TODO: Change the autogenerated stub
    }

    public function beforeUpdateForm($population)
    {
        $population['itemId'] = $population['_id'];
        $population['recipient'] = is_string( $population['recipient'] ) ? [] : $population['recipient'];
        $population['copy'] = is_string( $population['copy'] ) ? [] : $population['copy'];
        $population['draftRecipient'] = is_string( $population['draftRecipient'] ) ? [] : $population['draftRecipient'];
        $population['signer'] = is_string( $population['signer'] ) ? [] : $population['signer'];
        $population['attachments'] = is_string( $population['attachments'] ) ? [] : $population['attachments'];
        $population['attachmentsObjects'] = !isset($population['attachmentsObjects']) || is_string( $population['attachmentsObjects'] ) ? [] : $population['attachmentsObjects'];

        $docType = $population['formTemplate'];
        $userJobCode = Auth::user()->jobTitleCode ?? false;
        if($userJobCode){
            $jobCode = DwfUtil::getUserJobObject( $userJobCode );
        }else{
            $jobCode = [];
        }

        if($docType == 'surat-dinas' || $docType == 'nota-dinas'){

        }else{
            //$population['titleCode'] = $jobCode;
        }


        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {
        $data = $this->getDocNumber($data, false);
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        $next = [];
        $next['approverId'] = Auth::user()->_id;
        $next['approverName'] = Auth::user()->name;
        $next['authorizationSign'] = '';
        $next['initialSign'] = '';
        $next['note'] = '';
        $next['decision'] = 'CREATED';
        $next['approveAs'] = 'CREATOR';

        Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

        $doc = Document::find($data['_id']);

        if($data['docStatus'] == 'DRAFT'){
            $this->notifyDrafter($doc);
        }
        if($data['docStatus'] == 'APPROVED'){
            $this->notifySigner($doc);
        }

        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }

    public function afterUpdate($id, $data = null)
    {
        $approveAs = (  isset($data['ownerId']) && $data['ownerId'] == Auth::user()->_id ? 'CREATOR' : 'UPDATER');

        $next = [];
        $next['approverId'] = Auth::user()->_id;
        $next['approverName'] = Auth::user()->name;
        $next['authorizationSign'] = '';
        $next['initialSign'] = '';
        $next['note'] = '';
        $next['decision'] = 'UPDATED';
        $next['approveAs'] = $approveAs;

        Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

        $doc = Document::find($id);
        if($data['docStatus'] == 'DRAFT'){
            $this->notifyDrafter($doc);
        }
        if($data['docStatus'] == 'APPROVED'){
            $this->notifySigner($doc);
        }

        return parent::afterUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function notifyDrafter($doc)
    {
        $rec_ids = [];
        if(is_object($doc)){
            $drafter = $doc->draftRecipient;
        }else{
            $drafter = $doc['draftRecipient'] ?? [];
        }
        foreach ($drafter as $s){
            if(isset($s['key']) && $s['key'] != ''){
                $rec_ids[] = $s['obj']['email'] ?? new ObjectId($s['key']) ;
            }
        }

        $rec_users = User::whereIn('_id', $rec_ids)
            ->orWhere(function($q) use ($rec_ids){
                $q->whereIn('email', $rec_ids);
            })
            ->get();
        DwfUtil::sendNotification($rec_users, \App\Notifications\RecipientNotification::class, $doc, 'DRAFT');
    }

    public function notifySigner($doc)
    {
        $rec_ids = [];
        if(is_object($doc)){
            $signers = $doc->signer;
        }else{
            $signers = $doc['signer'] ?? [];
        }
        foreach ($signers as $s){
            if(isset($s['key']) && $s['key'] != ''){
                $rec_ids[] = $s['obj']['email'] ?? new ObjectId($s['key']);
            }
        }
        $rec_users = User::whereIn('_id', $rec_ids)
            ->orWhere(function($q) use ($rec_ids){
                $q->whereIn('email', $rec_ids);
            })
            ->get();
        DwfUtil::sendNotification($rec_users, \App\Notifications\RecipientNotification::class, $doc, 'PERMOHONAN TTD');
    }


    public function getDocNumber($data, $isObject = false)
    {
        if($isObject){

            if($data->formTemplate == 'surat-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'APPROVED' || $data->docStatus == 'REJECTED'){
                    $data->docNo = 'APL.' . $data->docStatus . '/' . $data->docClass  . '/' . $data->docYear  . '/' . $data->titleCode['jobCode'] . '-' . $data->confidentiality ;
                }

                if($data->docStatus == 'RELEASED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            //->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data->footer['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docSeq = $max;

                    $data->docNo = 'APL.' . $max . '/' . $data->docClass  . '/' . $data->docYear  . '/' . $data->titleCode['jobCode'] . '-' . $data->confidentiality ;
                }
            }
            if($data->formTemplate == 'nota-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'APPROVED' || $data->docStatus == 'REJECTED'){
                    $data->docNo = $data->titleCode['jobCode'] . '.' . $data->docStatus . '/' . $data->docClass  . '/' . $data->docYear  . '-' . $data->confidentiality ;
                }

                if($data->docStatus == 'RELEASED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            ->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data->footer['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo = $data->titleCode['jobCode'] . '.' . $max . '/' . $data->docClass  . '/' . $data->docYear  . '-' . $data->confidentiality ;
                }
            }
            if($data->formTemplate == 'lembar-disposisi' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'REJECTED'){
                    $data->docNo =  $data->titleCode['jobCode'] . '.' . $data->docStatus;
                }

                if($data->docStatus == 'APPROVED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate)
                            ->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo =  $data->titleCode['jobCode'] . '.' . $max;
                }
            }
            if($data->formTemplate == 'memo-internal' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data->docNo ) ){
                    return $data;
                }

                if($data->docStatus == 'REJECTED'){
                    $data->docNo = 'MI.' . $data->docStatus . '/' . $data->titleCode['jobCode'] ;
                }

                if($data->docStatus == 'APPROVED'){
                    $max = 1;
                    if(isset($data->titleCode['jobCode'])){
                        $max = Document::where('docYear','=',$data->docYear)
                            ->where("formTemplate", '=', $data->formTemplate  )
                            //->where("titleCode.jobCode", '=', $data->titleCode['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data->docSeq = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data->docNo = 'MI.' . $max . '/' . $data->titleCode['jobCode'] ;
                }
            }

        }else{


            if($data['formTemplate'] == 'surat-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'APPROVED' || $data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = 'APL.' . $data['docStatus'] . '/' . $data['docClass']  . '/' . $data['docYear']  . '/' . $data['titleCode']['jobCode'] . '-' . $data['confidentiality'] ;
                }

                if($data['docStatus'] == 'RELEASED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        //if('DUZ,DOP,')
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            //->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data['footer']['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = 'APL.' . $max . '/' . $data['docClass']  . '/' . $data['docYear']  . '/' . $data['titleCode']['jobCode'] . '-' . $data['confidentiality'] ;
                }
            }

            if($data['formTemplate'] == 'nota-dinas' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'APPROVED' || $data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = $data['titleCode']['jobCode'] . '.' . $data['docStatus'] . '/' . $data['docClass']  . '/' . $data['docYear']  . '-' . $data['confidentiality'] ;
                }

                if($data['docStatus'] == 'RELEASED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->where("footer.bizUnitCode", '=', $data['footer']['bizUnitCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = $data['titleCode']['jobCode'] . '.' . $max . '/' . $data['docClass']  . '/' . $data['docYear']  . '-' . $data['confidentiality'] ;
                }
            }

            if($data['formTemplate'] == 'lembar-disposisi' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'REJECTED'){
                    $data['docNo'] =  $data['titleCode']['jobCode'] . '.' . $data['docStatus'];
                }

                if($data['docStatus'] == 'APPROVED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode']) || isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate'])
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] =  $data['titleCode']['jobCode'] . '.' . $max;
                }
            }
            if($data['formTemplate'] == 'memo-internal' )
            {
                if( preg_match( "/RELEASED|REJECTED/" , $data['docNo']) ){
                    return $data;
                }

                if($data['docStatus'] == 'REJECTED'){
                    $data['docNo'] = 'MI.' . $data['docStatus'] . '/' . $data['titleCode']['jobCode'] ;
                }

                if($data['docStatus'] == 'APPROVED'){
                    $max = 1;
                    if(isset($data['titleCode']['jobCode'])){
                        $max = Document::where('docYear','=',$data['docYear'])
                            ->where("formTemplate", '=', $data['formTemplate']  )
                            ->where("titleCode.jobCode", '=', $data['titleCode']['jobCode'] )
                            ->max('docSeq');
                        $max++;
                    }
                    $data['docSeq'] = $max;
                    $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
                    $data['docNo'] = 'MI.' . $max . '/' . $data['titleCode']['jobCode'] ;
                }
            }
        }

        return $data;
    }

    public function getParam()
    {
        $request = Request::capture();

        $docType = $request->get('keyword0');

        $this->def_param['docType'] = $docType;
        $this->def_param['formTemplate'] = $docType;

        $userJobCode = Auth::user()->jobTitleCode ?? false;
        if($userJobCode){
            $jobCode = DwfUtil::getUserJobObject( $userJobCode );
        }else{
            $jobCode = [];
        }

        if($docType == 'surat-dinas' || $docType == 'nota-dinas'){
            $this->def_param['docStatus'] = 'DRAFT';
        }else{
            $this->def_param['docStatus'] = 'APPROVED';
            $this->def_param['titleCode'] = $jobCode;
        }

        $this->def_param['regDate'] = date('d M Y', time());
        $this->def_param['docDate'] = date('d M Y', time());
        $this->def_param['docYear'] = date('Y', time());
        $this->def_param['docType'] = $docType;
        $this->def_param['formTemplate'] = $docType;

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    public function advQuery($model , $ext){

        if( isset($ext['dateRange']) && is_array($ext['dateRange']) && count($ext['dateRange']) == 2 ){

            $model = $model->where(function($q) use($ext) {

                $start = Carbon::make( $ext['dateRange'][0] )->startOfDay();
                $end = Carbon::make( $ext['dateRange'][1] )->endOfDay();

                $q->whereBetween( 'created_at', [$start, $end]);
            });

        }

        return $model;
    }

    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

    public function processApprovalData($data, $request)
    {
        debug($request->get('data'));

        $doc = $data['doc'];
        $decision = $data['decisionData'];

        $document = $this->model->find($doc['_id']);

        if($document){

            if($doc['docStatus'] == 'DRAFT'){

                $draftStatus = $doc['draftStatus'] ?? [];
                $draftStatus[] = [
                    'key'=>$decision['approverId'],
                    'label'=>$decision['approverName'],
                    'sign'=>$decision['authorizationSign'],
                    'initial'=>$decision['initialSign'],
                    'ts'=>time(),
                    'obj'=>$decision,
                ];

                $document->draftStatus = $draftStatus;
                $doc['draftStatus'] = $draftStatus;

                if( $document->formTemplate == 'surat-dinas' || $document->formTemplate == 'nota-dinas' ){
                    //must check if all drafter approve before set to APPROVED
                    if($decision['decision'] == 'APPROVED'){

                        $approvals = $document->draftStatus ?? [];
                        $approval_req = count($document->draftRecipient);
                        $approval_cnt = 0;
                        $approved = false;

                        foreach($approvals as $ap){
                            //print_r($ap);
                            if($ap['obj']['decision'] == 'APPROVED'){
                                $approval_cnt++;
                            }
                        }

                        if($approval_req == $approval_cnt){
                            $document->docStatus = 'APPROVED';
                            $this->notifySigner($document);
                        }
                    }
                    if($decision['decision'] == 'REJECTED'){
                        $document->docStatus = 'REJECTED';
                    }
                }
                if( $document->formTemplate == 'memo-internal' || $document->formTemplate == 'lembar-disposisi' ){
                    if($decision['decision'] == 'APPROVED'){
                        $document->docStatus = 'APPROVED';
                    }
                }

                $decision['approveAs'] = 'Draft Reviewer';

                Util::approvallog( $decision, $doc , $doc['_id'], $doc['docType'], $this->auth_entity );

            }

            if($doc['docStatus'] == 'APPROVED'){
                $signingStatus = $doc['signingStatus'] ?? [];
                $signature = [
                    'key'=>$decision['approverId'],
                    'label'=>$decision['approverName'],
                    'sign'=>$decision['authorizationSign'],
                    'initial'=>$decision['initialSign'],
                    'ts'=>time(),
                    'obj'=>$decision,
                ];
                $signingStatus[] = $signature;
                $document->signature = $signature;
                $document->signingStatus = $signingStatus;
                $doc['signingStatus'] = $signingStatus;

                if($decision['decision'] == 'APPROVED'){

                    $signings = $document->signingStatus ?? [];
                    $signing_req = count($document->signer);
                    $signing_cnt = 0;

                    foreach($signings as $ap){
                        if($ap['obj']['decision'] == 'APPROVED'){
                            $signing_cnt++;
                        }
                    }

                    if($signing_req == $signing_cnt){
                        $document->docStatus = 'RELEASED';
                    }

                }
                if($decision['decision'] == 'REJECTED'){
                    $document->docStatus = 'REJECTED';
                }

                $decision['approveAs'] = 'Signer';

                Util::approvallog( $decision, $doc , $doc['_id'], $doc['docType'], $this->auth_entity );

            }

            debug($document->toArray());

            $document = $this->getDocNumber($document, true);

            debug($document->toArray());

            //die();

            $document->save();
        }

        return parent::processApprovalData($data, $request); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0, $keyword1 = null, $keyword2 = null)
    {
        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'document_controller';

        $this->nav_path = 'views/partials/app/dms';
        $this->nav_file = 'nav';
        $this->logo = env('APP_LOGO');

        $this->title = __('Buat').' '.str_replace('-', ' ', Str::title($keyword0) );

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'dwf/document/add';

        $this->update_url = 'dwf/document/edit';

        $this->item_data_url = 'dwf/document/param';

        $this->autosave_url = 'dwf/document/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = '';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = false;

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
        }

        $this->form_layout = 'dwf.document.'.$form_layout;


        $this->page_methods_view = 'dwf.document.add_methods';
        $this->page_computed_view = 'dwf.document.add_computed';
        $this->page_watch_view = 'dwf.document.add_watch';

        $this->page_redirect_after_save = true;

        if($request->has('back')){
            $back = $request->get('back');
//                $this->page_save_redirect = 'dwf/document/list/'.$back;
//                $this->page_cancel_redirect = 'dwf/document/list/'.$back;
            $this->page_save_redirect = $back;
            $this->page_cancel_redirect = $back;
        }else{
            $this->page_save_redirect = 'dwf/document/list/'.trim($keyword0);
            $this->page_cancel_redirect = 'dwf/document/list/'.trim($keyword0);
        }

//        $this->page_save_redirect = 'dwf/document/list/'.trim($keyword0);
//        $this->page_cancel_redirect = 'dwf/document/list/'.trim($keyword0);

        $this->show_print_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['docGroupOptions'] = [];
        $formOptions['confidentialityOptions'] = [ ['text'=>'B', 'value'=>'B'],['text'=>'R', 'value'=>'R'] ];

        if($keyword0 == 'lembar-disposisi'){
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getDispoTitleCode(), 'jobCode', '_object', false ) ;
        }else{
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode( $keyword0 ), 'jobCode', '_object', false ) ;
        }


        $formOptions['docClassOptions'] = DwfUtil::toOptions( DwfUtil::getDocClass(), ['classCode','docClass'], 'classCode', false ) ;
        $formOptions['delegatesOptions'] = [ ['text'=>'Langsung', 'value'=>'Langsung'],['text'=>'a.n', 'value'=>'a.n'],['text'=>'a.n/u.b', 'value'=>'a.n/u.b']  ];
        $formOptions['dispositionContentOptions'] =  DwfUtil::toOptions( DwfUtil::getDispoItems(), 'description', 'itemName', false );
        $formOptions['docGroupOptions'] = [];
        $formOptions['footerOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), 'bizUnitName', '_object', false );;
        $formOptions['titleCodeDisable'] = 'false' ;

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }


        $this->aux_data = $formOptions;

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }


    public function getAddDocument(Request $request, $keyword0, $keyword1 = null,$keyword2 = null ){

        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'document_controller';

        $this->nav_path = 'views/partials/app/dms';
        $this->nav_file = 'nav';
        $this->logo = env('APP_LOGO');

        $this->title = __('Buat').' '.str_replace('-', ' ', Str::title($keyword0) );

        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'dwf/document/add';

        $this->update_url = 'dwf/document/edit';

        $this->item_data_url = 'dwf/document/param';

        $this->autosave_url = 'dwf/document/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = '';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = false;

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        if($keyword0 != ''){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
        }

        $this->form_layout = 'dwf.document.'.$form_layout;


        $this->page_methods_view = 'dwf.document.add_methods';
        $this->page_computed_view = 'dwf.document.add_computed';
        $this->page_watch_view = 'dwf.document.add_watch';

        $this->page_redirect_after_save = true;
        $this->page_save_redirect = 'dwf/document/list/'.trim($keyword0);
        $this->page_cancel_redirect = 'dwf/document/list/'.trim($keyword0);

        $this->show_print_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['docGroupOptions'] = [];
        $formOptions['confidentialityOptions'] = [ ['text'=>'B', 'value'=>'B'],['text'=>'R', 'value'=>'R'] ];

        if($keyword0 == 'lembar-disposisi'){
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getDispoTitleCode(), 'jobCode', '_object', false ) ;
        }else{
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode( $keyword0 ), 'jobCode', '_object', false ) ;
        }


        $formOptions['docClassOptions'] = DwfUtil::toOptions( DwfUtil::getDocClass(), ['classCode','docClass'], 'classCode', false ) ;
        $formOptions['delegatesOptions'] = [ ['text'=>'Langsung', 'value'=>'Langsung'],['text'=>'a.n', 'value'=>'a.n'],['text'=>'a.n/u.b', 'value'=>'a.n/u.b']  ];
        $formOptions['dispositionContentOptions'] =  DwfUtil::toOptions( DwfUtil::getDispoItems(), 'description', 'itemName', false );
        $formOptions['docGroupOptions'] = [];
        $formOptions['footerOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), 'bizUnitName', '_object', false );;
        $formOptions['titleCodeDisable'] = 'false' ;

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }


        $this->aux_data = $formOptions;

        return parent::formGenerator();

    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'document_controller';

        $this->nav_path = 'views/partials/app/dms';
        $this->nav_file = 'nav';
        $this->logo = env('APP_LOGO');

        $this->title = 'Edit Naskah';
        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'dwf/document/add';

        $this->update_url = 'dwf/document/edit';

        $this->item_data_url = 'dwf/document/data';

        $this->autosave_url = 'clinic/operasi/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = $keyword0;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->js_load_transform = 'dwf.document.edit_load_transform';

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = true;

        $this->keyword0 = $id;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        $entity = $this->model->find( $this->item_id );

        if($id != '' && $id != 'status'){
            $layout = str_replace('-', '_', $id);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
            $this->page_redirect_after_save = true;
            $this->page_save_redirect = 'dwf/document/list/'.trim($id);
            $this->page_cancel_redirect = 'dwf/document/list/'.trim($id);
        }else{
            $form = $entity->formTemplate;
            $layout = str_replace('-', '_', $form);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
            $this->page_redirect_after_save = true;


        }

        if($request->has('back')){
            $back = $request->get('back');
//                $this->page_save_redirect = 'dwf/document/list/'.$back;
//                $this->page_cancel_redirect = 'dwf/document/list/'.$back;
            $this->page_save_redirect = $back;
            $this->page_cancel_redirect = $back;
        }else{
            $this->page_save_redirect = 'dwf/document/list/'.trim($id);
            $this->page_cancel_redirect = 'dwf/document/list/'.trim($id);
        }

        if( !is_null($keyword1) && $keyword1 != ''){
            $this->item_id = trim($keyword1);
            $this->title = 'Edit '.$entity->docNo;
        }

        $this->form_layout = 'dwf.document.'.$form_layout;

        $this->page_methods_view = 'dwf.document.edit_methods';
        $this->page_computed_view = 'dwf.document.edit_computed';
        $this->page_watch_view = 'dwf.document.edit_watch';

        $this->show_print_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['docGroupOptions'] = [];
        $formOptions['confidentialityOptions'] = [ ['text'=>'B', 'value'=>'B'],['text'=>'R', 'value'=>'R'] ];

        if($keyword0 == 'lembar-disposisi'){
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getDispoTitleCode(), 'jobCode', '_object', false ) ;
        }else{
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode( $keyword0 ), 'jobCode', '_object', false ) ;
        }

        $formOptions['docClassOptions'] = DwfUtil::toOptions( DwfUtil::getDocClass(), ['classCode','docClass'], 'classCode', false ) ;
        $formOptions['delegatesOptions'] = [ ['text'=>'Langsung', 'value'=>'Langsung'],['text'=>'a.n', 'value'=>'a.n'],['text'=>'a.n/u.b', 'value'=>'a.n/u.b']  ];
        $formOptions['dispositionContentOptions'] =  DwfUtil::toOptions( DwfUtil::getDispoItems(), 'description', 'itemName', false );
        $formOptions['docGroupOptions'] = [];
        $formOptions['footerOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), 'bizUnitName', '_object', false );;
        $formOptions['titleCodeDisable'] = 'false' ;

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }

        $this->aux_data = $formOptions;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }


    public function getEditDocument(Request $request, $keyword0, $keyword1 = null,$keyword2 = null ){
        $this->res_path = 'models/controllers/dwf';
        $this->yml_file = 'document_controller';

        $this->nav_path = 'views/partials/app/dms';
        $this->nav_file = 'nav';
        $this->logo = env('APP_LOGO');

        $this->title = 'Edit Naskah';
        $this->has_tab = false;

        $this->show_title = false;

        $this->add_url = 'dwf/document/add';

        $this->update_url = 'dwf/document/edit';

        $this->item_data_url = 'dwf/document/data';

        $this->autosave_url = 'clinic/operasi/autosave';

        $this->localStorageKey = 'SC_'.date('Ymd', time()).'_'.Auth::user()->cliCode;

        $this->item_id = $keyword1;

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_mode = 'add';

        $this->can_autosave = false;

        $this->can_add = false;

        $this->can_save = true;

        $this->can_print = true;

        $this->js_load_transform = 'dwf.document.edit_load_transform';

        $this->print_template = 'doc-label';
        $this->print_modal_size = 'md';

        $this->can_lock = true;

        $this->keyword0 = $keyword0;
        $this->keyword1 = $keyword1;
        $this->keyword2 = $keyword2;

        $entity = $this->model->find( $this->item_id );

        if($keyword0 != '' && $keyword0 != 'status'){
            $layout = str_replace('-', '_', $keyword0);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
            $this->page_redirect_after_save = true;
            $this->page_save_redirect = 'dwf/document/list/'.trim($keyword0);
            $this->page_cancel_redirect = 'dwf/document/list/'.trim($keyword0);
        }else{
            $form = $entity->formTemplate;
            $layout = str_replace('-', '_', $form);
            if( View::exists('dwf.document.'.$layout) ){
                $form_layout = $layout;
            }
            $this->page_redirect_after_save = true;

            if($request->has('back')){
                $back = $request->get('back');
                $this->page_save_redirect = 'dwf/document/list/'.$back;
                $this->page_cancel_redirect = 'dwf/document/list/'.$back;
            }else{
                $this->page_save_redirect = 'dwf/document/list/'.trim($keyword0);
                $this->page_cancel_redirect = 'dwf/document/list/'.trim($keyword0);
            }

        }

        if( !is_null($keyword1) && $keyword1 != ''){
            $this->item_id = trim($keyword1);
            $this->title = 'Edit '.$entity->docNo;
        }

        $this->form_layout = 'dwf.document.'.$form_layout;

        $this->page_methods_view = 'dwf.document.edit_methods';
        $this->page_computed_view = 'dwf.document.edit_computed';
        $this->page_watch_view = 'dwf.document.edit_watch';

        $this->show_print_button = true;

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

//        $formOptions['attachmentsObjects'] = [];
        $formOptions['docGroupOptions'] = [];
        $formOptions['confidentialityOptions'] = [ ['text'=>'B', 'value'=>'B'],['text'=>'R', 'value'=>'R'] ];

        if($keyword0 == 'lembar-disposisi'){
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getDispoTitleCode(), 'jobCode', '_object', false ) ;
        }else{
            $formOptions['titleCodeOptions'] = DwfUtil::toOptions( DwfUtil::getTitleCode( $keyword0 ), 'jobCode', '_object', false ) ;
        }

        $formOptions['docClassOptions'] = DwfUtil::toOptions( DwfUtil::getDocClass(), ['classCode','docClass'], 'classCode', false ) ;
        $formOptions['delegatesOptions'] = [ ['text'=>'Langsung', 'value'=>'Langsung'],['text'=>'a.n', 'value'=>'a.n'],['text'=>'a.n/u.b', 'value'=>'a.n/u.b']  ];
        $formOptions['dispositionContentOptions'] =  DwfUtil::toOptions( DwfUtil::getDispoItems(), 'description', 'itemName', false );
        $formOptions['docGroupOptions'] = [];
        $formOptions['footerOptions'] = DwfUtil::toOptions( RefUtil::getBizUnit(), 'bizUnitName', '_object', false );;
        $formOptions['titleCodeDisable'] = 'false' ;

        //dd($formOptions['footerOptions'] );

//        if($keyword0 == 'surat-dinas' || $keyword0 == 'nota-dinas'){
//            $formOptions['titleCodeDisable'] = 'false' ;
//        }else{
//            $formOptions['titleCodeDisable'] = 'true' ;
//        }

        $this->aux_data = $formOptions;

        return parent::formGenerator();

    }

    public function postReceiveDoc(Request $request)
    {

    }

    public function postSendDoc(Request $request){

        Util::ajaxDebug();

        $item = $request->get('item');

        $doc = $this->model->find($item['_id']);

        if($doc){

            $docArray = $doc->toArray();
            //sender list
            $rec = $docArray['recipient'];
            $prec = [];
            $rec_ids = [];
            $rec_emails = [];
            foreach ($rec as $r){
                if( ( is_null($r['obj']['email']) || $r['obj']['email'] == '' ) || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'alias' ) ){
                    $jids = GroupAlias::where('groupName','=',$r['obj']['name'])->get();
                    if( $jids ){
                        $jits = [];
                        foreach ( $jids as $j){
                            if(isset($j->jobTitleCode)){
                                $jits[] = $j->jobTitleCode;
                            }
                        }
                        $pars = User::whereIn('jobTitleCode', $jits )->get();
                        if($pars){
                            foreach ($pars->toArray() as $par){
                                $nr = [];
                                $nr['key'] = $par['_id'];
                                $nr['label'] = $par['name'];
                                $nr['obj'] = [
                                    '_id'=> $par['_id'],
                                    'email'=> $par['email'],
                                    'name'=> $par['name'],
                                    'username'=> $par['username'],
                                    'jobTitle'=> $par['jobTitle'],
                                    'jobTitleCode'=> $par['jobTitleCode'],
                                    'avatar'=> $par['avatar'],
                                    'seq'=> ( $par['seq'] ?? '000' )
                                ];
                                $prec[] = $nr;
                                if( isset($par['_id']) && !is_null($par['_id']) && $par['_id'] != '' ){
                                    $rec_ids[] = new ObjectId($par['_id']);
                                }
                                if( isset($par['email']) && !is_null($par['email']) && $par['email'] != '' ){
                                    $rec_emails[] = $par['email'];
                                }
                            }
                        }
                    }
                }

                if( ( (is_null($r['obj']['email']) || $r['obj']['email'] == '') ) || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'disposisi' ) ){
                    $jids = JobGroup::where('jobTitle','=',$r['obj']['jobTitle'])
                        ->where('jobTitleCode','=',$r['obj']['jobTitleCode'])
                        ->get();

                    if( $jids ){
                        $jits = [];
                        $jims = [];
                        foreach ( $jids as $j){
                            if(isset($j->employeeId) && $j->employeeId != '' ){
                                $jits[] = $j->employeeId;
                            }
                            if(isset($j->email) && $j->email != '' ){
                                $jims[] = $j->email;
                            }
                        }

                        $pars = User::whereIn('employeeId', $jits )
                            ->orWhere(function($q) use ($jims) {
                                $q->whereIn('email', $jims);
                            })
//                            ->groupBy('email')
                            ->get(
                                [
                                    '_id',
                                    'email',
                                    'name',
                                    'username',
                                    'jobTitle',
                                    'jobTitleCode',
                                    'avatar',
                                    'seq'
                                ]
                            );

                        if($pars){
                            foreach ($pars->toArray() as $par){

                                $nr = [];
                                $nr['key'] = $par['_id'];
                                $nr['label'] = $par['name'];
                                $nr['obj'] = [
                                    '_id'=> $par['_id'],
                                    'email'=> $par['email'],
                                    'name'=> $par['name'],
                                    'username'=> $par['username'],
                                    'jobTitle'=> $par['jobTitle'],
                                    'jobTitleCode'=> $par['jobTitleCode'],
                                    'avatar'=> $par['avatar'],
                                    'seq'=> ( $par['seq'] ?? '000' )
                                ];
                                $prec[] = $nr;
                                if( isset($par['_id']) && !is_null($par['_id']) && $par['_id'] != '' ){
                                    $rec_ids[] = new ObjectId($par['_id']);
                                }
                                if( isset($par['email']) && !is_null($par['email']) && $par['email'] != '' ){
                                    $rec_emails[] = $par['email'];
                                }
                            }
                        }
                    }
                }

                if( !(is_null($r['obj']['email']) || $r['obj']['email'] == '') || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'person' ) ){
                    $prec[] = $r;
                    if( isset($r['obj']['_id']) && !is_null($r['obj']['_id']) && $r['obj']['_id'] != '' ){
                        $rec_ids[] = new ObjectId($r['obj']['_id']);
                    }
                    if( isset($r['obj']['email']) && !is_null($r['obj']['email']) && $r['obj']['email'] != '' ){
                        $rec_emails[] = $r['obj']['email'];
                    }
                }
            }

            $doc->sendRecipient = $prec;

            //cc list
            $rec = $docArray['copy'] ?? [];
            $prec = [];
            $cc_ids = [];
            $cc_emails = [];
            foreach ($rec as $r){
                if( ( is_null($r['obj']['email']) || $r['obj']['email'] == '' ) || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'alias' ) ){
                    $jids = GroupAlias::where('groupName','=',$r['obj']['name'])->get();
                    if( $jids ){
                        $jits = [];
                        foreach ( $jids as $j){
                            if(isset($j->jobTitleCode)){
                                $jits[] = $j->jobTitleCode;
                            }
                        }
                        $pars = User::whereIn('jobTitleCode', $jits )->get();

                        if($pars){
                            foreach ($pars->toArray() as $par){
                                $nr = [];
                                $nr['key'] = $par['_id'];
                                $nr['label'] = $par['name'];
                                $nr['obj'] = [
                                    '_id'=> $par['_id'],
                                    'email'=> $par['email'],
                                    'name'=> $par['name'],
                                    'username'=> $par['username'],
                                    'jobTitle'=> $par['jobTitle'],
                                    'jobTitleCode'=> $par['jobTitleCode'],
                                    'avatar'=> $par['avatar'],
                                    'seq'=> ( $par['seq'] ?? '000' )
                                ];
                                $prec[] = $nr;
                                if( isset($par['_id']) && !is_null($par['_id']) && $par['_id'] != '' ){
                                    $cc_ids[] = new ObjectId($par['_id']);
                                }
                                if( isset($par['email']) && !is_null($par['email']) && $par['email'] != '' ){
                                    $cc_emails[] = $par['email'];
                                }
                            }
                        }
                    }
                }

                if( ( (is_null($r['obj']['email']) || $r['obj']['email'] == '') ) || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'disposisi' ) ){
                    $jids = JobGroup::where('jobTitle','=',$r['obj']['jobTitle'])
                        ->where('jobTitleCode','=',$r['obj']['jobTitleCode'])
                        ->get();

                    if( $jids ){
                        $jits = [];
                        $jims = [];
                        foreach ( $jids as $j){
                            if(isset($j->employeeId)){
                                $jits[] = $j->employeeId;
                            }
                            if(isset($j->email) && $j->email != '' ){
                                $jims[] = $j->email;
                            }
                        }

                        $pars = User::whereIn('employeeId', $jits )
                            ->orWhere(function($q) use ($jims) {
                                $q->whereIn('email', $jims);
                            })
                            ->groupBy('_id')
                            ->get([
//                                '_id',
                                'email',
                                'name',
                                'username',
                                'jobTitle',
                                'jobTitleCode',
                                'avatar',
                                'seq'
                            ]);

                        if($pars){
                            foreach ($pars->toArray() as $par){
                                $nr = [];
                                $nr['key'] = $par['_id'];
                                $nr['label'] = $par['name'];
                                $nr['obj'] = [
                                    '_id'=> $par['_id'],
                                    'email'=> $par['email'],
                                    'name'=> $par['name'],
                                    'username'=> $par['username'],
                                    'jobTitle'=> $par['jobTitle'],
                                    'jobTitleCode'=> $par['jobTitleCode'],
                                    'avatar'=> $par['avatar'],
                                    'seq'=> ( $par['seq'] ?? '000' )
                                ];
                                $prec[] = $nr;
                                if( isset($par['_id']) && !is_null($par['_id']) && $par['_id'] != '' ){
                                    $cc_ids[] = new ObjectId($par['_id']);
                                }
                                if( isset($par['email']) && !is_null($par['email']) && $par['email'] != '' ){
                                    $cc_emails[] = $par['email'];
                                }
                            }
                        }
                    }
                }

                if( !(is_null($r['obj']['email']) || $r['obj']['email'] == '') || ( isset($r['obj']['datatype']) && $r['obj']['datatype'] == 'person' ) ){
                    $prec[] = $r;
                    if( isset($r['obj']['_id']) && !is_null($r['obj']['_id']) && $r['obj']['_id'] != '' ){
                        $cc_ids[] = new ObjectId($r['obj']['_id']);
                    }
                    if( isset($r['obj']['email']) && !is_null($r['obj']['email']) && $r['obj']['email'] != '' ){
                        $cc_emails[] = $r['obj']['email'];
                    }
                }
            }

            $doc->copyRecipient = $prec;

            $doc->sendStatus = 'SENT';

            $doc->save();

            $approveAs = (  isset($data['ownerId']) && $data['ownerId'] == Auth::user()->_id ? 'CREATOR' : 'SENDER');

            $next = [];
            $next['approverId'] = Auth::user()->_id;
            $next['approverName'] = Auth::user()->name;
            $next['authorizationSign'] = '';
            $next['initialSign'] = '';
            $next['note'] = '';
            $next['decision'] = 'SENT';
            $next['approveAs'] = $approveAs;

            $data = $doc->toArray();

            Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

            try {

                $rec_users = User::whereIn('_id', $rec_ids)
//                    ->orWhere(function($q) use ($rec_emails){
//                        $q->whereIn('email', $rec_emails);
//                    })
//                    ->groupBy('_id')
                    ->get();

                DwfUtil::sendNotification($rec_users, \App\Notifications\RecipientNotification::class, $doc, 'SURAT BARU');

                $cc_users = User::whereIn('_id', $cc_ids)
//                    ->orWhere(function($q) use ($cc_emails){
//                        $q->whereIn('email', $cc_emails);
//                    })
//                    ->groupBy('_id')
                    ->get();
                DwfUtil::sendNotification($cc_users, \App\Notifications\RecipientNotification::class, $doc, 'TEMBUSAN');

                DwfUtil::sendEmails($data);
            }catch (Exception $exception){

            }

            return response()->json(
                [
                    'result'=>'OK',
                    'msg'=>'Document Sent',
                    'data'=>$data
                ],
                200
            );
        }else{
            return response()->json(
                [
                    'result'=>'ERR',
                    'msg'=>'Doc not found',
                    'data'=>[]
                ],
                415
            );

        }
    }

    public function postArchiveDoc(Request $request){

        Util::ajaxDebug();

        $item = $request->get('item');

        $category = $request->get('archiveCategory');

        $doc = $this->model->find($item['_id']);

        if($doc){

            $docArray = $doc->toArray();

            $archive = DwfUtil::archiveDoc($docArray, $category);

            if($archive){

                $doc->archiveStatus = 'ARCHIVED';
                $doc->archiveCallCode = $archive ;

                $doc->save();

                $next = [];
                $next['approverId'] = Auth::user()->_id;
                $next['approverName'] = Auth::user()->name;
                $next['authorizationSign'] = '';
                $next['initialSign'] = '';
                $next['note'] = '';
                $next['decision'] = 'ARCHIVED';
                $next['approveAs'] = 'ARCHIVER';

                $data = $doc->toArray();

                Util::approvallog( $next, $data , $data['_id'] ?? '', $data['docType'] ?? '', $this->auth_entity );

                return response()->json(
                    [
                        'result'=>'OK',
                        'msg'=>'Document Archived',
                        'data'=>$data
                    ],
                    200
                );

            }else{
                return response()->json(
                    [
                        'result'=>'ERR',
                        'msg'=>'Failed archiving',
                        'data'=>[]
                    ],
                    415
                );
            }

        }else{
            return response()->json(
                [
                    'result'=>'ERR',
                    'msg'=>'Doc not found',
                    'data'=>[]
                ],
                415
            );

        }

    }

    public function afterLogPrintData($doc, $next)
    {
        $_id = $doc['_id'] ?? false;
        if($_id){
            $document = Document::find($_id);
            if($document){
                $reads = $document->readHistory ?? [];
                $reads[] = $next;
                $document->readHistory = $reads;
                $document->save();
            }
        }
        parent::afterLogPrintData($doc,$next); // TODO: Change the autogenerated stub
    }


    public function getHistory(Request $request){

        $id = $request->get('itemId');
        $status = $request->get('status', 'all');

        if($status == 'all'){
            $history = ApprovalStatusLog::where('itemId', '=', $id)
                ->orderBy('createdAt','desc')
                ->get();
        }else{
            $history = ApprovalStatusLog::where('itemId', '=', $id)
                ->where('changeTo','=', strtoupper($status))
                ->orderBy('createdAt','desc')
                ->get();
        }

        if($history){
            return response()->json(
                [
                    'result'=>'OK',
                    'msg'=>'OK',
                    'data'=>$history->toArray()
                ],
                200
            );
        }else{
            return response()->json(
                [
                    'result'=>'ERR',
                    'msg'=>'ERR',
                    'data'=>[]
                ],
                415
            );

        }

    }


}
