<?php

\App\Helpers\Util::makeRoute('home', 'Ecf\Store\HomeController');
\App\Helpers\Util::makeRoute('catalog', 'Ecf\Store\CampaignCatalogController');
\App\Helpers\Util::makeRoute('promo', 'Ecf\Store\FrontPromoController');


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

Route::post('my-cart', 'Ecf\Store\ShoppingCartController@getActiveCart');
Route::get('check-out', 'Ecf\Store\ShoppingCartController@getShopping');
Route::post('/payment', 'Ecf\Store\PaymentController@paymentConfirmation');
Route::post('/proceed', 'Ecf\Store\PaymentController@proceedConfirmation');
Route::get('/invoice/data/{id}', 'Ecf\Store\PaymentController@getViewForm');
Route::get('/ecf/etalase/detail/{id}', 'Ecf\EtalaseController@getViewForm');
Route::get('/ecf/campaign/edit/{id}', 'Ecf\CampaignController@getEdit');





Route::group([ 'prefix'=>'ecf', 'middlewareGroup'=>['web'] ], function(){

    Route::post('my-cart', 'Ecf\ShoppingCartController@getActiveCart');

    Route::get('/dashboard', 'Ecf\Admin\DashboardController@getDashboard');


    Route::get('/dashboard/data/{id}', 'Ecf\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Ecf\Admin\DashboardController@getData');
    Route::post('/profile/pemodal/get-age', 'Ecf\Profiles\PemodalController@postGetAge');
    Route::get('/profile/pemodal/get-age', 'Ecf\Profiles\PemodalController@postGetAge');
    Route::post('/campaign/get-year', 'Ecf\CampaignController@postYearCalculate');
    Route::get('/campaign/get-year', 'Ecf\CampaignController@postYearCalculate');

    Route::get('/dashboard/transaksi', 'Ecf\Admin\DashboardController@getTransaksi');
    Route::post('/document/history', 'Ecf\DocumentController@getHistory');
    Route::post('/document/archive', 'Ecf\DocumentController@postArchiveDoc');
    Route::post('/document/send', 'Ecf\DocumentController@postSendDoc');
    Route::post('/document/receive', 'Ecf\DocumentController@postReceiveDoc');
    Route::post('/campaign/history', 'Ecf\CampaignController@getHistory');
    Route::post('/transaction/history', 'Ecf\TransactionHistoryController@getHistory');
    Route::post('/campaign/get-seq', 'Ecf\CampaignController@postGetSeq');
    Route::get('/campaign/get-seq', 'Ecf\CampaignController@postGetSeq');
    Route::get('/campaign/declined/{id}', 'Ecf\CampaignController@campaignDeclined');
    Route::post('/campaign/declined/{id}', 'Ecf\CampaignController@campaignDeclined');

    Route::get('/shopping/data', 'Ecf\Store\ShoppingCartController@getData');
    Route::get('/shopping/data/{id}', 'Ecf\Store\ShoppingCartController@getData');
    Route::post('/shopping/data/{id}', 'Ecf\Store\ShoppingCartController@getData');

    Route::get('invoice/data', 'Ecf\Store\PaymentController@getData');
    Route::get('invoice/data/{id}', 'Ecf\Store\PaymentController@getData');
    Route::post('invoice/data/{id}', 'Ecf\Store\PaymentController@getData'); 
    Route::get('invoice/data/{id}/{code}', 'Ecf\Store\PaymentController@getData2');
    Route::post('invoice/data/{id}/{code}', 'Ecf\Store\PaymentController@getData2');
    Route::get('invoice/show/{id}', 'Ecf\Store\PaymentController@showInvoice');

    Route::get('payment/data', 'Ecf\Store\PaymentController@getData2');
    Route::get('payment/data/{id}', 'Ecf\Store\PaymentController@getData2');
    Route::post('payment/data/{id}', 'Ecf\Store\PaymentController@getData2'); 

    \App\Helpers\Util::makeRoute('shopping-cart', 'Ecf\Store\ShoppingCartController');
    \App\Helpers\Util::makeRoute('home', 'Ecf\Store\HomeController');
    \App\Helpers\Util::makeRoute('catalog', 'Ecf\Store\CampaignCatalogController');
    \App\Helpers\Util::makeRoute('promo', 'Ecf\Store\FrontPromoController');

    \App\Helpers\Util::makeRoute('document', 'Ecf\DocumentController');

    Route::get('/company/support-center', 'Ecf\Store\HomeController@getSupportCenter');
    Route::get('/cart', 'Ecf\Store\ShoppingCartController@getShopping');
    Route::get('/cart/clear', 'Ecf\Store\ShoppingCartController@clearShoppingCart');
    Route::get('/cart/clear/item/{id}', 'Ecf\Store\ShoppingCartController@clearItem');
    Route::post('/payment', 'Ecf\Store\PaymentController@paymentConfirmation');
    Route::post('/proceed', 'Ecf\Store\PaymentController@proceedConfirmation');

    \App\Helpers\Util::makeRoute('repository', 'Ecf\RepositoryController');
    \App\Helpers\Util::makeRoute('archive', 'Ecf\DocCatalogueController');
    \App\Helpers\Util::makeRoute('video-library', 'Ecf\MediaLibraryController');
    \App\Helpers\Util::makeRoute('borrow', 'Ecf\BorrowController');

    Route::post('/dispatch/setbox', 'Ecf\DispatchController@postSetBox');
    Route::post('/disposal/dispose', 'Ecf\DispatchController@postDispose');

    Route::get('/scanin', 'Ecf\RepositoryController@getScan');
    Route::post('/scan-in', 'Ecf\RepositoryController@postScan');

    Route::post('/repository/scanlink', 'Ecf\RepositoryController@postScanLink');
    Route::post('/repo/get-seq', 'Ecf\RepositoryController@postGetSeq');

    \App\Helpers\Util::makeRoute('vendor', 'Ecf\Admin\VendorDirectoryController');

    Route::group([ 'prefix'=>'admin', 'middlewareGroup'=>['web'] ], function(){

        Route::get('/dashboard', 'Ecf\Admin\DashboardController@getIndex');

        \App\Helpers\Util::makeRoute('doc-template', 'Ecf\Admin\DocTemplateController');
        \App\Helpers\Util::makeRoute('print-template', 'Ecf\Admin\PrintTemplateController');

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
	\App\Helpers\Util::makeRoute('dwf/admin/archive-type', 'Ecf\ArchiveTypeController');


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

\App\Helpers\Util::makeRoute('ecf/bizprofile', 'Ecf\BizProfileController');
\App\Helpers\Util::makeRoute('ecf/campaign', 'Ecf\CampaignController');
\App\Helpers\Util::makeRoute('ecf/profile/penerbit', 'Ecf\Profiles\PenerbitController');
\App\Helpers\Util::makeRoute('ecf/profile/pemodal', 'Ecf\Profiles\PemodalController');
\App\Helpers\Util::makeRoute('ecf/biztype', 'Ecf\BizTypeController');
\App\Helpers\Util::makeRoute('ecf/fundingtype', 'Ecf\FundingTypeController');
\App\Helpers\Util::makeRoute('ecf/marketingfunnels', 'Ecf\MarketingFunnelsController');
\App\Helpers\Util::makeRoute('ecf/gettoknowinvestar', 'Ecf\GetToKnowInvestarController');
\App\Helpers\Util::makeRoute('ecf/currentjob', 'Ecf\CurrentJobController');
\App\Helpers\Util::makeRoute('ecf/investortype', 'Ecf\InvestorTypeController');
\App\Helpers\Util::makeRoute('ecf/monthlyincome', 'Ecf\MonthlyIncomeController');
\App\Helpers\Util::makeRoute('ecf/relativerelation', 'Ecf\RelativeRelationController');
\App\Helpers\Util::makeRoute('ecf/incomesource', 'Ecf\IncomeSourceController');
\App\Helpers\Util::makeRoute('ecf/lasteducation', 'Ecf\LastEducationController');
\App\Helpers\Util::makeRoute('ecf/maritalstatus', 'Ecf\MaritalStatusController');
\App\Helpers\Util::makeRoute('ecf/citizenship', 'Ecf\CitizenshipController');
\App\Helpers\Util::makeRoute('ecf/heirrelation', 'Ecf\HeirRelationController');
\App\Helpers\Util::makeRoute('ecf/investmentbudget', 'Ecf\InvestmentBudgetController');
\App\Helpers\Util::makeRoute('ecf/bank', 'Ecf\BankController');
\App\Helpers\Util::makeRoute('ecf/noofbranches', 'Ecf\NoOfBranchesController');
\App\Helpers\Util::makeRoute('ecf/risk', 'Ecf\RiskController');
\App\Helpers\Util::makeRoute('ecf/positionincompany', 'Ecf\PositionInCompanyController');
\App\Helpers\Util::makeRoute('ecf/investmentpreference', 'Ecf\InvestmentPreferenceController');
\App\Helpers\Util::makeRoute('ecf/investmentgoal', 'Ecf\InvestmentGoalController');
\App\Helpers\Util::makeRoute('ecf/etalase', 'Ecf\EtalaseController');
\App\Helpers\Util::makeRoute('ecf/shoppingcart', 'Ecf\ShoppingCartController');
\App\Helpers\Util::makeRoute('ecf/inventorypemodal', 'Ecf\PemodalInventoryController');
\App\Helpers\Util::makeRoute('ecf/transactionhistory', 'Ecf\TransactionHistoryController');
Route::get('ecf/buyer/{id}', 'Ecf\BuyerController@getViewForm');
\App\Helpers\Util::makeRoute('ecf/buyer', 'Ecf\BuyerController');
\App\Helpers\Util::makeRoute('ecf/salesorder', 'Ecf\SalesOrderController');
\App\Helpers\Util::makeRoute('ecf/invoice', 'Ecf\InvoiceController');
\App\Helpers\Util::makeRoute('ecf/payment', 'Ecf\PaymentController');
\App\Helpers\Util::makeRoute('ecf/penerbit/verif', 'Ecf\Verification\VerificationPenerbitController');
\App\Helpers\Util::makeRoute('ecf/pemodal/verif', 'Ecf\Verification\VerificationPemodalController');
\App\Helpers\Util::makeRoute('ecf/campaign/verif', 'Ecf\Verification\CampaignVerificationController');
Route::post('ecf/penerbit/verif/history', 'Ecf\Verification\VerificationPenerbitController@getHistory');
\App\Helpers\Util::makeRoute('ecf/product', 'Ecf\ProductController');
