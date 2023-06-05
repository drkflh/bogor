<?php

use App\Helpers\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


\App\Helpers\Util::makeRoute('home', 'Sfm\Store\HomeController');
\App\Helpers\Util::makeRoute('catalog', 'Sfm\Store\ProductCatalogController');
\App\Helpers\Util::makeRoute('promo', 'Sfm\Store\FrontPromoController');
// \App\Helpers\Util::makeRoute('invoice', 'Sfm\Store\InvoiceController');

Route::get('/company/about-us', 'Sfm\Store\HomeController@getAboutUs');
Route::get('/company/contact-us', 'Sfm\Store\HomeController@getContactUs');
Route::get('/company/privacy-policy', 'Sfm\Store\HomeController@getPrivacyPolicy');

Route::get('check-out', 'Sfm\Store\CheckOutController@getShopping');

Route::get('invoice/data/{id}/{code}', 'Sfm\Store\PaymentController@getData2');
Route::post('invoice/data/{id}/{code}', 'Sfm\Store\PaymentController@getData2');
Route::get('invoice/show/{id}', 'Sfm\Store\PaymentController@showInvoice');
Route::get('cart/clearitem/{id}', 'Sfm\Store\ShoppingCartController@clearItem');


Route::get('/company/support-center', 'Sfm\Store\HomeController@getSupportCenter');
Route::get('/cart', 'Sfm\Store\ShoppingCartController@getShopping');
Route::get('/cart/clear', 'Sfm\Store\ShoppingCartController@clearShoppingCart');
Route::post('/payment', 'Sfm\Store\PaymentController@paymentConfirmation');
Route::post('/proceed', 'Sfm\Store\PaymentController@proceedConfirmation');


// Older Route 
// \App\Helpers\Util::makeRoute('cart', 'Sfm\Store\ShoppingCartController');
// \App\Helpers\Util::makeRoute('check-out', 'Sfm\Store\CheckOutController');
// \App\Helpers\Util::makeRoute('payment', 'Sfm\Store\PaymentController');
// \App\Helpers\Util::makeRoute('proceed', 'Sfm\Store\ProceedController');
Route::post('my-cart', 'Sfm\Store\ShoppingCartController@getActiveCart');


Route::group(['prefix' => 'sfm', 'middlewareGroup' => ['web']], function () {

    Route::get('dashboard', 'Sfm\Admin\DashboardController@getDashboard');
    // Route::get('dashboard/{idProject}', 'Central\Project\DashboardController@getProject');
    // Route::get('dashboard/personel/{name}', 'Central\Project\DashboardController@getPersonel');
    Route::get('dashboard/data/{id}', 'Sfm\Admin\DashboardController@getData');
    Route::post('dashboard/data/{id}', 'Sfm\Admin\DashboardController@getData');
    
    Route::get('shopping/data', 'Sfm\Store\ShoppingCartController@getData');
    Route::get('shopping/data/{id}', 'Sfm\Store\ShoppingCartController@getData');
    Route::post('shopping/data/{id}', 'Sfm\Store\ShoppingCartController@getData');

    Route::get('checkout/data', 'Sfm\Store\CheckoutController@getData');
    Route::get('checkout/data/{id}', 'Sfm\Store\CheckoutController@getData');
    Route::post('checkout/data/{id}', 'Sfm\Store\CheckoutController@getData');

    Route::get('payment/data', 'Sfm\Store\PaymentController@getData2');
    Route::get('payment/payment/{id}', 'Sfm\Store\PaymentController@getData2');
    Route::post('payment/data/{id}', 'Sfm\Store\PaymentController@getData2');   

    Route::get('invoice/data', 'Sfm\Store\PaymentController@getData');
    Route::get('invoice/data/{id}', 'Sfm\Store\PaymentController@getData');
    Route::post('invoice/data/{id}', 'Sfm\Store\PaymentController@getData');   


    Route::post('my-cart', 'Sfm\ShoppingCartController@getActiveCart');

    Route::post('dev/{projectName}', 'Sfm\Admin\TaskListController@getDeveloper');
    Route::post('task/quickadd', 'Sfm\Admin\TaskListController@postQuickAdd');
    Route::post('changestat', 'Sfm\Admin\ProjectController@changeStat');
    Route::post('add-issue', 'Sfm\Admin\TaskListController@addIssue');
    Route::post('get-issue', 'Sfm\Admin\TaskListController@getIssue');
    Route::get('get-issue', 'Sfm\Admin\TaskListController@getIssue');
    Route::post('update-issue', 'Sfm\Admin\TaskListController@updateIssue');

    Route::group(['prefix' => 'product', 'middlewareGroup' => ['web']], function () {
        \App\Helpers\Util::makeRoute('product-category', 'Sfm\Product\ProductCategoryController');
        \App\Helpers\Util::makeRoute('product-list', 'Sfm\Product\ProductItemController');
    });

    Route::group(['prefix' => 'directory', 'middlewareGroup' => ['web']], function () {
        Route::post('/vendor/get-seq', 'Sfm\Directory\VendorDirectoryController@postGetSeq');
        Route::post('/customer/get-seq', 'Sfm\Directory\CustomerDirectoryController@postGetSeq');

        \App\Helpers\Util::makeRoute('customer-directory', 'Sfm\Directory\CustomerDirectoryController');
        \App\Helpers\Util::makeRoute('vendor-directory', 'Sfm\Directory\VendorDirectoryController');
        \App\Helpers\Util::makeRoute('vendor-product-list', 'Sfm\Directory\VendorProductController');
    });

    Route::group(['prefix' => 'reference', 'middlewareGroup' => ['web']], function () {
        \App\Helpers\Util::makeRoute('task-template', 'Central\Project\Reference\TaskTemplateController');
        \App\Helpers\Util::makeRoute('project-type', 'Central\Project\Reference\ProjectTypeController');
        \App\Helpers\Util::makeRoute('project-model', 'Central\Project\Reference\ProjectModelController');
        \App\Helpers\Util::makeRoute('task-type', 'Central\Project\Reference\TaskTypeController');
    });

    \App\Helpers\Util::makeRoute('project-list', 'Central\Project\ProjectController');
    \App\Helpers\Util::makeRoute('project-task', 'Central\Project\TaskListController');
    \App\Helpers\Util::makeRoute('log-task-list', 'Central\Project\LogTaskListController');
    \App\Helpers\Util::makeRoute('project-issue', 'Central\Project\IssueTrackerController');
    \App\Helpers\Util::makeRoute('client', 'Central\Project\ClientController');
});

