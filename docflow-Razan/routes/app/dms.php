<?php

use App\Models\Mms\Notification;
use Illuminate\Support\Facades\Auth;

Route::group([ 'prefix'=>'dms', 'middlewareGroup'=>['web'] ], function(){

    Route::get('/dashboard', 'Dms\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Dms\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Dms\Admin\DashboardController@getData');

    \App\Helpers\Util::makeRoute('repository', 'Dms\RepositoryController');
    \App\Helpers\Util::makeRoute('dispatch', 'Dms\DispatchController');
    \App\Helpers\Util::makeRoute('disposal', 'Dms\DisposalController');
    \App\Helpers\Util::makeRoute('borrow', 'Dms\BorrowController');

    Route::post('/dispatch/setbox', 'Dms\DispatchController@postSetBox');
    Route::post('/disposal/dispose', 'Dms\DispatchController@postDispose');

    Route::get('/scanin', 'Dms\RepositoryController@getScan');
    Route::post('/scan-in', 'Dms\RepositoryController@postScan');

    Route::post('/repository/scanlink', 'Dms\RepositoryController@postScanLink');
    Route::post('/repo/get-seq', 'Dms\RepositoryController@postGetSeq');

    Route::group([ 'prefix'=>'admin', 'middlewareGroup'=>['web'] ], function(){

        Route::get('/dashboard', 'Dms\Admin\DashboardController@getIndex');

        \App\Helpers\Util::makeRoute('callcode', 'Dms\Admin\CallCodeController');
        \App\Helpers\Util::makeRoute('coycode', 'Dms\Admin\CoyCodeController');
        \App\Helpers\Util::makeRoute('docclass', 'Dms\Admin\DocClassController');
        \App\Helpers\Util::makeRoute('docfunction', 'Dms\Admin\DocFunctionController');
        \App\Helpers\Util::makeRoute('disposal', 'Dms\Admin\DisposalController');
        \App\Helpers\Util::makeRoute('doctype', 'Dms\Admin\DocTypeController');
        \App\Helpers\Util::makeRoute('repo', 'Dms\Admin\RepoController');
        \App\Helpers\Util::makeRoute('sequence', 'Dms\Admin\SequenceController');
        \App\Helpers\Util::makeRoute('box', 'Dms\Admin\BoxController');

    });

    Route::get('fix-topic',function(){
        $docs = \App\Models\Dms\Doc::where('TopicDescr','=','')
            ->orWhere('TopicDescr','exists',false)
            ->orWhereNull('TopicDescr')
            ->orWhere('Class','=','')
            ->orWhere('Class','exists',false)
            ->orWhereNull('Class')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){
                $doc->TopicDescr = $topic['TopicDescr'];
                $doc->Class = $topic['DocClass'];
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

    Route::get('fix-disp',function(){
        $docs = \App\Models\Dms\Doc::where('DispPer','=','')
            ->orWhere('DispPer','exists',false)
            ->orWhereNull('DispPer')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){

                $doc->DispPer = intval($topic['DispPer']);
                $doc->DispDate = \Carbon\Carbon::create($doc->DocDate)->addYears( $doc->DispPer )->toDateTimeString();
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

    Route::get('fix-ret',function(){
        $docs = \App\Models\Dms\Doc::where('RetDate','=','')
            ->orWhere('RetDate','exists',false)
            ->orWhereNull('RetDate')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){

                $doc->RetPer = intval($topic['ActiveYrs']);
                $doc->RetDate = \Carbon\Carbon::create($doc->DocDate)->addYears( $doc->RetPer )->toDateTimeString();
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

});

Route::group([ 'prefix'=>'dwf', 'middlewareGroup'=>['web'] ], function(){

    Route::get('/dashboard', 'Dwf\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Dwf\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Dwf\Admin\DashboardController@getData');

    Route::get('/dashboard/transaksi', 'Dwf\Admin\DashboardController@getTransaksi');
    Route::post('/document/history', 'Dwf\DocumentController@getHistory');
    Route::post('/document/archive', 'Dwf\DocumentController@postArchiveDoc');
    Route::post('/document/send', 'Dwf\DocumentController@postSendDoc');
    Route::post('/document/receive', 'Dwf\DocumentController@postReceiveDoc');


    \App\Helpers\Util::makeRoute('document', 'Dwf\DocumentController');

    \App\Helpers\Util::makeRoute('repository', 'Dwf\RepositoryController');
    \App\Helpers\Util::makeRoute('archive', 'Dwf\DocCatalogueController');
    \App\Helpers\Util::makeRoute('video-library', 'Dwf\MediaLibraryController');
    \App\Helpers\Util::makeRoute('borrow', 'Dwf\BorrowController');

    Route::post('/dispatch/setbox', 'Dwf\DispatchController@postSetBox');
    Route::post('/disposal/dispose', 'Dwf\DispatchController@postDispose');

    Route::get('/scanin', 'Dwf\RepositoryController@getScan');
    Route::post('/scan-in', 'Dwf\RepositoryController@postScan');

    Route::post('/repository/scanlink', 'Dwf\RepositoryController@postScanLink');
    Route::post('/repo/get-seq', 'Dwf\RepositoryController@postGetSeq');

    Route::group([ 'prefix'=>'admin', 'middlewareGroup'=>['web'] ], function(){

        Route::get('/dashboard', 'Dwf\Admin\DashboardController@getIndex');

        \App\Helpers\Util::makeRoute('archive-type', 'Dwf\ArchiveTypeController');
        \App\Helpers\Util::makeRoute('group-alias', 'Dwf\GroupAliasController');
        \App\Helpers\Util::makeRoute('job-group', 'Dwf\JobGroupController');
        \App\Helpers\Util::makeRoute('disposition-item', 'Dwf\DispositionItemController');

        \App\Helpers\Util::makeRoute('callcode', 'Dwf\Admin\CallCodeController');
        \App\Helpers\Util::makeRoute('coycode', 'Dwf\Admin\CoyCodeController');
        \App\Helpers\Util::makeRoute('docclass', 'Dwf\Admin\DocClassController');
        \App\Helpers\Util::makeRoute('docfunction', 'Dwf\Admin\DocFunctionController');
        \App\Helpers\Util::makeRoute('disposal', 'Dwf\Admin\DisposalController');
        \App\Helpers\Util::makeRoute('doctype', 'Dwf\Admin\DocTypeController');
        \App\Helpers\Util::makeRoute('repo', 'Dwf\Admin\RepoController');
        \App\Helpers\Util::makeRoute('sequence', 'Dwf\Admin\SequenceController');
        \App\Helpers\Util::makeRoute('box', 'Dwf\Admin\BoxController');

        \App\Helpers\Util::makeRoute('doc-template', 'Dwf\Admin\DocTemplateController');
        \App\Helpers\Util::makeRoute('print-template', 'Dwf\Admin\PrintTemplateController');


    });

    Route::get('notif',function(){

        $users = \App\Models\Core\Mongo\User::skip(0)->take(2)->get();
        $document = \App\Models\Dwf\Document::first();
        //print_r($users->toArray());
        $req = 'RECEIVE';
        \App\Helpers\App\DwfUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);
        $req = 'DRAFT';
        \App\Helpers\App\DwfUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);
        $req = 'CC';
        \App\Helpers\App\DwfUtil::sendNotification($users, \App\Notifications\RecipientNotification::class, $document, $req);

        print_r(Auth::user()->_id);
        $notifications = Notification::where( 'notifiable_id','=', Auth::user()->_id )->orderBy('created_at','desc')->get();
        print_r($notifications);


    });

    Route::get('fix-topic',function(){
        $docs = \App\Models\Dms\Doc::where('TopicDescr','=','')
            ->orWhere('TopicDescr','exists',false)
            ->orWhereNull('TopicDescr')
            ->orWhere('Class','=','')
            ->orWhere('Class','exists',false)
            ->orWhereNull('Class')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){
                $doc->TopicDescr = $topic['TopicDescr'];
                $doc->Class = $topic['DocClass'];
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

    Route::get('fix-disp',function(){
        $docs = \App\Models\Dms\Doc::where('DispPer','=','')
            ->orWhere('DispPer','exists',false)
            ->orWhereNull('DispPer')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){

                $doc->DispPer = intval($topic['DispPer']);
                $doc->DispDate = \Carbon\Carbon::create($doc->DocDate)->addYears( $doc->DispPer )->toDateTimeString();
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

    Route::get('fix-ret',function(){
        $docs = \App\Models\Dms\Doc::where('RetDate','=','')
            ->orWhere('RetDate','exists',false)
            ->orWhereNull('RetDate')
            ->get();

        $cnt = 0;
        foreach ($docs as $doc){
            $topic = \App\Helpers\App\DmsUtil::getTopic($doc->Topic);
            if($topic){

                $doc->RetPer = intval($topic['ActiveYrs']);
                $doc->RetDate = \Carbon\Carbon::create($doc->DocDate)->addYears( $doc->RetPer )->toDateTimeString();
                $doc->save();
                $cnt++;
            }
        }
        return response()->json(['updated'=>$cnt]);
    });

});
	\App\Helpers\Util::makeRoute('dwf/admin/archive-doc-type', 'Dwf\ArchiveDocTypeController');
	\App\Helpers\Util::makeRoute('dwf/admin/archive-location', 'Dwf\Admin\ArchiveLocationController');
	\App\Helpers\Util::makeRoute('dwf/admin/archive-group', 'Dwf\Admin\ArchiveGroupController');
