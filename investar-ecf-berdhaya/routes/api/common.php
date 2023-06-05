<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.26
 */
use Illuminate\Support\Facades\Route;

Route::prefix('v1/mobile')->middleware(['api'])->group(function (){


    Route::post('/auth/token', 'Api\Core\AuthController@postLoginToken');

    \App\Helpers\Util::makeApiRoute('/auth/register/member', 'Api\Core\MemberController');

    \App\Helpers\Util::makeApiRoute('/auth/register/user', 'Api\Core\UserController');

    Route::get('/my-profile', 'Api\Core\SelfProfileController@getIndex')->middleware('jwt');

    Route::put('/my-profile', 'Api\Core\SelfProfileController@putUpdateProfile')->middleware('jwt');

    Route::put('/my-pass', 'Api\Core\SelfProfileController@putUpdatePass')->middleware('jwt');

    Route::put('/my-pin', 'Api\Core\SelfProfileController@putUpdatePin')->middleware('jwt');

    Route::post('/auth/reset', 'Api\Core\AuthController@postReset');

    Route::post('/auth/login', 'Api\Core\AuthController@postLogin');

    Route::get('/auth/logout', 'Api\Core\AuthController@getLogout');

    Route::post('/auth/logout', 'Api\Core\AuthController@postLogout');

    Route::post('/auth/echo', 'Api\Core\AuthController@postTest')->middleware('jwt');

    Route::post('/upload', 'Api\Core\UploadapiController@postFile');

    Route::post('/upload/del', 'Api\Core\UploadapiController@postDel');

    Route::post('/fcm/token', 'Api\Core\FcmController@postRegister');

    Route::post('/otp', 'Api\Core\AuthController@postOtp');

    Route::post('/otp/verify', 'Api\Core\AuthController@postOtpVerify');

});

Route::prefix('v1/core')->middleware(['api'])->group(function (){

    Route::post('/sequence', 'Api\Core\SequenceController@postSequence');

    Route::get('/geo/code', 'Api\Core\GeoCodeController@getCode');
    Route::get('/geo/reverse', 'Api\Core\GeoCodeController@getRev');

    Route::post('/geo/code', 'Api\Core\GeoCodeController@postCode');
    Route::post('/geo/reverse', 'Api\Core\GeoCodeController@postRev');

    Route::post('/geo/distance', 'Api\Core\GeoCodeController@postDistance');

    Route::post('/schema', 'Api\Core\SchemaController@getSchema');
    Route::get('/schema', 'Api\Core\SchemaController@getSchema');

    Route::get('/print/template', 'Api\Core\SchemaController@getPrintTemplate');
    Route::post('/print/template', 'Api\Core\SchemaController@postPrintTemplate');

    Route::get('/auto/tag', 'Api\Core\AutoController@getTag');
    Route::post('/auto/tag', 'Api\Core\AutoController@postSaveTag');

    Route::get('export/xls/{name}', 'Api\Core\DownloadController@getXls');
    Route::get('export/csv/{name}', 'Api\Core\DownloadController@getCsv');

    Route::post('export/xls/template', 'Api\Core\DownloadController@postXlsTemplate');


    Route::post('import/upload', 'Api\Core\ImportController@postUpload');
    Route::post('import/source', 'Api\Core\ImportController@postSource');
    Route::post('import/load', 'Api\Core\ImportController@postLoadData');

    Route::post('import/upload-multi', 'Api\Core\ImportController@postUploadMultiSheet');
    Route::post('import/source-multi', 'Api\Core\ImportController@postSource');
    Route::post('import/load-multi', 'Api\Core\ImportController@postLoadData');

    Route::post('import/upload-cell', 'Api\Core\ImportController@postUploadImportMultiSheet');
    Route::post('import/source-cell', 'Api\Core\ImportController@postSource');
    Route::post('import/load-cell', 'Api\Core\ImportController@postLoadData');

    Route::get('xrate', 'Api\Core\AutoController@getXrate');
    Route::post('xrate', 'Api\Core\AutoController@getXrate');

    Route::post('form-upload', 'Api\Core\UploadapiController@postFormFile');
    Route::post('upload', 'Api\Core\UploadapiController@postFile');
    Route::post('upload/caption', 'Api\Core\UploadapiController@postCaption');
    Route::post('upload/del', 'Api\Core\UploadapiController@postDel');

    Route::post('approval/default-approver', 'Api\Core\WorkflowController@postDefaultApprover');
    Route::post('approval/request', 'Api\Core\WorkflowController@postRequest');
    Route::post('approval/commit', 'Api\Core\WorkflowController@postCommit');

});

Route::prefix('v1/cms')->middleware(['api'])->group(function (){

    \App\Helpers\Util::makeApiRoute('category', 'Api\Cms\CategoryController');
    \App\Helpers\Util::makeApiRoute('section', 'Api\Cms\SectionController');
    \App\Helpers\Util::makeApiRoute('article', 'Api\Cms\ArticleController');

});