Route::group(['prefix' => 'inventory', 'middlewareGroup' => ['web']], function () {

    Route::get('/dashboard', 'Inventory\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Inventory\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Inventory\Admin\DashboardController@getData');

    \App\Helpers\Util::makeRoute('inventory-category', 'Inventory\InventoryCategoryController');
    \App\Helpers\Util::makeRoute('inventory-item', 'Inventory\InventoryItemController');
    \App\Helpers\Util::makeRoute('stock-control', 'Inventory\StockControlController');
});


Route::group(['prefix' => 'central', 'middlewareGroup' => ['web']], function () {

    Route::get('/dashboard', 'Central\Admin\DashboardController@getDashboard');

    Route::group(['prefix' => 'hrm', 'middlewareGroup' => ['web']], function () {

        Route::get('/dashboard', 'Central\Hrm\DashboardController@getDashboard');
        Route::get('/dashboard/data/{id}', 'Central\Hrm\DashboardController@getData');
        Route::post('/dashboard/data/{id}', 'Central\Hrm\DashboardController@getData');

        Route::group(['prefix' => 'recruitment', 'middlewareGroup' => ['web']], function () {
            Route::post('clone-user', 'Central\Hrm\Recruitment\ApplicantController@cloneUser');
            \App\Helpers\Util::makeRoute('applicant', 'Central\Hrm\Recruitment\ApplicantController');
            \App\Helpers\Util::makeRoute('schedule', 'Central\Hrm\Recruitment\ScheduleController');
        });

        Route::group(['prefix' => 'reference', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('department', 'Central\Hrm\Reference\DepartmentController');
            \App\Helpers\Util::makeRoute('position', 'Central\Hrm\Reference\PositionController');
        });

        Route::group(['prefix' => 'employment', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('fulltime', 'Central\Hrm\Employment\EmployeeFulltimeController');
            \App\Helpers\Util::makeRoute('temporary', 'Central\Hrm\Employment\EmployeeTemporaryController');
        });

        \App\Helpers\Util::makeRoute('employee', 'Central\Hrm\EmployeeController');

    });

    Route::group(['prefix' => 'project', 'middlewareGroup' => ['web']], function () {

        Route::get('dashboard', 'Central\Project\DashboardController@getDashboard');
        Route::get('dashboard/{idProject}', 'Central\Project\DashboardController@getProject');
        Route::get('dashboard/personel/{name}', 'Central\Project\DashboardController@getPersonel');
        Route::get('dashboard/data/{id}', 'Central\Project\DashboardController@getData');
        Route::post('dashboard/data/{id}', 'Central\Project\DashboardController@getData');

        Route::post('dev/{projectName}', 'Central\Project\TaskListController@getDeveloper');
        Route::post('task/quickadd', 'Central\Project\TaskListController@postQuickAdd');
        Route::post('changestat', 'Central\Project\ProjectController@changeStat');
        Route::post('add-issue', 'Central\Project\TaskListController@addIssue');
        Route::post('get-issue', 'Central\Project\TaskListController@getIssue');
        Route::get('get-issue', 'Central\Project\TaskListController@getIssue');
        Route::post('update-issue', 'Central\Project\TaskListController@updateIssue');

        Route::group(['prefix' => 'reference', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('task-template', 'Central\Project\Reference\TaskTemplateController');
            \App\Helpers\Util::makeRoute('project-type', 'Central\Project\Reference\ProjectTypeController');
            \App\Helpers\Util::makeRoute('project-model', 'Central\Project\Reference\ProjectModelController');
            \App\Helpers\Util::makeRoute('task-type', 'Central\Project\Reference\TaskTypeController');
        });

        \App\Helpers\Util::makeRoute('project-list', 'Central\Project\ProjectController');
        \App\Helpers\Util::makeRoute('project-task', 'Central\Project\TaskListController');
        \App\Helpers\Util::makeRoute('log-task-list', 'Central\Project\LogTaskListController');
        \App\Helpers\Util::makeRoute('project-issue', 'Central\Project\IssueTrackerController');
        \App\Helpers\Util::makeRoute('client', 'Central\Project\ClientController');
    });


    Route::group(['prefix' => 'data-collection', 'middlewareGroup' => ['web']], function () {

        Route::get('/dashboard', 'Central\Admin\DashboardController@getDashboard');

        \App\Helpers\Util::makeRoute('question', 'Central\Dcs\QuestionController');
        \App\Helpers\Util::makeRoute('option', 'Central\Dcs\OptionController');
        \App\Helpers\Util::makeRoute('setting-form', 'Central\Dcs\SettingFormController');
        \App\Helpers\Util::makeRoute('result-answer', 'Central\Dcs\ResultAnswerController');
        \App\Helpers\Util::makeRoute('responden', 'Central\Dcs\RespondenController');
        \App\Helpers\Util::makeRoute('statement', 'Central\Dcs\StatementController');
    });
});


