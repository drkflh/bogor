<?php
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

Route::group([ 'prefix'=>'fms', 'middlewareGroup'=>['web'] ], function(){

    Route::get('/dashboard', 'Fms\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Fms\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Fms\Admin\DashboardController@getData');

    Route::get('/dashboard/transaksi', 'Fms\Admin\DashboardController@getTransaksi');
    Route::post('/document/history', 'Fms\DocumentController@getHistory');
    Route::post('/document/archive', 'Fms\DocumentController@postArchiveDoc');
    Route::post('/document/send', 'Fms\DocumentController@postSendDoc');
    Route::post('/document/receive', 'Fms\DocumentController@postReceiveDoc');

    Route::get('/cattle-profile/add/{keyword0}/{keyword1?}/{keyword2?}', 'Fms\CattleProfileController@getAddProfile');
    Route::get('/cattle-profile/edit/{keyword0}/{keyword1?}/{keyword2?}', 'Fms\CattleProfileController@getEditProfile');

    \App\Helpers\Util::makeRoute('document', 'Fms\DocumentController');

    \App\Helpers\Util::makeRoute('repository', 'Fms\RepositoryController');
    \App\Helpers\Util::makeRoute('archive', 'Fms\DocCatalogueController');
    \App\Helpers\Util::makeRoute('video-library', 'Fms\MediaLibraryController');
    \App\Helpers\Util::makeRoute('borrow', 'Fms\BorrowController');

    Route::post('/dispatch/setbox', 'Fms\DispatchController@postSetBox');
    Route::post('/disposal/dispose', 'Fms\DispatchController@postDispose');

    Route::get('/scanin', 'Fms\RepositoryController@getScan');
    Route::post('/scan-in', 'Fms\RepositoryController@postScan');

    Route::post('/repository/scanlink', 'Fms\RepositoryController@postScanLink');
    Route::post('/repo/get-seq', 'Fms\RepositoryController@postGetSeq');

    \App\Helpers\Util::makeRoute('vendor', 'Fms\Admin\VendorDirectoryController');

    Route::group([ 'prefix'=>'admin', 'middlewareGroup'=>['web'] ], function(){

        Route::get('/dashboard', 'Fms\Admin\DashboardController@getIndex');

        \App\Helpers\Util::makeRoute('doc-template', 'Fms\Admin\DocTemplateController');
        \App\Helpers\Util::makeRoute('print-template', 'Fms\Admin\PrintTemplateController');


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
	\App\Helpers\Util::makeRoute('dwf/admin/archive-type', 'Fms\ArchiveTypeController');
	\App\Helpers\Util::makeRoute('fms/cattle-profile', 'Fms\CattleProfileController');
	\App\Helpers\Util::makeRoute('fms/farm-register', 'Fms\FarmController');
	\App\Helpers\Util::makeRoute('fms/observation', 'Fms\ObservationController');
	\App\Helpers\Util::makeRoute('fms/environment', 'Fms\EnvironmentController');
	\App\Helpers\Util::makeRoute('fms/reproduction', 'Fms\ReproductionController');
	\App\Helpers\Util::makeRoute('fms/insemination', 'Fms\InseminationController');
	\App\Helpers\Util::makeRoute('fms/dairy-production', 'Fms\DairyProductionController');
	\App\Helpers\Util::makeRoute('fms/medical-treatment', 'Fms\MedicalTreatmentController');
	\App\Helpers\Util::makeRoute('fms/med-administered-drug', 'Fms\MedAdministeredDrugController');
	\App\Helpers\Util::makeRoute('fms/semen-inventory', 'Fms\SemenInventoryController');
	\App\Helpers\Util::makeRoute('fms/vaccination', 'Fms\VaccinationController');

Route::group(['prefix' => 'inventory', 'middlewareGroup' => ['web']], function () {
    \App\Helpers\Util::makeRoute('inventory-category', 'Inventory\InventoryCategoryController');
    \App\Helpers\Util::makeRoute('inventory-item', 'Inventory\InventoryItemController');
    \App\Helpers\Util::makeRoute('stock-control', 'Inventory\StockControlController');
});

Route::group(['prefix' => 'directory', 'middlewareGroup' => ['web']], function () {
    Route::post('/vendor/get-seq', 'Sfm\Directory\VendorDirectoryController@postGetSeq');
    Route::post('/customer/get-seq', 'Sfm\Directory\CustomerDirectoryController@postGetSeq');

    \App\Helpers\Util::makeRoute('customer-directory', 'Sfm\Directory\CustomerDirectoryController');
    \App\Helpers\Util::makeRoute('vendor-directory', 'Sfm\Directory\VendorDirectoryController');
    \App\Helpers\Util::makeRoute('vendor-product-list', 'Sfm\Directory\VendorProductController');
});
	\App\Helpers\Util::makeRoute('fms/farm', 'Fms\FarmController');
	\App\Helpers\Util::makeRoute('fms/observation', 'Fms\ObservationController');
	\App\Helpers\Util::makeRoute('fms/environment', 'Fms\EnvironmentController');
	\App\Helpers\Util::makeRoute('fms/reproduction', 'Fms\ReproductionController');
	\App\Helpers\Util::makeRoute('fms/insemination', 'Fms\InseminationController');
	\App\Helpers\Util::makeRoute('fms/dairy-production', 'Fms\DairyProductionController');
	\App\Helpers\Util::makeRoute('fms/medical-treatment', 'Fms\MedicalTreatmentController');
	\App\Helpers\Util::makeRoute('fms/med-administered-drug', 'Fms\MedAdministeredDrugController');
	\App\Helpers\Util::makeRoute('fms/semen-inventory', 'Fms\SemenInventoryController');
	\App\Helpers\Util::makeRoute('fms/vaccination', 'Fms\VaccinationController');
	\App\Helpers\Util::makeRoute('fms/birth', 'Fms\BirthController');
	\App\Helpers\Util::makeRoute('fms/observation', 'Fms\ObservationController');
	\App\Helpers\Util::makeRoute('fms/weight-log', 'Fms\WeightLogController');
	\App\Helpers\Util::makeRoute('fms/food-supply', 'Fms\FoodSupplyController');
	\App\Helpers\Util::makeRoute('fms/admin/breed', 'Fms\Admin\BreedController');
	\App\Helpers\Util::makeRoute('fms/fresh-check', 'Fms\FreshCheckController');
	\App\Helpers\Util::makeRoute('fms/estrus-check', 'Fms\EstrusCheckController');
	\App\Helpers\Util::makeRoute('fms/pregnant-check', 'Fms\PregnantCheckController');
	\App\Helpers\Util::makeRoute('fms/usg-check', 'Fms\UsgCheckController');
