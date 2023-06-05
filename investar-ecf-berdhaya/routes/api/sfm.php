<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.19
 */
use Illuminate\Support\Facades\Route;
Route::prefix('v1/mobile')->middleware(['api'])->group(function (){

    \App\Helpers\Util::makeApiRoute('sfm/invoice', 'Api\Sfm\InvoiceController');
    \App\Helpers\Util::makeApiRoute('sfm/product/product-list', 'Api\Sfm\Product\ProductItemController');
    \App\Helpers\Util::makeApiRoute('sfm/product/product-category', 'Api\Sfm\Product\ProductCategoryController');
    \App\Helpers\Util::makeApiRoute('central/project/timereport', 'Api\Central\Project\TimeReportController');
    \App\Helpers\Util::makeApiRoute('sfm/sales-order', 'Api\Sfm\SalesOrderController');
    \App\Helpers\Util::makeApiRoute('sfm/invoice', 'Api\Sfm\InvoiceController');
    \App\Helpers\Util::makeApiRoute('sfm/payment', 'Api\Sfm\PaymentController');
    \App\Helpers\Util::makeApiRoute('sfm/purchase', 'Api\Sfm\PurchaseController');
    \App\Helpers\Util::makeApiRoute('sfm/expense', 'Api\Sfm\ExpenseController');
    \App\Helpers\Util::makeApiRoute('sfm/shopping-cart', 'Api\Sfm\ShoppingCartController');
    \App\Helpers\Util::makeApiRoute('sfm/product/bill-of-material', 'Api\Sfm\Product\BillOfMaterialController');
    \App\Helpers\Util::makeApiRoute('sfm/product/cogs', 'Api\Sfm\Product\CogsController');
    \App\Helpers\Util::makeApiRoute('sfm/reports/sales-report', 'Api\Sfm\Reports\SalesReportController');
    \App\Helpers\Util::makeApiRoute('sfm/reports/inventory-report', 'Api\Sfm\Reports\inventoryReportController');
    \App\Helpers\Util::makeApiRoute('sfm/reports/purchase-report', 'Api\Sfm\Reports\PurchaseReportController');
    \App\Helpers\Util::makeApiRoute('sfm/reference/outlets', 'Api\Sfm\Reference\OutletsController');
    \App\Helpers\Util::makeApiRoute('sfm/reference/channels', 'Api\Sfm\Reference\ChannelsController');
    \App\Helpers\Util::makeApiRoute('sfm/reference/templates', 'Api\Sfm\Reference\TemplatesController');
    \App\Helpers\Util::makeApiRoute('sfm/product/promo', 'Api\Sfm\Product\PromoController');
    \App\Helpers\Util::makeApiRoute('sfm/store/shipping-cart-attribute', 'Api\Sfm\Store\ShippingCartAttributeController');
    \App\Helpers\Util::makeApiRoute('sfm/shopping-cost', 'Api\Sfm\ShoppingCostController');
    \App\Helpers\Util::makeApiRoute('sfm/delivery/delivery-order', 'Api\Sfm\DeliveryOrderController');

    Route::group(['prefix' => 'data-collection','middleware'=>['api'] ], function (){
		\App\Helpers\Util::makeApiRoute('question', 'Api\Central\DataCollection\QuestionController');
		\App\Helpers\Util::makeApiRoute('option', 'Api\Central\DataCollection\OptionController');
		\App\Helpers\Util::makeApiRoute('setting-form', 'Api\Central\DataCollection\SettingFormController');
		\App\Helpers\Util::makeApiRoute('result-answer', 'Api\Central\DataCollection\ResultAnswerController');
		\App\Helpers\Util::makeApiRoute('responden', 'Api\Central\DataCollection\RespondenController');
		\App\Helpers\Util::makeApiRoute('statement', 'Api\Central\DataCollection\StatementController');
	});

	Route::group(['prefix' => 'hrm','middleware'=>['api'] ], function (){
		\App\Helpers\Util::makeApiRoute('recruitment/applicant', 'Api\Central\Hrm\Recruitment\ApplicantController');
		\App\Helpers\Util::makeApiRoute('employee', 'Api\Central\Hrm\EmployeeController');
		\App\Helpers\Util::makeApiRoute('reference/department', 'Api\Central\Hrm\Reference\DepartmentController');
		\App\Helpers\Util::makeApiRoute('recruitment/schedule', 'Api\Central\Hrm\Recruitment\ScheduleController');
		\App\Helpers\Util::makeApiRoute('reference/position', 'Api\Central\Hrm\Reference\PositionController');
	});

	Route::group(['prefix' => 'project','middleware'=>['api'] ], function (){
		\App\Helpers\Util::makeApiRoute('client', 'Api\Central\Project\ClientController');
		\App\Helpers\Util::makeApiRoute('project', 'Api\Central\Project\ProjectController');
		\App\Helpers\Util::makeApiRoute('tasklist', 'Api\Central\Project\TaskListController');
        \App\Helpers\Util::makeApiRoute('issue', 'Api\Central\Project\IssueTrackerController');
        \App\Helpers\Util::makeApiRoute('personnel', 'Api\Central\Project\PersonnelController');

		Route::group(['prefix' => 'reference','middleware'=>['api'] ], function (){
			\App\Helpers\Util::makeApiRoute('project-model', 'Api\Central\Project\Reference\ProjectModelController');
			\App\Helpers\Util::makeApiRoute('project-type', 'Api\Central\Project\Reference\ProjectTypeController');
			\App\Helpers\Util::makeApiRoute('task-type', 'Api\Central\Project\Reference\TaskTypeController');
			\App\Helpers\Util::makeApiRoute('task-template', 'Api\Central\Project\Reference\TaskTemplateController');
		});
	});
});