Route::get('application-form', 'Open\RespondenController@applicationForm');
// Route::get('application', 'Central\Dcs\RespondenOutController@applicationForm');
Route::get('question-list', 'Central\Dcs\RespondenController@getQuestion');
Route::get('option-list', 'Central\Dcs\RespondenController@getOption');
Route::get('statement', 'Central\Dcs\RespondenController@getStatement');

Route::get('application', function () {
    return view('layouts.nobleui_application');
});
Route::get('after', function () {
    return view('layouts.after_save_page');
});
Route::post('/application/store', 'Central\Dcs\RespondenOutController@store');
Route::get('/application/test', 'Open\RespondenController@applicationTest');
	
\App\Helpers\Util::makeRoute('sfm/sales-order', 'Sfm\SalesOrderController');
\App\Helpers\Util::makeRoute('sfm/invoice', 'Sfm\InvoiceController');
Route::get('sfm/invoice/data/{id}', 'Sfm\Store\PaymentController@getViewForm');
\App\Helpers\Util::makeRoute('sfm/payment', 'Sfm\PaymentController');
	\App\Helpers\Util::makeRoute('sfm/purchase', 'Sfm\PurchaseController');
	\App\Helpers\Util::makeRoute('sfm/expense', 'Sfm\ExpenseController');
	\App\Helpers\Util::makeRoute('sfm/shopping-cart', 'Sfm\ShoppingCartController');
    \App\Helpers\Util::makeRoute('sfm/transaction-summary', 'Sfm\Admin\TransactionSummaryController');
    Route::get('sfm/transaction-summary', 'Sfm\Admin\TransactionSummaryController@getSummary');
    \App\Helpers\Util::makeRoute('sfm/product/product-summary', 'Sfm\Admin\TransactionSummaryController');
    Route::get('sfm/product/product-summary', 'Sfm\Admin\TransactionSummaryController@getSummary');
	\App\Helpers\Util::makeRoute('sfm/product/bill-of-material', 'Sfm\Product\BillOfMaterialController');
	\App\Helpers\Util::makeRoute('sfm/product/cogs', 'Sfm\Product\CogsController');
	\App\Helpers\Util::makeRoute('sfm/reports/sales-report', 'Sfm\Reports\SalesReportController');
	\App\Helpers\Util::makeRoute('sfm/reports/inventory-report', 'Sfm\Reports\InventoryReportController');
	\App\Helpers\Util::makeRoute('sfm/reports/purchase-report', 'Sfm\Reports\PurchaseReportController');
	\App\Helpers\Util::makeRoute('sfm/reference/outlets', 'Sfm\Reference\OutletsController');
	\App\Helpers\Util::makeRoute('sfm/reference/levels', 'Sfm\Reference\LevelsController');
    \App\Helpers\Util::makeRoute('sfm/reference/channels', 'Sfm\Reference\ChannelsController');
	\App\Helpers\Util::makeRoute('sfm/reference/templates', 'Sfm\Reference\TemplatesController');
	\App\Helpers\Util::makeRoute('sfm/product/promo', 'Sfm\Product\PromoController');
	\App\Helpers\Util::makeRoute('sfm/store/shipping-cart-attribute', 'Sfm\Store\ShippingCartAttributeController');
	\App\Helpers\Util::makeRoute('sfm/shopping-cost', 'Sfm\ShoppingCostController');
	\App\Helpers\Util::makeRoute('sfm/delivery/delivery-order', 'Sfm\Delivery\DeliveryOrderController');
