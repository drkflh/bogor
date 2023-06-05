<?php

use App\Helpers\Util;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'pmc', 'middlewareGroup' => ['web']], function () {

    Route::get('dashboard', 'Pmc\DashboardController@getDashboard');
    Route::get('dashboard/{idProject}', 'Pmc\DashboardController@getProject');
    Route::get('dashboard/personel/{name}', 'Pmc\DashboardController@getPersonel');
    Route::get('dashboard/data/{id}', 'Pmc\DashboardController@getData');
    Route::post('dashboard/data/{id}', 'Pmc\DashboardController@getData');

    Route::post('dev/{projectName}', 'Pmc\TaskListController@getDeveloper');
    Route::post('task/quickadd', 'Pmc\TaskListController@postQuickAdd');
    Route::post('changestat', 'Pmc\ProjectController@changeStat');
    Route::post('add-issue', 'Pmc\TaskListController@addIssue');
    Route::post('getDevInf', 'Pmc\TaskListController@getDevInf');
    Route::post('get-issue', 'Pmc\TaskListController@getIssue');
    Route::get('get-issue', 'Pmc\TaskListController@getIssue');
    Route::post('update-issue', 'Pmc\TaskListController@updateIssue');

    Route::group(['prefix' => 'reference', 'middlewareGroup' => ['web']], function () {
        \App\Helpers\Util::makeRoute('task-template', 'Pmc\Reference\TaskTemplateController');
        \App\Helpers\Util::makeRoute('project-type', 'Pmc\Reference\ProjectTypeController');
        \App\Helpers\Util::makeRoute('project-model', 'Pmc\Reference\ProjectModelController');
        \App\Helpers\Util::makeRoute('task-type', 'Pmc\Reference\TaskTypeController');
    });

    \App\Helpers\Util::makeRoute('project-list', 'Pmc\ProjectController');
    \App\Helpers\Util::makeRoute('project-task', 'Pmc\TaskListController');
    \App\Helpers\Util::makeRoute('log-task-list', 'Pmc\LogTaskListController');
    \App\Helpers\Util::makeRoute('project-issue', 'Pmc\IssueTrackerController');
    \App\Helpers\Util::makeRoute('client', 'Pmc\ClientController');
    \App\Helpers\Util::makeRoute('time-report', 'Pmc\TimeReportController');
    \App\Helpers\Util::makeRoute('log-time-report', 'Pmc\LogTimeReportController');
});

