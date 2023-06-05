<?php
namespace App\Helpers\App;


use App\Helpers\AuthUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Models\Core\Mongo\Role;
use App\Models\Core\PrintCache;
use App\Models\Directory\Knowledge\DocCatalogue;
use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Dwf\Admin\ArchiveDocType;
use App\Models\Dwf\Admin\ArchiveGroup;
use App\Models\Dwf\Admin\ArchiveLocation;
use App\Models\Dwf\Admin\ArchiveType;
use App\Models\Dwf\Admin\DispositionItem;
use App\Models\Dwf\Admin\JobGroup;
use App\Models\Dwf\DocClass;
use App\Models\Obj\PrintTemplate;
use App\Models\Reference\Area;
use App\Models\Reference\BizUnit;
use App\Models\Reference\JobTitle;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Core\Mongo\Sequence;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Directory\VendorDirectory;
use Flynsarmy\DbBladeCompiler\Facades\DbView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use WeasyPrint\WeasyPrint;


class DwfUtil {

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>''  ];
        }

        foreach ($data as $d){
            $label = '';
            if( is_array( $text ) ){
                $lbl = [];
                foreach($text as $f){
                    $lbl[] = $d[$f]?? '';
                }
                $label = implode(' ', $lbl);
            }else{
                if(!is_null($text)){
                    $label = $d[$text]??'';
                }
            }

            debug('label '.$label);
            if(strlen($label) > 50){
                $label = substr($label, 0, 50).' ...';
            }

            if($value == '_object'){
                $opt[] = [ 'text'=>$label, 'value'=>$d  ];
            }else{
                $opt[] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        return $opt;

    }

    public static function toGroupOptions($data, $text, $value, $groupField ,$all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'None', 'value'=>''  ];
        }

        $gl = [];
        foreach ($data as $d){
            $gl[ $d[$groupField] ] = [
                'label'=>$d[$groupField],
                'options'=>[]
            ];
        }

        $opts = [];

        foreach ($data as $d){
            $label = '';
            if( is_array( $text ) ){
                $lbl = [];
                foreach($text as $f){
                    $lbl[] = $d[$f]?? '';
                }
                $label = implode(' ', $lbl);
            }else{
                if(!is_null($text)){
                    $label = $d[$text]??'';
                }
            }

            debug('label '.$label);
            if(strlen($label) > 50){
                $label = substr($label, 0, 50).' ...';
            }

            if( !isset( $opts[$d[$groupField]] ) ){
                $opts[$d[$groupField]] = [];
            }

            if($value == '_object'){
                $opts[$d[$groupField]][] = [ 'text'=>$label, 'value'=>$d  ];
            }else{
                $opts[$d[$groupField]][] = [ 'text'=>$label, 'value'=>$d[$value]  ];
            }

        }

        foreach($gl as $k=>$v){
            if(isset($gl[$k]) && isset($opts[$k])){
                $gl[$k]['options'] = $opts[$k];
            }
        }

        return $gl;

    }

    public static function getArchiveMenu()
    {
        $archs = ArchiveType::orderBy('groupCode', 'desc')
            ->orderBy('subGroupCode', 'asc')
            ->orderBy('menuSeq','asc')
            ->get();

        $archs = $archs->toArray();

        $parc = [];
        foreach ($archs as $ar){
            $parc[$ar['groupCode']][ $ar['groupCode'].'-'.$ar['subGroupCode']] = [
                'title'=>$ar['subGroup'],
                'key'=>$ar['subGroupCode'],
                'icon'=>'<i class="link-icon"  data-feather="file-text"></i>',
                'auth'=>'dwf-archive-'.$ar['groupCode'].'-'.$ar['subGroupCode'],
                'children'=>[]
            ];
        }

        $arc = [];
        foreach ($archs as $ar){
            $arc[ $ar['groupCode'].'-'.$ar['subGroupCode'] ][] = [
                'title'=>$ar['menuTitle'],
                'icon'=>'<i class="link-icon"  data-feather="file-text"></i>',
                'url'=>'dwf/archive/list/'.$ar['groupCode'].'/'.$ar['callCode'],
                'auth'=>$ar['menuAuth']
            ];
        }
//        print_r($arc);

        $menu = [];
        foreach ($parc as $k=>$p){
            foreach ($p as $n=>$x){
                $mo = $parc[$k][$n];
                $mo['children'] = $arc[$n];
                $menu[$k][] = $mo;
            }
        }

        return $menu;
    }
    public static function getArchiveOneLevelMenu($groupCode)
    {
        $archs = ArchiveType::where('groupCode', '=', $groupCode)
//            ->orderBy('groupCode', 'desc')
//            ->orderBy('subGroupCode', 'asc')
            ->orderBy('menuSeq','asc')
            ->get();

        $archs = $archs->toArray();

        $menu = [];
        foreach ($archs as $ar){
            $menu[] = [
                'title'=>$ar['subGroup'],
                'url'=>'dwf/archive/list/'.$ar['groupCode'].'/'.$ar['callCode'],
                'icon'=>'<i class="link-icon"  data-feather="file-text"></i>',
                'auth'=>'dwf-archive-'.$ar['callCode'],
                //'children'=>[]
            ];
        }

        return $menu;
    }

    public static function getDocClass($group = null)
    {
        $docclass = DocClass::orderBy('classType', 'asc')
            ->orderBy('classCode', 'asc')
            ->get();
        return $docclass->toArray();
    }

    public static function getArchiveType($group = null, $roleSet = null)
    {
        $docclass = new ArchiveType();
        if( !is_null($group) ){
            $docclass = $docclass->where('groupCode', '=', $group);
        }
        if( !is_null($roleSet) && is_array($roleSet) && !(AuthUtil::isAdmin() ||AuthUtil::isRoot() ) ){
            $docclass = $docclass->whereIn('menuAuth',  $roleSet);
        }

        $docclass = $docclass->orderBy('groupCode', 'desc')
            ->orderBy('subGroupCode', 'asc')
            ->orderBy('docTypeCode', 'asc')
            ->get([
                'group',
                'groupCode',
                'subGroup',
                'subGroupCode',
                'docType',
                'docTypeCode',
                'location',
                'locationCode',
                'callCode',
            ]);

        return $docclass->toArray();
    }

    public static function getArchiveActiveRole($group = null)
    {
        $roles = Role::find( Auth::user()->roleId);
        $roleSet = [];
        if($roles && !is_null($group)){
            $acls = $roles->roleACL ?? [];
            if(!empty($acls)){
                $prefix = 'dwf-archive-'.$group.'-';
                foreach ($acls as $key=>$acl){
                    if( preg_match( '/^'.$prefix.'/i' , $key  ) ){
                        foreach ($acl['acl'] as $c){
                            if($c['key'] == 'read' && $c['value'] ){
                                $roleSet[] = $key;
                            }
                        }
                    }
                }
            }
        }
        return $roleSet;
    }

    public static function getDispoTitleCode()
    {
        $doctypes = JobGroup::groupBy('jobTitleCode')
            ->orderBy('subGroup', 'asc')
            ->orderBy('seq', 'asc')
            ->get([
                'group',
                'jobTitleCode',
                'jobTitle',
                'personnelName',
                'seq'
            ]);

        $dispoTitles = [];
        foreach ($doctypes->toArray() as $v){
            $dispoTitles[] = [
                'subGroup'=> $v['group'] ,
                'jobCode'=> $v['jobTitleCode'] ,
                'jobTitle'=> $v['jobTitle'] ,
                'description'=> $v['personnelName'] ,
                'seq'=> $v['seq']
            ];
        }

        return $dispoTitles;
    }

    public static function getTitleCode($group = null)
    {
        if(is_null($group)){
            $doctypes = JobTitle::groupBy('jobCode')
                ->orderBy('subGroup', 'asc')
                ->orderBy('seq', 'asc')
                ->get([
                    'subGroup',
                    'jobCode',
                    'jobTitle',
                    'description',
                    'seq'
                ]);
        }else{
//            if(JobTitle::where('group','=',$group)->count() == 0){
//                $doctypes = JobTitle::groupBy('jobCode')
//                    ->orderBy('subGroup', 'asc')
//                    ->orderBy('seq', 'asc')
//                    ->get([
//                        'subGroup',
//                        'jobCode',
//                        'jobTitle',
//                        'description',
//                        'seq'
//                    ]);
//            }else{
                $doctypes = JobTitle::where('group','=',$group)
                    ->orderBy('subGroup', 'asc')
                    ->orderBy('seq', 'asc')
                    ->get([
                        'subGroup',
                        'jobCode',
                        'jobTitle',
                        'description',
                        'seq'
                    ]);
//            }
        }
        return $doctypes->toArray();
    }

    public static function getUserJobObject($jobCode)
    {
        $job = JobTitle::where('jobCode','=',$jobCode)
//            ->orderBy('subGroup', 'asc')
//            ->orderBy('seq', 'asc')
            ->first([
                'subGroup',
                'jobCode',
                'jobTitle',
                'description',
                'seq'
            ]);

        if($job){
            $job = $job->toArray();
            unset($job['_id']);
            $job['_id'] = [ 'jobCode'=>$job['jobCode'] ];
        }else{
            $job = [];
        }

        return $job;
    }

    public static function getDocType($group = null)
    {
        if(is_null($group)){
            $doctypes = DocType::whereNull('DocTypeGroup')
                ->orWhere('DocTypeGroup','exists',false)
                ->orderBy('DocType', 'asc')->get();
        }else{
            $doctypes = DocType::where('DocTypeGroup','=',$group)->orderBy('DocType', 'asc')->get();
        }
        return $doctypes->toArray();
    }

    public static function getDispoItems($group = null)
    {
        $doctypes = DispositionItem::orderBy('seq', 'asc')->get();
        return $doctypes->toArray();
    }

    public static function getCompany()
    {
        $coycodes = CoyCode::orderBy('CoyCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getYearOptions()
    {
        $disposal = DocDisposal::orderBy('CoyCode', 'asc')->get();
        return $disposal->toArray();
    }

  public static function getProvince()
  {
    $coycodes = Area::groupBy('provinceName')->orderBy('provinceName', 'asc')->get();
    return $coycodes->toArray();
  }

  public static function getCity($provinceName)
  {
    // if(count($province)) {
    //     $coycodes = City::where('_id', '=', $province[0]['_id'])->orderBy('cityCode', 'asc')->get();
    //     return $coycodes->toArray();
    // }
    $coycodes = Area::where('provinceName','=',$provinceName)->groupBy('cityName')->orderBy('cityName', 'asc')->get();
    return $coycodes->toArray();
  }

    public static function getTopics()
    {
        $disposal = CallCode::orderBy('Topic', 'asc')->get();

        $topics = $disposal->toArray();

        for($i = 0; $i < count($topics); $i++ ){
            $topics[$i]['LongDescr'] = $topics[$i]['Topic'] .' '.$topics[$i]['TopicDescr'];
        }
        return $topics;
    }

    public static function getTopic($topic)
    {
        $topic = CallCode::where('Topic','=', trim($topic))->first();

        if($topic){
            return $topic->toArray();
        }else{
            return false;
        }
    }

    public static function getArchDocType()
    {
        $doctypes = ArchiveDocType::orderBy('docTypeCode', 'asc')->get();

        if($doctypes){
            $types = [];
            foreach ($doctypes as $d){
                $types[] = [
                    'docTypeCode' => $d->docTypeCode,
                    'docType' => $d->docType,
                ];
            }
            return $types;
        }else{
            return [];
        }
    }

    public static function getArchGroup()
    {
        $groups = ArchiveGroup::orderBy('groupCode', 'asc')->get();

        if($groups){
            $grps = [];
            foreach ($groups as $g){
                $grps[] = [
                    'groupCode' => $g->groupCode,
                    'group' => $g->group,
                ];
            }
            return $grps;
        }else{
            return [];
        }
    }

    public static function getArchSubGroup()
    {
        $groups = BizUnit::orderBy('seq','asc')->orderBy('bizUnitCode', 'asc')->get();

        if($groups){
            $grps = [];
            foreach ($groups as $g){
                $grps[] = [
                    'subGroup' => $g->bizUnitName,
                    'subGroupCode' => $g->bizUnitCode,
                ];
            }
            return $grps;
        }else{
            return [];
        }
    }

    public static function getArchLocation()
    {
        $locations = ArchiveLocation::orderBy('locationCode', 'asc')->get();

        if($locations){
            $locs = [];
            foreach ($locations as $l){
                $locs[] = [
                    'locationCode' => $l->locationCode,
                    'location' => $l->location,
                ];
            }
            return $locs;
        }else{
            return [];
        }
    }

    public static function getSequence($entity, $padded = true)
    {
        $sequencer = new Sequence();
        $seq = $sequencer->getNewId($entity);

        return ($padded)? str_pad($seq, env('NUM_PAD', 5), '0', STR_PAD_LEFT ) : $seq;

    }

    public static function getVendors()
    {
        $vendorlist = VendorDirectory::where('vendorCode', 'exists', true)->orderBy('vendorCode', 'asc')->get();

        $vendors = $vendorlist->toArray();

        for($i = 0; $i < count($vendors); $i++ ){
            $vendors[$i]['LongDescr'] = ($vendors[$i]['vendorCode'] ?? '') .' '.$vendors[$i]['coyName'];
        }
        return $vendors;
    }

    public function prepareAttachment($data, $templateslug, $fileId){

        if(PrintTemplate::where('slug', '=', $templateslug)->count() > 0 ){
            $template = PrintTemplate::where('slug', '=', $templateslug)->first();
        }else{
            $template = PrintTemplate::where('slug', '=', 'default')->first();
        }

        $pageSize = $template->pageSize ?? '';
        $headerFooterSetting = $template->headerFooterSetting ?? [];
        $headerSetting = $template->headerSetting ?? [];
        $footerSetting = $template->footerSetting ?? [];
        $numberSetting = $template->numberSetting ?? [];
        $numberFormat = $template->numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)";
        $numberPosition = $template->numberPosition ?? 'Right';
        $firstNumberPosition = $template->firstNumberPosition ?? 'Right';

        if($data && $template){
            $html = DbView::make($template)->field('template')
                ->with($data)
                ->with('pageSize', $pageSize )
                ->with('headerFooterSetting', $headerFooterSetting )
                ->with('headerSetting', $headerSetting )
                ->with('footerSetting', $footerSetting )
                ->with('numberSetting', $numberSetting )
                ->with('numberFormat', $numberFormat )
                ->with('numberPosition', $numberPosition )
                ->with('firstNumberPosition', $firstNumberPosition )
                ->render();
            $site = url('/');

            if( strpos($site,'localhost') || strpos($site,'127.0.0.1') ){

            }else{
                $html = str_replace( $site, 'http://localhost', $html );
            }

            $weasyprint = WeasyPrint::make($html);

            return $weasyprint->toPdf();
        }else{
            return null;
        }


    }

    public static function archiveDoc($data, $category){

        $cat = ArchiveType::where('callCode', '=', $category)->first();

        $max = DocCatalogue::where( 'category', '=', $category )->max('seq');
        $max++;
        $newseq = $max;
        $FCallCode = $category.'-'.str_pad( $max , 5, "0", STR_PAD_LEFT);

        $handle = Util::randomstring(12, 'alphanumeric');

        $filename = ($FCallCode ?? $data['_id']).'.pdf';

        $url = '';

        $buckets = config('app.buckets.names');

        try {
            $attachData = [
                'content'=>[
                    $data
                ]
            ];

            $file_content = self::prepareAttachment($attachData, $data['formTemplate'], $filename );

            $storage_driver = env('STORAGE_DRIVER', 'local');

            if($storage_driver == 'minio' || $storage_driver == 's3' ){
                $storage_driver = $buckets['archive'];
            }

            $filepath = $handle.'/'.$filename;
            if($storage_driver == 'local'){
                $filepath = 'public/'.$filetype.'/'.$handle.'/'.$filename;
            }

            $res = Storage::disk($storage_driver)
                ->put($filepath, $file_content );

            $url = Storage::disk($storage_driver)->url( $filepath );

        }catch ( \Exception $exception){
            print $exception->getMessage();
        }
        $arc = new DocCatalogue();
        $arc->handle = $handle;
        $arc->section =  null ;
        $arc->category =  $category ;
        $arc->categoryObject =  $cat->toArray() ;
        $arc->DocRef =  $data['docNo'] ;
        $arc->Sender =  $data['sender'] ?? null ;
        $arc->Recipient =  $data['recipient'] ?? [] ;
        $arc->Signer =  $data['signer'] ?? [] ;
        $arc->Creator =  $data['ownerName'] ?? '' ;
        $arc->CreatorId =  $data['ownerId'] ?? '' ;
        $arc->Subject =  null ;
        $arc->DocDate =  null ;
        $arc->FileUrl =  $url ;
        $arc->RevNo =  null ;
        $arc->FCallCode = $FCallCode ;
        $arc->group =  $cat->group ;
        $arc->groupCode = $cat->groupCode ;
        $arc->subGroup = $cat->subGroup ;
        $arc->subGroupCode = $cat->subGroupCode ;
        $arc->docType = $cat->docType ;
        $arc->docTypeCode = $cat->docTypeCode ;
        $arc->location = $cat->location ;
        $arc->locationCode = $cat->locationCode ;
        $arc->callCode = $cat->callCode ;
        $arc->keywords =  [
            'keyword0' =>  $cat->groupCode,
            'keyword1' =>  $category,
            'keyword2' =>  null
        ];
        $arc->ownerId =  Auth::user()->_id ;
        $arc->ownerName =  Auth::user()->name ;
        $arc->domainNs =  env('APP_NAMESPACE') ;
        $arc->seq =  $newseq ;

        $arc =  TimeUtil::createTime($arc, env('DEFAULT_TIME_ZONE')) ;

        if($arc->save()){
            return $arc->FCallCode;
        }else{
            return false;
        }

    }

    public static function sendNotification($users, $notificationType, $data, $req){
        foreach($users as $user){
            $user->notify( new $notificationType($data, $req));
        }
    }

    public static function sendEmails($data){
        $recipient = $data['sendRecipient'];
        $copy = $data['copyRecipient'];
        $bcc = [];
        $docType = \App\Models\Dwf\DocType::where('docType','=', $data['docType'] )->first();
        $template = $docType->docTransmittal ?? null;

        $attachmentId = $data['_id'].'.pdf' ?? 'no-id.pdf';
        $attachmentBin = null;
        try {
            $attachData = [
                'content'=>[
                    $data
                ]
            ];
            $attachId = $data['_id'] ?? 'attachmentId';
            $attachmentBin = self::prepareAttachment($attachData, $data['formTemplate'], $attachId );
            $attachmentBin = base64_encode($attachmentBin);
        }catch ( \Exception $exception){

        }

        foreach ($recipient as $rec){
            if(!is_null($rec['obj']['email']) && $rec['obj']['email'] != '' ){
                $toEmail = $rec['obj']['email'];
                $toName = $rec['obj']['name'] ?? 'Receiver';
                $subject = $data['docNo'].' '.$data['subject'];
                $cc = [];
                $bcc = [];
                if(env('MAIL_DEBUG', true)){
                    $toEmail = env('MAIL_TEST_RECIPIENT');
                    $toName = env('MAIL_TEST_RECIPIENT_NAME');
                    $cc = [];
                    $bcc = [];
                }
                $data['messageId'] = Str::random();
                Mail::to($toEmail)
                    ->queue(new \App\Mail\GenericEmail( $template, $data, $subject ,$toEmail, $toName, $cc, $bcc, $attachmentBin, $attachmentId ));
            }
        }

        foreach ($copy as $rec){
            if(!is_null($rec['obj']['email']) && $rec['obj']['email'] != '' ){
                $toEmail = $rec['obj']['email'];
                $toName = $rec['obj']['name'] ?? 'CC Receiver';
                $subject = 'Tembusan : '.$data['docNo'].' '.$data['subject'];
                $cc = [];
                $bcc = [];
                if(env('MAIL_DEBUG', true)){
                    $toEmail = env('MAIL_TEST_CC');
                    $toName = env('MAIL_TEST_CC_NAME');
                }
                $data['messageId'] = Str::random();
                Mail::to($toEmail)
                    ->queue(new \App\Mail\GenericEmail( $template, $data, $subject ,$toEmail, $toName, $cc, $bcc, $attachmentBin, $attachmentId ));
            }
        }

    }

}
