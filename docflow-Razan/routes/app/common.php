<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/11/19
 * Time: 22.32
 */

use App\Models\Core\PrintCache;
use App\Models\Dwf\Document;
use App\Models\Mms\Notification;
use App\Models\Obj\PrintTemplate;
use Flynsarmy\DbBladeCompiler\Facades\DbView;
use Milon\Barcode\DNS1D;
use Milon\Barcode\DNS2D;
use NumberToWords\NumberToWords;

\App\Helpers\Util::makeRoute('user', 'Core\UserController');
\App\Helpers\Util::makeRoute('api-user', 'Core\ApiUserController');
\App\Helpers\Util::makeRoute('member', 'Core\MemberController');

\App\Helpers\Util::makeRoute('role', 'Core\RoleController');

\App\Helpers\Util::makeRoute('fcm-register', 'Core\FcmRegisterController');
\App\Helpers\Util::makeRoute('api-log', 'Core\ApiLogController');
\App\Helpers\Util::makeRoute('action-log', 'Core\ActionLogController');
\App\Helpers\Util::makeRoute('approval-log', 'Core\ApprovalLogController');
\App\Helpers\Util::makeRoute('change-status-log', 'Core\ChangeStatusLogController');

Route::post('/profile-edit/change-password', 'Core\UserController@changePassword');
Route::post('/profile-edit/change-pin', 'Core\UserController@changePin');

Route::post('/auth/check-pin', 'Core\UserController@checkPin');

Route::get('send_email', function(){
    Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
    {
        $message->to('andy.awidarto@gmail.com');
    });
});

Route::post('time/log', 'Workflow\Time\TimeTrackerController@postTimeLog');
Route::post('time/log-state', 'Workflow\Time\TimeTrackerController@postTimeLogState');

Route::get('profile/{id?}', 'Core\UserController@getProfile');
Route::get('profile-edit/{id?}', 'Core\UserController@editProfile');
Route::get('setting/{id?}', 'Core\UserController@getSetting');

Route::get('user/auto-user', 'Core\UserController@getAutoUser');
Route::post('user/auto-user', 'Core\UserController@getAutoUser');
//Route::get('inbox/{id?}', 'Core\UserController@getProfile');

// print & pdf gen routes
Route::get('print/{templateslug}/{id}', 'Core\PrintController@getPrint');
Route::get('pdf/{templateslug}/{id}', 'Core\PrintController@getPdf');
Route::get('page-header/{templateslug}/{id}', 'Core\PrintController@getPageHeader');

//API token utility
Route::post('api-user/token', 'Core\ApiUserController@postGenerateToken');


/**
 * @hideFromAPIDocumentation
 * PHP info checker
 */
Route::get('info',function(){
    phpinfo();
});