Route::group(['prefix' => 'central', 'middlewareGroup' => ['web']], function () {

    Route::get('/dashboard', 'Central\Admin\DashboardController@getDashboard');
    Route::get('/task', 'Central\Admin\DashboardController@task');
    Route::get('/dashboard/data/{id}', 'Central\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Central\Admin\DashboardController@getData');

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

    Route::group(['prefix' => 'inventory', 'middlewareGroup' => ['web']], function () {
        \App\Helpers\Util::makeRoute('inventory-category', 'Inventory\InventoryCategoryController');
        \App\Helpers\Util::makeRoute('inventory-item', 'Inventory\InventoryItemController');
        \App\Helpers\Util::makeRoute('stock-control', 'Inventory\StockControlController');
    });

    Route::group(['prefix' => 'storefront', 'middlewareGroup' => ['web']], function () {

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

        Route::group(['prefix' => 'product', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('product-category', 'Storefront\Product\ProductCategoryController');
            \App\Helpers\Util::makeRoute('product-list', 'Storefront\Product\ProductItemController');
        });

        Route::group(['prefix' => 'directory', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('customer-directory', 'Storefront\Directory\CustomerDirectoryController');
            \App\Helpers\Util::makeRoute('vendor-directory', 'Storefront\Directory\VendorDirectoryController');
            \App\Helpers\Util::makeRoute('vendor-product-list', 'Storefront\Directory\VendorProductController');
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

    Route::group(['prefix' => 'data-collection', 'middlewareGroup' => ['web']], function () {

        Route::get('/dashboard', 'Central\Admin\DashboardController@getDashboard');

        \App\Helpers\Util::makeRoute('question', 'Central\Dcs\QuestionController');
        \App\Helpers\Util::makeRoute('option', 'Central\Dcs\OptionController');
        \App\Helpers\Util::makeRoute('setting-form', 'Central\Dcs\SettingFormController');
        \App\Helpers\Util::makeRoute('result-answer', 'Central\Dcs\ResultAnswerController');
        \App\Helpers\Util::makeRoute('responden', 'Central\Dcs\RespondenController');
        \App\Helpers\Util::makeRoute('statement', 'Central\Dcs\StatementController');
    });

    Route::group([ 'prefix'=>'reference', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('area', 'Reference\AreaController');
        Route::post('/city', 'Core\UserController@getCity');
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

if(env('WITH_BIZ_ADMIN')){

    Route::group(['prefix' => 'biz', 'middlewareGroup' => ['web']], function () {

        Route::get('/dashboard', 'Biz\Admin\DashboardController@getDashboard');

        Route::get('/dashboard/data/{id}', 'Biz\Admin\DashboardController@getData');
        Route::post('/dashboard/data/{id}', 'Biz\Admin\DashboardController@getData');

        Route::get('/dashboard/sales', 'Biz\Admin\DashboardController@getSales');


        Route::group(['prefix' => 'knowledge', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('glossary', 'Biz\Knowledge\GlossaryController');
            \App\Helpers\Util::makeRoute('video-library', 'Biz\Knowledge\LibraryController');
            \App\Helpers\Util::makeRoute('product-catalogue', 'Biz\Knowledge\CatalogueController');
            \App\Helpers\Util::makeRoute('aml', 'Biz\Knowledge\AmlController');
            \App\Helpers\Util::makeRoute('ga-drawing', 'Biz\Knowledge\GaDrawingController');
        });

        Route::group(['prefix' => 'directory', 'middlewareGroup' => ['web']], function () {

            Route::post('/vendor/seq', 'Biz\Directory\VendorDirectoryController@postGetSeq');
            Route::post('/customer/seq', 'Biz\Directory\CustomerDirectoryController@postGetSeq');

            \App\Helpers\Util::makeRoute('vendor-directory', 'Biz\Directory\VendorDirectoryController');
            \App\Helpers\Util::makeRoute('customer-directory', 'Biz\Directory\CustomerDirectoryController');
        });

        Route::group(['prefix' => 'procurement-logistics', 'middlewareGroup' => ['web']], function () {

            /** ini route post buat post sequence generate purchase requisition number */
            Route::post('/purchase-requisition/seq', 'Biz\ProcurementLogistic\PurchaseRequisitionController@postGetSeq');
            Route::post('/purchase-order/seq', 'Biz\ProcurementLogistic\PurchaseOrderController@postGetSeq');
            Route::post('/work-order/seq', 'Biz\ProcurementLogistic\WorkOrderController@postGetSeq');
            Route::post('/service-requisition/seq', 'Biz\ProcurementLogistic\ServiceRequisitionController@postGetSeq');

            \App\Helpers\Util::makeRoute('purchase-requisition', 'Biz\ProcurementLogistic\PurchaseRequisitionController');
            \App\Helpers\Util::makeRoute('purchase-order', 'Biz\ProcurementLogistic\PurchaseOrderController');
            \App\Helpers\Util::makeRoute('material-receiving', 'Biz\ProcurementLogistic\MaterialReceivingController');
            \App\Helpers\Util::makeRoute('non-conforming', 'Biz\ProcurementLogistic\NonConformingController');
            \App\Helpers\Util::makeRoute('warehouse-return', 'Biz\ProcurementLogistic\WarehouseReturnController');
            \App\Helpers\Util::makeRoute('warehouse-issue', 'Biz\ProcurementLogistic\WarehouseIssueController');
            \App\Helpers\Util::makeRoute('service-requisition', 'Biz\ProcurementLogistic\ServiceRequisitionController');
            \App\Helpers\Util::makeRoute('work-order', 'Biz\ProcurementLogistic\WorkOrderController');
            \App\Helpers\Util::makeRoute('work-accept-notes', 'Biz\ProcurementLogistic\WorkAcceptNotesController');
            \App\Helpers\Util::makeRoute('delivery-request', 'Biz\ProcurementLogistic\DeliveryRequestController');
            \App\Helpers\Util::makeRoute('delivery-order', 'Biz\ProcurementLogistic\DeliveryOrderController');
            \App\Helpers\Util::makeRoute('packing-list', 'Biz\ProcurementLogistic\PackingListController');
            \App\Helpers\Util::makeRoute('stock-issue', 'Biz\ProcurementLogistic\StockIssueController');
        });

        Route::group(['prefix' => 'qc-documentation', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('quality-control', 'Biz\QcDocumentation\QualityControlController');
            \App\Helpers\Util::makeRoute('document-control', 'Biz\QcDocumentation\DocumentControlController');
        });

        Route::group(['prefix' => 'sales-operation', 'middlewareGroup' => ['web']], function () {

            Route::post('/job-register/seq', 'Biz\SalesOperation\JobRegisterController@postGetSeq');
            Route::post('/request-for-quotation/seq', 'Biz\SalesOperation\RequestForQuotationController@postGetSeq');

            \App\Helpers\Util::makeRoute('job-register', 'Biz\SalesOperation\JobRegisterController');
            \App\Helpers\Util::makeRoute('sales-order', 'Biz\SalesOperation\SalesOrderController');
            \App\Helpers\Util::makeRoute('sales-highlight', 'Biz\SalesOperation\SalesHighlightController');
            \App\Helpers\Util::makeRoute('request-for-quotation', 'Biz\SalesOperation\RequestForQuotationController');
            \App\Helpers\Util::makeRoute('request-for-information', 'Biz\SalesOperation\RequestForInformationController');
            \App\Helpers\Util::makeRoute('material-take-off', 'Biz\SalesOperation\MaterialTakeOffController');
            \App\Helpers\Util::makeRoute('logistic-clearance-calc', 'Biz\SalesOperation\LogisticClearanceCalcController');
            \App\Helpers\Util::makeRoute('cost-structure', 'Biz\SalesOperation\CostStructureController');
            \App\Helpers\Util::makeRoute('outgoing-quotation', 'Biz\SalesOperation\OutGoingQuotationController');
            \App\Helpers\Util::makeRoute('budgetary-proposal', 'Biz\SalesOperation\BudgetaryProposalController');

            \App\Helpers\Util::makeRoute('on-going-quotation', 'Biz\SalesOperation\OnGoingQuotationController');
        });

        Route::group(['prefix' => 'reference', 'middlewareGroup' => ['web']], function () {
            \App\Helpers\Util::makeRoute('zipcode', 'Reference\ZipcodeController');
            \App\Helpers\Util::makeRoute('area', 'Reference\AreaController');
            \App\Helpers\Util::makeRoute('country', 'Reference\CountryController');
            \App\Helpers\Util::makeRoute('currency', 'Reference\CurrencyController');
            \App\Helpers\Util::makeRoute('jobstatus', 'Reference\JobStatusController');
            \App\Helpers\Util::makeRoute('costcenter', 'Reference\CostCenterController');
            \App\Helpers\Util::makeRoute('exchange-rate', 'Biz\Reference\ExchangeRateController');
            \App\Helpers\Util::makeRoute('company', 'Reference\CompanyController');
            \App\Helpers\Util::makeRoute('company-type', 'Reference\CompanyTypeController');
            \App\Helpers\Util::makeRoute('uom', 'Reference\UomController');
            \App\Helpers\Util::makeRoute('incoterm', 'Biz\Reference\IncotermController');

        });


        Route::get("vc", function () {
            $vendors = VendorDirectory::whereNull('vendorCode')->orWhere('vendorCode', '=', '')->orWhere('vendorCode', 'exists', false)->get();
            foreach ($vendors as $v) {
                $name = explode(' ', $v->coyName);

                if (count($name) > 1) {
                    $s1 = substr($name[0], 0, 1);
                    $s2 = substr($name[1], 0, 1);
                    $prefix = strtoupper($s1 . $s2);
                } else {
                    $s1 = substr($name[0], 0, 1);
                    $s2 = $s1;
                    $prefix = strtoupper($s1 . $s2);
                }

                $prefix = 'V' . $prefix;

                //cari max vendorSeq
                $seq = VendorDirectory::where('vendorPrefix', '=', $prefix)->count();
                $seq++;
                $v->vendorPrefix = $prefix;
                $v->vendorSeq = $seq;
                $v->vendorCode = $prefix . str_pad($seq, 5, STR_PAD_LEFT);
                $v->save();

                print_r($v);
            }
        });

        Route::get('qr', function () {
            QRCode::create(array(
                "format" => "svg", //"png", "jpg"
                "value" => "Test QRCode",
                "size" => 150,
                "foregroundColor" => array(0, 0, 0),
                "backgroundColor" => array(255, 255, 255),
            ));
            BarCode::create(array(
                "format" => "html", //"svg", "png", "jpg"
                "value" => "081231723897",
                "type" => "TYPE_CODE_128",
                "widthFactor" => 2,
                "height" => 30,
                "color" => "black", //"{{color string}}" for html and svg, array(R, G, B) for jpg and png
            ));
        });

        Route::get("jnf", function () {
            $jobNos = JobRegister::Where('jobNo', '!=', '')->where('jobNo', 'exists', true)->get();

            foreach ($jobNos as $v) {

                $seq = substr($v->jobNo, 5, 3);
                $seq = intval($seq);

                $v->Urut = $seq;

                $prefix = substr($v->jobNo, 0, 5);
                $v->jobNoPrefix = $prefix;
                $v->save();

                print_r($v);
            }
        });

        Route::get("replaceUrl", function () {
            $library = Library::get();

            foreach ($library as $v) {

                $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
                $v->save();

                print_r($v);
            }
        });

        Route::get("pr-num", function () {
            $preq = \App\Models\Biz\ProcurementLogistic\PurchaseRequisition::get();

            foreach ($preq as $v) {


                if (!isset($v->requestNoPrefix) || $v->requestNoPrefix == '') {
                    $rp = explode('-', $v->requestNo);
                    array_pop($rp);
                    $rp = implode('-', $rp);
                    $v->requestNoPrefix = $rp;
                    $v->save();
                }

                print $v->requestNoPrefix . "\r\n";
            }

            $sreq = \App\Models\Biz\ProcurementLogistic\ServiceRequisition::get();

            foreach ($sreq as $v) {


                if (!isset($v->serviceRequestNoPrefix) || $v->serviceRequestNoPrefix == '') {
                    $rp = explode('-', $v->serviceRequestNo);
                    array_pop($rp);
                    $rp = implode('-', $rp);
                    $v->serviceRequestNoPrefix = $rp;
                    $v->save();
                }

                print $v->serviceRequestNoPrefix . "\r\n";
            }
        });

        Route::get("glossaryUrl", function () {
            $library = Glossary::get();

            foreach ($library as $v) {

                $v->Picture = str_replace('http://project.', 'http://sms.', $v->Picture);
                $v->save();

                print_r($v);
            }
        });

        Route::get("catalogueUrl", function () {
            $library = Catalogue::get();

            foreach ($library as $v) {

                $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
                $v->save();

                print_r($v);
            }
        });

        Route::get("gaDrawingUrl", function () {
            $library = GaDrawing::get();

            foreach ($library as $v) {

                $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
                $v->save();

                print_r($v);
            }
        });

        Route::get("changejobstatus", function () {

            $date = date('Y-m-d', time());
            $name = Auth::user()->name;

            return response()->json([
                'result' => 'OK',
                'date' => $date,
                'name' => $name,
                'message' => 'Succes'
            ]);

        });

        // filter jobno

        Route::get("jobnumber", function (Request $request) {
            $q = $request->get("q");
            // $jobs=JobRegister::Where('participatingCompany', '=', $q)->get();
            $jobs = JobRegister::OrderBy('jobNo', 'asc')
                ->where('participatingCompany', '=', $q)
                ->where('jobNo', 'NOT LIKE', 'B%')
                ->where('jobStatus', 'NOT LIKE', 'Closed')
                // ->where(substr('jobNo',2,1) ,'LIKE', 1)
                ->get();

            $jobNo = [];
            // print_r($jobs);
            foreach ($jobs as $v) {
                $jobNo[] = ['text' => $v->jobNo . ' ' . $v->project, 'value' => $v->jobNo];
                // $v->save();
                // print_r($v);

            }
            return response()->json([
                'result' => 'OK',
                'data' => $jobNo,
                'message' => 'Succes'
            ]);

        });

        //filter cost center
        Route::get("costcenter", function (Request $request) {
            $q = $request->get("q");
            $cost = CostCenter::Where('participatingCompany', '=', $q)->get();

            $costCenterCode = [];
            // print_r($jobs);
            foreach ($cost as $v) {
                $costCenterCode[] = ['text' => $v->costCenterCode . ' ' . $v->project, 'value' => $v->costCenterCode];
                // $v->save();
                // print_r($v);

            }
            return response()->json([
                'result' => 'OK',
                'data' => $costCenterCode,
                'message' => 'Succes'
            ]);

        });

        Route::get("actDate", function () {
            $actualDate = JobRegister::WhereNull('actualDelivery')->orWhere('actualDelivery', '=', '')->orWhere('actualDelivery', 'exists', false)->get();

            foreach ($actualDate as $v) {


                $date = Carbon::parse($v->actualDelivery);
                if ($date == '') {
                    $date = new DateTime('now');
                }
                // $seq = intval($seq);

                // $v->Urut = $seq;

                // $prefix = substr( $v->jobNo, 0, 5 );
                // $v->jobNoPrefix = $prefix;
                $v->save();

                print_r($v);
            }
        });

        Route::get("reportase", function () {
            $report = new \App\Reports\MyReport();
            $report->run();
            return view("reports.report", ["report" => $report]);
        });

        Route::get("reportprint", function () {
            $report = new \App\Reports\MyReport();
            $report->run()
                ->export()
                ->pdf([
                    'format' => 'A4',
                    'orientation' => 'portrait'
                ])->toBrowser('user.pdf', true);
            //return view("reports.report",["report"=>$report]);
        });

        Route::get("prt", function () {
            $report = new \App\Reports\PrintPdf();
            $html = '<h5>Hello Word</h5>';

            Exporter::export($html)
                ->pdf(array(
                    "format" => "A4",
                    "orientation" => "portrait"
                ))
                ->toBrowser("myfile.pdf", true);

        });

    });

}

