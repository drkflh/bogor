<?php
namespace App\Helpers\App;


use App\Helpers\AuthUtil;
use App\Helpers\TimeUtil;
use App\Helpers\Util;
use App\Models\Core\Mongo\Role;
use App\Models\Core\Mongo\User;
use App\Models\Core\PrintCache;
use App\Models\Directory\Knowledge\DocCatalogue;
use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Dwf\Admin\ArchiveType;
use App\Models\Dwf\Admin\DispositionItem;
use App\Models\Dwf\Admin\JobGroup;
use App\Models\Dwf\DocClass;
use App\Models\Ecf\BizProfile;
use App\Models\Ecf\BizType;
use App\Models\Ecf\FundingType;
use App\Models\Ecf\MarketingFunnels;
use App\Models\Ecf\GetToKnowInvestar;
use App\Models\Ecf\CurrentJob;
use App\Models\Ecf\InvestmentGoal;
use App\Models\Ecf\InvestorType;
use App\Models\Ecf\MonthlyIncome;
use App\Models\Ecf\RelativeRelation;
use App\Models\Ecf\IncomeSource;
use App\Models\Ecf\LastEducation;
use App\Models\Ecf\MaritalStatus;
use App\Models\Ecf\HeirRelation;
use App\Models\Ecf\InvestmentBudget;
use App\Models\Ecf\Bank;
use App\Models\Ecf\NoOfBranches;
use App\Models\Ecf\Risk;
use App\Models\Ecf\PositionInCompany;
use App\Models\Ecf\InvestmentPreference;
use App\Models\Ecf\Citizenship;
use App\Models\Fms\Admin\Breed;
use App\Models\Fms\CattleProfile;
use App\Models\Fms\Farm;
use App\Models\Mms\NotificationTemplate;
use App\Models\Obj\PrintTemplate;
use App\Models\Reference\Area;
use App\Models\Reference\JobTitle;
use App\Models\Reference\ProductCategory;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Core\Mongo\Sequence;
use App\Models\Reference\Uom;
use App\Models\Reflow\Cycle;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Directory\VendorDirectory;
use App\Notifications\OfficerNotification;
use Carbon\Carbon;
use Flynsarmy\DbBladeCompiler\Facades\DbView;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use MongoDB\BSON\ObjectId;
use MongoId;
use WeasyPrint\WeasyPrint;


class EcfUtil {

    protected $recipients = [];

    protected $watpl = [];

    public static function getCitizenship()
    {
        $citizenship = Citizenship::orderBy('seq', 'asc')->get();
        return $citizenship->toArray();
    }

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


    public static function roleRedirect($role = null){
        if( is_null($role)){
            return '/';
        }

        if($role->slug == 'penerbit'){
            return 'ecf/profile/penerbit/step/1';
        }

        if($role->slug == 'pemodal'){
            return 'ecf/profile/pemodal/step/1';
        }

    }
    public static function getUnits()
    {
        $units = Uom::orderBy('uom','asc')->get();
        return $units->toArray();
    }

    public static function getBizProfile()
    {
        if(AuthUtil::isAdmin()){
            $profiles = BizProfile::orderBy('ownerId')->get();
        }else{
            $profiles = BizProfile::where('ownerId', '=', Auth::user()->_id )->orderBy('ownerId')->get();
        }
        return $profiles->toArray();
    }

    public static function getCategories()
    {
        $categories = ProductCategory::orderBy('category', 'asc')->get();
        return $categories->toArray();
    }

    public static function getBizType()
    {
        $type = BizType::orderBy('seq', 'asc')->get();
        return $type->toArray();
    }

    public static function getFundingType()
    {
        $fundingType = FundingType::orderBy('seq', 'asc')->get();
        return $fundingType->toArray();
    }

    public static function getMarketingFunnels()
    {
        $marketingFunnels = MarketingFunnels::orderBy('seq', 'asc')->get();
        return $marketingFunnels->toArray();
    }

    public static function getKnowInvestar()
    {
        $knowInvestar = GetToKnowInvestar::orderBy('seq', 'asc')->get();
        return $knowInvestar->toArray();
    }

    public static function getCurrentJob()
    {
        $currentJob = CurrentJob::orderBy('seq', 'asc')->get();
        return $currentJob->toArray();
    }
    