Route::group([ 'prefix'=>'reference', 'middlewareGroup'=>['web'] ], function(){
    \App\Helpers\Util::makeRoute('location', 'Reference\LocationController');
    \App\Helpers\Util::makeRoute('occupation', 'Reference\OccupationController');
    \App\Helpers\Util::makeRoute('religion', 'Reference\ReligionController');
    \App\Helpers\Util::makeRoute('zipcode', 'Reference\ZipcodeController');
    \App\Helpers\Util::makeRoute('area', 'Reference\AreaController');
    \App\Helpers\Util::makeRoute('jobstatus', 'Reference\JobStatusController');
    \App\Helpers\Util::makeRoute('incoterm', 'Reference\IncotermController');
    \App\Helpers\Util::makeRoute('country', 'Reference\CountryController');
    \App\Helpers\Util::makeRoute('company', 'Reference\CompanyController');
    \App\Helpers\Util::makeRoute('company-type', 'Reference\CompanyTypeController');
    \App\Helpers\Util::makeRoute('biz-unit', 'Reference\BizUnitController');
    \App\Helpers\Util::makeRoute('biz-unit-type', 'Reference\BizUnitTypeController');
    \App\Helpers\Util::makeRoute('job-title', 'Reference\JobTitleController');
    \App\Helpers\Util::makeRoute('store', 'Reference\StoreController');
    \App\Helpers\Util::makeRoute('uom', 'Reference\UomController');
    \App\Helpers\Util::makeRoute('payment-type', 'Reference\PaymentTypeController');
    \App\Helpers\Util::makeRoute('payment-category', 'Reference\PaymentCategoryController');
    \App\Helpers\Util::makeRoute('product-list', 'Reference\ProductController');
    \App\Helpers\Util::makeRoute('product-category', 'Reference\ProductCategoryController');
    \App\Helpers\Util::makeRoute('channel', 'Reference\ChannelController');
    \App\Helpers\Util::makeRoute('product-brand', 'Reference\ProductBrandController');
    \App\Helpers\Util::makeRoute('currency', 'Reference\CurrencyController');
    \App\Helpers\Util::makeRoute('exchange-rate', 'Reference\ExchangeRateController');
    \App\Helpers\Util::makeRoute('task-template', 'Reference\TaskTemplateController');
    \App\Helpers\Util::makeRoute('project-type', 'Reference\ProjectTypeController');
	\App\Helpers\Util::makeRoute('task-type', 'Reference\TaskTypeController');
    \App\Helpers\Util::makeRoute('cost-center', 'Reference\CostCenterController');


    Route::post('/city', 'Member\MemberController@getCity');
    Route::get('/kecamatan/{id}', 'Member\MemberController@getKecamatan');
    Route::get('/kelurahan/{id}', 'Member\MemberController@getKelurahan');
    Route::post('/vendor/seq', 'Sms\Directory\VendorDirectoryController@postGetSeq');
    Route::post('/jobregister/seq', 'Sms\SalesOperation\JobRegisterController@postGetSeq');
});

/**
 * Workflow
 * */
Route::group([ 'prefix'=>'workflow', 'middlewareGroup'=>['web'] ], function(){

    Route::get('/dashboard', 'Workflow\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Workflow\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Workflow\Admin\DashboardController@getData');

    \App\Helpers\Util::makeRoute('org-chart', 'Workflow\OrgChartController');

    Route::group([ 'prefix'=>'approval', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('approval-request', 'Workflow\Approval\ApprovalRequestController');
        \App\Helpers\Util::makeRoute('approval-log', 'Workflow\Approval\ApprovalLogController');
        \App\Helpers\Util::makeRoute('approver', 'Workflow\Approval\ApproverController');
        \App\Helpers\Util::makeRoute('default-approver', 'Workflow\Approval\DefaultApproverController');
    });

    Route::group([ 'prefix'=>'reference', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('task-template', 'Workflow\Reference\TaskTemplateController');
        \App\Helpers\Util::makeRoute('project-type', 'Workflow\Reference\ProjectTypeController');
        \App\Helpers\Util::makeRoute('project-model', 'Workflow\Reference\ProjectModelController');
        \App\Helpers\Util::makeRoute('task-type', 'Workflow\Reference\TaskTypeController');
    });
});

/**
 * Object
 */
\App\Helpers\Util::makeRoute('page', 'Obj\PageController');

/**
 * Authoring Tool Routes
 */

Route::group([ 'prefix'=>'obj', 'middlewareGroup'=>['web'] ], function(){

    \App\Helpers\Util::makeRoute('component', 'Obj\ComponentController');
    Route::get('component/dev', 'Obj\ComponentController@getDev');

    \App\Helpers\Util::makeRoute('form', 'Obj\FormController');
    \App\Helpers\Util::makeRoute('menu', 'Obj\MenuController');
    \App\Helpers\Util::makeRoute('page', 'Obj\PageController');
    \App\Helpers\Util::makeRoute('acl-object', 'Obj\AclObjectController');
    \App\Helpers\Util::makeRoute('form-template', 'Obj\FormTemplateController');
    \App\Helpers\Util::makeRoute('json-template', 'Obj\JsonTemplateController');
    \App\Helpers\Util::makeRoute('view-template', 'Obj\ViewTemplateController');
    \App\Helpers\Util::makeRoute('form-template', 'Obj\FormTemplateController');
    \App\Helpers\Util::makeRoute('json-template', 'Obj\JsonTemplateController');

    \App\Helpers\Util::makeRoute('email-template', 'Obj\EmailTemplateController');
    \App\Helpers\Util::makeRoute('print-template', 'Obj\PrintTemplateController');

    Route::get('git-log', '\EmtiazZahid\GitLogLaravel\GitLogLaravelController@index');
});