Route::group(['prefix' => 'v1/user','middleware'=>['api'] ], function (){
    \App\Helpers\Util::makeApiRoute('profile', 'Api\Core\UserController');
});
\App\Helpers\Util::makeApiRoute('mms/message-log', 'Api\Mms\MessageLogController');
\App\Helpers\Util::makeApiRoute('mms/message-gateway', 'Api\Mms\MessageGatewayController');
\App\Helpers\Util::makeApiRoute('mms/message-queue', 'Api\Mms\MessageQueueController');
\App\Helpers\Util::makeApiRoute('mms/fcm-register', 'Api\Mms\FcmRegisterController');
\App\Helpers\Util::makeApiRoute('workflow/approval-log', 'Api\Workflow\ApprovalLogController');
\App\Helpers\Util::makeApiRoute('workflow/approval-request', 'Api\Workflow\ApprovalRequestController');
\App\Helpers\Util::makeApiRoute('workflow/org-chart', 'Api\Workflow\OrgChartController');
\App\Helpers\Util::makeApiRoute('assets/digital-asset', 'Api\Assets\DigitalAssetController');
\App\Helpers\Util::makeApiRoute('workflow/time/calendar', 'Api\Workflow\Time\CalendarController');
\App\Helpers\Util::makeApiRoute('workflow/time/tracker', 'Api\Workflow\Time\TimeTrackerController');
\App\Helpers\Util::makeApiRoute('workflow/time/attendance', 'Api\Workflow\Time\AttendanceController');
\App\Helpers\Util::makeApiRoute('workflow/time/task-list', 'Api\Workflow\Time\TaskListController');
\App\Helpers\Util::makeApiRoute('workflow/approver', 'Api\Workflow\ApproverController');
\App\Helpers\Util::makeApiRoute('workflow/approval-log', 'Api\Workflow\ApprovalLogController');
\App\Helpers\Util::makeApiRoute('workflow/approval-request', 'Api\Workflow\ApprovalRequestController');
\App\Helpers\Util::makeApiRoute('workflow/approval-policy', 'Api\Workflow\ApprovalPolicyController');
\App\Helpers\Util::makeApiRoute('workflow/approver', 'Api\Workflow\ApproverController');
\App\Helpers\Util::makeApiRoute('workflow/approval-log', 'Api\Workflow\ApprovalLogController');
\App\Helpers\Util::makeApiRoute('workflow/approval-request', 'Api\Workflow\ApprovalRequestController');
\App\Helpers\Util::makeApiRoute('workflow/approval-policy', 'Api\Workflow\ApprovalPolicyController');
\App\Helpers\Util::makeApiRoute('workflow/file-download', 'Api\Workflow\FileDownloadController');
\App\Helpers\Util::makeApiRoute('workflow/project', 'Api\Workflow\Project\ProjectController');
\App\Helpers\Util::makeApiRoute('workflow/client', 'Api\Workflow\Project\Client\ClientController');
\App\Helpers\Util::makeApiRoute('task-template', 'Api\Reference\TaskTemplate\TaskTemplateController');
\App\Helpers\Util::makeApiRoute('project-type', 'Api\Reference\ProjectType\ProjectTypeController');
\App\Helpers\Util::makeApiRoute('project-model', 'Api\Reference\ProjectModelController');
\App\Helpers\Util::makeApiRoute('task-type', 'Api\Reference\TaskType\TaskTypeController');
\App\Helpers\Util::makeApiRoute('workflow/approval-request', 'Api\Workflow\ApprovalRequestController');
\App\Helpers\Util::makeApiRoute('mms/notification', 'Api\Mms\NotificationController');
\App\Helpers\Util::makeApiRoute('mms/notification-sub', 'Api\Mms\NotificationSubController');
\App\Helpers\Util::makeApiRoute('mms/notification-channel', 'Api\Mms\NotificationSubController');
\App\Helpers\Util::makeApiRoute('mms/notification-channel', 'Api\Mms\NotificationChannelController');
\App\Helpers\Util::makeApiRoute('reference/area-code', 'Api\Reference\AreaCodeController');
\App\Helpers\Util::makeApiRoute('reference/select-options', 'Api\Reference\SelectOptionsController');
\App\Helpers\Util::makeApiRoute('mms/notification-template', 'Api\Mms\NotificationTemplateController');
\App\Helpers\Util::makeApiRoute('reflow/cycle', 'Api\Reflow\CycleController');
\App\Helpers\Util::makeApiRoute('core/console-log', 'Api\Core\ConsoleLogController');
\App\Helpers\Util::makeApiRoute('mms/qontak/send-log', 'Api\Qontak\SendLogController');
\App\Helpers\Util::makeApiRoute('mms/qontak/broadcast-status-log', 'Api\Qontak\BroadcastStatusLogController');
\App\Helpers\Util::makeApiRoute('mms/qontak/wa-template', 'Api\Qontak\WaTemplateController');
\App\Helpers\Util::makeApiRoute('mms/qontak/channel', 'Api\Qontak\ChannelController');
\App\Helpers\Util::makeApiRoute('mms/qontak/category', 'Api\Qontak\CategoryController');
\App\Helpers\Util::makeApiRoute('mms/qontak/category', 'Api\Qontak\FileUploadController');
\App\Helpers\Util::makeApiRoute('mms/qontak/lang', 'Api\Qontak\LangController');
\App\Helpers\Util::makeApiRoute('mms/qontak/file-upload', 'Api\Qontak\FileUploadController');
	\App\Helpers\Util::makeApiRoute('mms/wa-message-log', 'Api\Mms\WaMessageLogController');