    public static function getInvestorType()
    {
        $investorType = InvestorType::orderBy('seq', 'asc')->get();
        return $investorType->toArray();
    }

    public static function getMonthlyIncome()
    {
        $monthlyIncome = MonthlyIncome::orderBy('seq', 'asc')->get();
        return $monthlyIncome->toArray();
    }

    public static function getRelativeRelation()
    {
        $relativeRelation = RelativeRelation::orderBy('seq', 'asc')->get();
        return $relativeRelation->toArray();
    }

    public static function getIncomeSource()
    {
        $incomeSource = IncomeSource::orderBy('seq', 'asc')->get();
        return $incomeSource->toArray();
    }

    public static function getLastEducation()
    {
        $lastEducation = LastEducation::orderBy('seq', 'asc')->get();
        return $lastEducation->toArray();
    }

    public static function getMaritalStatus()
    {
        $maritalStatus = MaritalStatus::orderBy('seq', 'asc')->get();
        return $maritalStatus->toArray();
    }

    public static function getHeirRelation()
    {
        $heirRelation = HeirRelation::orderBy('seq', 'asc')->get();
        return $heirRelation->toArray();
    }

    public static function getInvestmentBudget()
    {
        $investmentBudget = InvestmentBudget::orderBy('seq', 'asc')->get();
        return $investmentBudget->toArray();
    }

    public static function getBank()
    {
        $bank = Bank::orderBy('seq', 'asc')->get();
        return $bank->toArray();
    }

    public static function getNoOfBranches()
    {
        $noOfBranches = NoOfBranches::orderBy('seq', 'asc')->get();
        return $noOfBranches->toArray();
    }

    public static function getRisk()
    {
        $risk = Risk::orderBy('seq', 'asc')->get();
        return $risk->toArray();
    }

    public static function getPositionInCompany()
    {
        $position = PositionInCompany::orderBy('seq', 'asc')->get();
        return $position->toArray();
    }

    public static function getInvestmentPreference()
    {
        $investmentPreference = InvestmentPreference::orderBy('seq', 'asc')->get();
        return $investmentPreference->toArray();
    }

    public static function getInvestmentGoal()
    {
        $investmentGoal = InvestmentGoal::orderBy('seq', 'asc')->get();
        return $investmentGoal->toArray();
    }

    public static function getVendors()
    {
        $categories = VendorDirectory::orderBy('vendorName', 'asc')->get();
        return $categories->toArray();
    }

    public static function getArea()
    {
        $area = Area::orderBy('cityName', 'asc')->get();
        return $area->toArray();
    }

    public static function getDeliveryAddress()
    {
        $area = Area::orderBy('cityName', 'asc')->get();
        return $area->toArray();
    }

    public static function getCartSession()
    {

    }

    public static function addProductToCart($product, $cartSession)
    {

    }

    public static function updateProductQty( $qty, $product, $cartSession)
    {

    }

    public static function removeProductFromCart($productId)
    {

    }

    public static function sendNotification($cattle, $recipients)
    {
        self::notifyUser( $cattle->startWA, $cattle , $recipients );
        self::notifyUser( $cattle->breakWA, $cattle , $recipients );
        self::notifyUser( $cattle->endWA, $cattle , $recipients );
    }



    public static function setupRecipients($farmNo){

        $recipients = [];
        $watpl = [];
        $waList = NotificationTemplate::orderBy('slug','asc')->get();
        foreach ($waList as $wt){
            $rx = User::where( 'notificationSubs.slug', '=', $wt->slug )
                ->where('bizUnit.farmId', '=', $farmNo )
                ->get();
            $recipients[ $wt->slug ] = $rx;
            $watpl[ $wt->slug ] = $wt;
        }

        return [
            'recipients'=>$recipients,
            'watpl' => $watpl
        ];
    }


    public static function notifyUser($wa, $cattle ,$recipients)
    {
        $wt = $recipients['watpl'][ $wa ] ?? false;
        if($wt){
            $recs = $recipients['recipients'][ $wa ] ?? [];
            foreach ($recs as $rec){
                $rec->notify( new OfficerNotification( $cattle, $wt, 'OFFICER' ) );
            }
        }
    }