Route::group([ 'prefix'=>'cms', 'middlewareGroup'=>['web'] ], function(){

    \App\Helpers\Util::makeRoute('article', 'Cms\ArticleController');
    \App\Helpers\Util::makeRoute('category', 'Cms\CategoryController');
    \App\Helpers\Util::makeRoute('group', 'Cms\GroupController');
    \App\Helpers\Util::makeRoute('section', 'Cms\SectionController');

});

if( env('WITH_PMC') ){

    include('pmc.php');

}

if( env('WITH_BIZ_ADMIN') ){

    include('sms.php');

}

Route::group([ 'prefix'=>'dcs', 'middlewareGroup'=>['web'] ], function(){

    Route::post('scoring/form/form-def', 'Dcs\Scoring\FormController@postFormDef');
    Route::post('scoring/form/form-save', 'Dcs\Scoring\FormController@postFormSave');
    Route::get('form/page/{id}', 'Dcs\Scoring\FormController@getFormPage');

    \App\Helpers\Util::makeRoute('scoring/form', 'Dcs\Scoring\FormController');
    \App\Helpers\Util::makeRoute('scoring/question', 'Dcs\Scoring\QuestionController');
    \App\Helpers\Util::makeRoute('scoring/point', 'Dcs\Scoring\PointController');

    \App\Helpers\Util::makeRoute('admin/category', 'Dcs\Admin\CategoryController');
    \App\Helpers\Util::makeRoute('admin/group', 'Dcs\Admin\GroupController');
    \App\Helpers\Util::makeRoute('admin/section', 'Dcs\Admin\SectionController');
});

/**
 * MMS Multimode Messaging System
 */
Route::group([ 'prefix'=>'mms', 'middlewareGroup'=>['web'] ], function(){

    \App\Helpers\Util::makeRoute('message-queue', 'Mms\MessageQueueController');
    \App\Helpers\Util::makeRoute('message-log', 'Mms\MessageLogController');
    \App\Helpers\Util::makeRoute('message-gateway', 'Mms\MessageGatewayController');
    \App\Helpers\Util::makeRoute('fcm-register', 'Mms\FcmRegisterController');

    Route::post('/notif/list', 'Api\Core\NotificationController@postList');
    Route::post('/notif/clear', 'Api\Core\NotificationController@postClear');

});


/* DMS Routes */
Route::group([ 'prefix'=>'dms', 'middlewareGroup'=>['web'] ], function(){

    \App\Helpers\Util::makeRoute('repository', 'Dms\RepositoryController');
    \App\Helpers\Util::makeRoute('dispatch', 'Dms\DispatchController');
    \App\Helpers\Util::makeRoute('disposal', 'Dms\DisposalController');
    \App\Helpers\Util::makeRoute('borrow', 'Dms\BorrowController');

    Route::post('/dispatch/setbox', 'Dms\DispatchController@postSetBox');
    Route::post('/disposal/dispose', 'Dms\DispatchController@postDispose');

    Route::get('/scanin', 'Dms\RepositoryController@getScan');
    Route::post('/scan-in', 'Dms\RepositoryController@postScan');

    Route::post('/repository/scanlink', 'Dms\RepositoryController@postScanLink');
    Route::post('/repo/seq', 'Dms\RepositoryController@postGetSeq');

    Route::group([ 'prefix'=>'admin', 'middlewareGroup'=>['web'] ], function(){

        Route::get('/dashboard', 'Dms\Admin\DashboardController@getIndex');

        \App\Helpers\Util::makeRoute('callcode', 'Dms\Admin\CallCodeController');
        \App\Helpers\Util::makeRoute('coycode', 'Dms\Admin\CoyCodeController');
        \App\Helpers\Util::makeRoute('docclass', 'Dms\Admin\DocClassController');
        \App\Helpers\Util::makeRoute('docfunction', 'Dms\Admin\DocFunctionController');
        \App\Helpers\Util::makeRoute('disposal', 'Dms\Admin\DisposalController');
        \App\Helpers\Util::makeRoute('doctype', 'Dms\Admin\DocTypeController');
        \App\Helpers\Util::makeRoute('sequence', 'Dms\Admin\SequenceController');
        \App\Helpers\Util::makeRoute('box', 'Dms\Admin\BoxController');
    });

});

Route::group([ 'prefix'=>'test', 'middlewareGroup'=>['web'] ], function(){
    Route::get('max/{year}/{formTemplate?}/{jobCode?}/{kc?}', function(Request $request, $year, $formTemplate = null, $jobCode = null, $kc = null){

        $formTemplate = $formTemplate ??'surat-dinas';
        $jobCode = $jobCode ?? 'DUZ';
        $kc = $kc ?? 'AKP000';

        $max = Document::where('docYear','=',$year)
            ->where("formTemplate", '=', $formTemplate  )
            ->where("titleCode.jobCode", '=', $jobCode )
            ->where("footer.bizUnitCode", '=', $kc )
            ->max('docSeq');
        $max++;
        print $year."\r\n";
        print $formTemplate."\r\n";
        print $jobCode."\r\n";
        print $max."\r\n";
        $max = str_pad( $max , 4, "0", STR_PAD_LEFT);
        print $max;


    });
});

Route::get( 'verify/{id}', function($id){
    $doc = \App\Models\Dwf\Document::find($id);

    if($doc){
        return view( 'dwf.document.verify' )
            ->with('doc', $doc->toArray());
    }else{
        return response()->json([ ], 404);
    }

});


Route::group([ 'prefix'=>'gen', 'middlewareGroup'=>['web'] ], function(){

    Route::get('notif',function(){

        $users = \App\Models\Core\Mongo\User::skip(0)->take(2)->get();
        $document = null;
        //print_r($users->toArray());
        $req = 'RECEIVE';
        \App\Helpers\App\MmsUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);
        $req = 'DRAFT';
        \App\Helpers\App\MmsUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);
        $req = 'CC';
        \App\Helpers\App\MmsUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);

    });
    /**
     * QR Code generator
     * @urlParam enc string required Data encoding , may be "p" for plain string or "b" for base64 encoded dat
     * @urlParam data string required Actual data to be encoded into QR code
     */

    Route::get('task-seq', function(\Illuminate\Http\Request $request){
        $tasks = \App\Models\Central\Project\Task::orderBy('createdAt', 'asc')->get();

        $seq = 1;
        foreach ($tasks as $task){
            $seqpad = str_pad($seq, 7, '0', STR_PAD_LEFT);
            $taskCode = 'TSK-'.$seqpad;
            $task->seq = intval($seq);
            $task->taskCode = $taskCode;

            print $task->taskCode;
            print_r($task->toArray());
            $task->save();
            $seq++;
        }


    });

    Route::get('qr/{enc}/{data}', function(\Illuminate\Http\Request $request, $enc ,$data){
        $qrd = new DNS2D();
        $data = ( $enc == 'b' )? base64_decode($data):$data;

        $qr = $qrd->getBarcodeSVG($data, 'QRCODE');
        return response($qr, 200)
            ->header('Content-Type', 'image/svg+xml');
    });

    Route::get('qrcode/{enc}/{data}', function(\Illuminate\Http\Request $request, $enc ,$data){
        $data = ( $enc == 'b' )? base64_decode($data):$data;
        $qrd = new SimpleSoftwareIO\QrCode\Generator();
        $qr = $qrd->format('svg')->size(175)->color(128, 0, 100 )
            ->style('round' )
            ->generate($data);
        return response($qr, 200)
            ->header('Content-Type', 'image/svg+xml');
    });

    Route::get('bar/{enc}/{data}', function(\Illuminate\Http\Request $request, $enc ,$data){
        $bard = new DNS1D();
        $data = ( $enc == 'b' )? base64_decode($data):$data;
        $bar = $bard->getBarcodeSVG($data, 'C128', 3, 100, 'black');
        return response($bar, 200)
            ->header('Content-Type', 'image/svg+xml');
    });


    Route::get('tw', function(\Illuminate\Http\Request $request){
        $n2w = new NumberToWords();
        $numberTransformer = $n2w->getNumberTransformer('en');
        return $numberTransformer->toWords(57657);
    });

    Route::get('acl-activate', function(\Illuminate\Http\Request $request){
        $acls = \App\Models\Obj\AclObject::all();
        foreach ($acls as $acl){
            $acl->isActive = true;
            $acl->save();
        }
    });

    Route::get('fpdf/{data}', function($data){
        $source = public_path('doc/testdoc.pdf');
        $output = public_path('doc/testdoc_out.pdf');

        $qrd = new SimpleSoftwareIO\QrCode\Generator();
        $qr = $qrd->format('png')
            ->size(220)->color(0, 0, 0 )
            ->errorCorrection('H')
            ->style('round' )
            ->backgroundColor(255, 255, 255)
            ->margin(2)
            ->generate($data);

        file_put_contents( public_path('qr/'.$data.'.png'), $qr );

        $image = public_path('qr/'.$data.'.png');

        $pdf = new setasign\Fpdi\Fpdi();
        $pageCount = $pdf->setSourceFile($source);
        for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);

            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            if($pageNo == 1){
                $width = $pdf->GetPageWidth();
                $pdf->Image($image,($width - 75),5,15,15); // X start, Y start, X width, Y width in mm
                $pdf->SetFont('Helvetica','',10); // Font Name, Font Style (eg. 'B' for Bold), Font Size
                $pdf->SetTextColor(0,0,0); // RGB
                $pdf->Text($width - 55,10,$data);
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetXY(15, 5);
            $pdf->Write(8, 'Cedar DMS - Document Management System');
        }

//        $width = $pdf->GetPageWidth();
//        $pdf->Image($image,($width - 70),5,10,10); // X start, Y start, X width, Y width in mm
//        $pdf->SetFont('Helvetica','',10); // Font Name, Font Style (eg. 'B' for Bold), Font Size
//        $pdf->SetTextColor(0,0,0); // RGB
//        $pdf->Text($width - 55,10,$data); // X start, Y start, X width, Y width in mm

//        $pdf->SetXY(($width - 60), 10); // X start, Y start in mm
//        $pdf->Write(0, $data);

        $pdf->Output($output, "F");
    });


    Route::get('embedqr', function(){
        $source = public_path('doc/testdoc.pdf');
        $output = public_path('doc/testdoc_out.pdf');
        $qr_string = 'F-BT-02-01-07000000-0217-01';
        \App\Jobs\EmbedQRJob::dispatch($qr_string, $source, $output );
    });

    Route::get('docx', function(){
        $source = public_path('doc/testdoc.docx');
        $output = public_path('doc/testdoc_out.docx');
        $outputPdf = public_path('doc/testdoc_out_word.pdf');

        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        // Adding an empty Section to the document...
        $section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
        $section->addText(
            '"Learn from yesterday, live for today, hope for tomorrow. '
            . 'The important thing is not to stop questioning." '
            . '(Albert Einstein)',
            array('name' => 'Tahoma', 'size' => 14, 'bold'=>true)
        );

        /*
         * Note: it's possible to customize font style of the Text element you add in three ways:
         * - inline;
         * - using named font style (new font style object will be implicitly created);
         * - using explicitly created font style object.
         */

// Adding Text element with font customized inline...
        $section->addText(
            '"Great achievement is usually born of great sacrifice, '
            . 'and is never the result of selfishness." '
            . '(Napoleon Hill)',
            array('name' => 'Calibri', 'size' => 12)
        );

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        $objWriter->save($output);

        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'PDF');
        $objWriter->save($outputPdf);

    });

    Route::get('qmail', function(){
        //\Illuminate\Support\Facades\Mail::to('andy.awidarto@gmail.com')->send(new \App\Mail\GenericEmail());
        \Illuminate\Support\Facades\Mail::to('andy.awidarto@gmail.com')
            ->queue(new \App\Mail\GenericEmail());
    });

    Route::get('test-event', function(){
       broadcast( new \App\Events\ExportDone() );
    });

});