    public static function cycleByKey( $key = 'cycleName' ){
        // get cycle definitions
        $cycles = Cycle::orderBy('cycleGroup','asc')
            ->orderBy('seq','asc')
            ->get();

        $cycles = $cycles->toArray();

        $cycleByKey = [];
        $groupDuration = [];

        $prevDur['FC'] = 0;
        $prevDur['LAC'] = 0;
        foreach ($cycles as $c){
            $prevDur[ $c['cycleGroup'] ] = $prevDur[ $c['cycleGroup'] ] ?? intval( $c['cyclePeriod'] );
            $c['prevAcc'] = $prevDur[ $c['cycleGroup'] ] ;
            $prevDur[ $c['cycleGroup'] ] += intval( $c['cyclePeriod'] );

            $cycleByKey[ $c[$key] ] = $c;
            $groupDuration[ $c['cycleGroup'] ] = $groupDuration[ $c['cycleGroup'] ] ?? 0;
            $groupDuration[ $c['cycleGroup'] ] += intval( $c['cyclePeriod'] );

        }

        return $cycleByKey;

    }

    public static function getFarmObject($farmId = null)
    {
        if(is_null($farmId)){
            return '';
        }
        $farm = Farm::find($farmId);
        if($farm){
            $frms = [
                '_id' => $farm->_id,
                'masterId' => $farm->masterId,
                'masterName' => $farm->masterName,
                'companyId' => $farm->companyId,
                'companyName' => $farm->companyName,
                'farmId' => $farm->farmId,
                'farmName' => $farm->farmName,
                'province' => $farm->province
            ];
            return $frms;
        }else{
            return [];
        }

    }

    public static function getFarms($masterId = null)
    {

        if(AuthUtil::isRoot()) {
            $farms = Farm::orderBy('farmId', 'asc')
                ->where('isActive', '=', true)
                ->get();
        }

        if ( AuthUtil::is('owner')){
            $farms = Farm::where('masterId', '=', Auth::user()->_id)
                ->where('isActive', '=', true)
                ->get();
        }

        if( !(AuthUtil::is('owner') || AuthUtil::isRoot() ) ){
            if($masterId == '' || is_null($masterId) ){
                return [];
            }
            $farms = Farm::where('masterId', '=', $masterId)
                ->where('isActive', '=', true)
                ->get();
        }
        if($farms){
            $frms = [];
            foreach ($farms as $f){
                $frms[] = [
                    '_id' => $f->_id,
                    'masterId' => $f->masterId,
                    'masterName' => $f->masterName,
                    'companyId' => $f->companyId,
                    'companyName' => $f->companyName,
                    'farmId' => $f->farmId,
                    'farmName' => $f->farmName,
                    'province' => $f->province
                ];
            }
            return $frms;
        }else{
            return [];
        }
    }


    public static function getBreeds()
    {
        $breed = Breed::orderBy('seq','asc')->get();
        return $breed->toArray();
    }

    public static function getOfficers($masterId)
    {
        $users = User::where('masterId', '=', $masterId)
            ->orWhere('_id', '=', $masterId )
            ->get();
        return $users->toArray();
    }

    public static function getCattles($masterId, $farmId = null)
    {
        $cattles = CattleProfile::where('masterId','=',$masterId);
        if(!is_null($farmId)){
            $cattles = $cattles->where('farmId','=', $farmId);
        }
        $cattles = $cattles->get();
        return $cattles->toArray();
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


    public static function getSequence($entity, $padded = true)
    {
        $sequencer = new Sequence();
        $seq = $sequencer->getNewId($entity);

        return ($padded)? str_pad($seq, env('NUM_PAD', 5), '0', STR_PAD_LEFT ) : $seq;

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

        $fd = env('STORAGE_DRIVER') == 's3' ? 's3_' : '';

        $buckets = config('app.'.$fd.'buckets.names');

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
                if(env('MAIL_DEBUG', true)){
                    $toEmail = env('MAIL_TEST_CC');
                    $toName = env('MAIL_TEST_CC_NAME');
                    $cc = [];
                    $bcc = [];
                }
                $data['messageId'] = Str::random();
                Mail::to($toEmail)
                    ->queue(new \App\Mail\GenericEmail( $template, $data, $subject ,$toEmail, $toName, $cc, $bcc, $attachmentBin, $attachmentId ));
            }
        }

    }

}