Route::group([ 'prefix'=>'conv', 'middlewareGroup'=>['web'] ], function(){

    Route::get('dms2dec', function(\Illuminate\Http\Request $request){
        $fas = \App\Models\Silani\MasterData\Fasilitas::all();
        foreach ($fas as $f){
            $gstr1 = $f->lk01_ax.''.$f->lk01_a1.' '.$f->lk01_a2;
            $gstr2 = $f->lk01_bx.''.$f->lk01_b1.' '.$f->lk01_b2;
            $g1 = \App\Helpers\GeoUtil::convertDMSToDecimal($gstr1);
            $g2 = \App\Helpers\GeoUtil::convertDMSToDecimal($gstr2);

            $f->lng = doubleval($g2);
            $f->lat = doubleval($g1);
            $f->lngLat = [doubleval($g2), doubleval($g1)];
            $f->latLng = [doubleval($g1), doubleval($g2)];

            $f->location = [
                'type'=>'Point',
                'coordinates'=>[doubleval($g2), doubleval($g1)]
            ];

            $f->save();

            print $g1.','.$g2."\r\n";
        }
    });
});

Route::post('workflow/time/task-list/quickadd', 'Workflow\Time\TaskListController@postQuickAdd');
Route::post('workflow/time/task-list/changestat', 'Workflow\Time\TaskListController@changeStat');


\App\Helpers\Util::makeRoute('assets/digital-asset', 'Assets\DigitalAssetController');
\App\Helpers\Util::makeRoute('mms/message-log', 'Mms\MessageLogController');
\App\Helpers\Util::makeRoute('mms/message-gateway', 'Mms\MessageGatewayController');
\App\Helpers\Util::makeRoute('mms/message-queue', 'Mms\MessageQueueController');
\App\Helpers\Util::makeRoute('mms/fcm-register', 'Mms\FcmRegisterController');
\App\Helpers\Util::makeRoute('workflow/approver', 'Workflow\Approval\ApproverController');
\App\Helpers\Util::makeRoute('workflow/org-chart', 'Workflow\OrgChartController');
\App\Helpers\Util::makeRoute('workflow/time/calendar', 'Central\Project\TaskListController');
\App\Helpers\Util::makeRoute('workflow/time/attendance', 'Workflow\Time\AttendanceController');
\App\Helpers\Util::makeRoute('workflow/time/task-list', 'Workflow\Time\TaskListController');
\App\Helpers\Util::makeRoute('workflow/time/tracker', 'Workflow\Time\TimeTrackerController');
\App\Helpers\Util::makeRoute('workflow/utility/file-download', 'Workflow\Utility\FileDownloadController');
\App\Helpers\Util::makeRoute('mms/notification', 'Mms\NotificationController');
\App\Helpers\Util::makeRoute('mms/notification-sub', 'Mms\NotificationSubController');
\App\Helpers\Util::makeRoute('mms/notification-channel', 'Mms\NotificationSubController');
\App\Helpers\Util::makeRoute('mms/notification-channel', 'Mms\NotificationChannelController');
\App\Helpers\Util::makeRoute('reference/area-code', 'Reference\AreaCodeController');
