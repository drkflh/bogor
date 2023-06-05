<?php

use App\Models\Reference\CostCenter;
use App\Models\Sms\Directory\VendorDirectory;
use App\Models\Sms\Directory\CustomerDirectory;
use App\Models\Sms\Knowledge\Catalogue;
use App\Models\Sms\Knowledge\GaDrawing;
use App\Models\Sms\Knowledge\Glossary;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Sms\Knowledge\Library;
use Carbon\Carbon;
use koolreport\barcode\BarCode;
use koolreport\barcode\QRCode;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use App\Helpers\AuthUtil;


Route::group([ 'prefix'=>'sms', 'middlewareGroup'=>['web'] ], function(){

    Route::get('/dashboard', 'Sms\Admin\DashboardController@getDashboard');

    Route::get('/dashboard/data/{id}', 'Sms\Admin\DashboardController@getData');
    Route::post('/dashboard/data/{id}', 'Sms\Admin\DashboardController@getData');

    Route::get('/dashboard/sales', 'Sms\Admin\DashboardController@getSales');


    Route::group([ 'prefix'=>'knowledge', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('glossary', 'Sms\Knowledge\GlossaryController');
        \App\Helpers\Util::makeRoute('video-library', 'Sms\Knowledge\LibraryController');
        \App\Helpers\Util::makeRoute('product-catalogue', 'Sms\Knowledge\CatalogueController');
        \App\Helpers\Util::makeRoute('aml', 'Sms\Knowledge\AmlController');
        \App\Helpers\Util::makeRoute('ga-drawing', 'Sms\Knowledge\GaDrawingController');
    });

    Route::group([ 'prefix'=>'directory', 'middlewareGroup'=>['web'] ], function(){

        Route::post('/vendor/get-seq', 'Sms\Directory\VendorDirectoryController@postGetSeq');
        Route::post('/customer/get-seq', 'Sms\Directory\CustomerDirectoryController@postGetSeq');

        \App\Helpers\Util::makeRoute('vendor-directory', 'Sms\Directory\VendorDirectoryController');
        \App\Helpers\Util::makeRoute('customer-directory', 'Sms\Directory\CustomerDirectoryController');
    });

    Route::group([ 'prefix'=>'procurement-logistics', 'middlewareGroup'=>['web'] ], function(){

        /** ini route post buat post sequence generate purchase requisition number */
        Route::post('/purchase-requisition/get-seq', 'Sms\ProcurementLogistic\PurchaseRequisitionController@postGetSeq');
        Route::post('/purchase-order/get-seq', 'Sms\ProcurementLogistic\PurchaseOrderController@postGetSeq');
        Route::post('/work-order/get-seq', 'Sms\ProcurementLogistic\WorkOrderController@postGetSeq');
        Route::post('/service-requisition/get-seq', 'Sms\ProcurementLogistic\ServiceRequisitionController@postGetSeq');

        \App\Helpers\Util::makeRoute('purchase-requisition',  'Sms\ProcurementLogistic\PurchaseRequisitionController');
        \App\Helpers\Util::makeRoute('purchase-order', 'Sms\ProcurementLogistic\PurchaseOrderController');
        \App\Helpers\Util::makeRoute('material-receiving', 'Sms\ProcurementLogistic\MaterialReceivingController');
        \App\Helpers\Util::makeRoute('non-conforming', 'Sms\ProcurementLogistic\NonConformingController');
        \App\Helpers\Util::makeRoute('warehouse-return', 'Sms\ProcurementLogistic\WarehouseReturnController');
        \App\Helpers\Util::makeRoute('warehouse-issue', 'Sms\ProcurementLogistic\WarehouseIssueController');
        \App\Helpers\Util::makeRoute('service-requisition', 'Sms\ProcurementLogistic\ServiceRequisitionController');
        \App\Helpers\Util::makeRoute('work-order', 'Sms\ProcurementLogistic\WorkOrderController');
        \App\Helpers\Util::makeRoute('work-accept-notes', 'Sms\ProcurementLogistic\WorkAcceptNotesController');
        \App\Helpers\Util::makeRoute('delivery-request', 'Sms\ProcurementLogistic\DeliveryRequestController');
        \App\Helpers\Util::makeRoute('delivery-order', 'Sms\ProcurementLogistic\DeliveryOrderController');
        \App\Helpers\Util::makeRoute('packing-list', 'Sms\ProcurementLogistic\PackingListController');
        \App\Helpers\Util::makeRoute('stock-issue', 'Sms\ProcurementLogistic\StockIssueController');
    });

    Route::group([ 'prefix'=>'qc-documentation', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('quality-control', 'Sms\QcDocumentation\QualityControlController');
        \App\Helpers\Util::makeRoute('document-control', 'Sms\QcDocumentation\DocumentControlController');
    });

    Route::group([ 'prefix'=>'sales-operation', 'middlewareGroup'=>['web'] ], function(){

        Route::post('/job-register/get-seq', 'Sms\SalesOperation\JobRegisterController@postGetSeq');
        Route::post('/job-register/chg-stat', 'Sms\SalesOperation\JobRegisterController@postChgStat');
        Route::post('/request-for-quotation/get-seq', 'Sms\SalesOperation\RequestForQuotationController@postGetSeq');

        \App\Helpers\Util::makeRoute('job-register', 'Sms\SalesOperation\JobRegisterController');
        \App\Helpers\Util::makeRoute('sales-order', 'Sms\SalesOperation\SalesOrderController');
        \App\Helpers\Util::makeRoute('sales-highlight', 'Sms\SalesOperation\SalesHighlightController');
        \App\Helpers\Util::makeRoute('request-for-quotation', 'Sms\SalesOperation\RequestForQuotationController');
        \App\Helpers\Util::makeRoute('request-for-information', 'Sms\SalesOperation\RequestForInformationController');
        \App\Helpers\Util::makeRoute('material-take-off', 'Sms\SalesOperation\MaterialTakeOffController');
        \App\Helpers\Util::makeRoute('logistic-clearance-calc', 'Sms\SalesOperation\LogisticClearanceCalcController');
        \App\Helpers\Util::makeRoute('cost-structure', 'Sms\SalesOperation\CostStructureController');
        \App\Helpers\Util::makeRoute('outgoing-quotation', 'Sms\SalesOperation\OutGoingQuotationController');
        \App\Helpers\Util::makeRoute('budgetary-proposal', 'Sms\SalesOperation\BudgetaryProposalController');

        \App\Helpers\Util::makeRoute('on-going-quotation', 'Sms\SalesOperation\OnGoingQuotationController');
    });

    Route::group([ 'prefix'=>'reference', 'middlewareGroup'=>['web'] ], function(){
        \App\Helpers\Util::makeRoute('zipcode', 'Reference\ZipcodeController');
        \App\Helpers\Util::makeRoute('area', 'Reference\AreaController');
        \App\Helpers\Util::makeRoute('country', 'Reference\CountryController');
        \App\Helpers\Util::makeRoute('currency', 'Reference\CurrencyController');
        \App\Helpers\Util::makeRoute('jobstatus', 'Reference\JobStatusController');
        \App\Helpers\Util::makeRoute('costcenter', 'Reference\CostCenterController');
        \App\Helpers\Util::makeRoute('exchange-rate', 'Sms\Reference\ExchangeRateController');
        \App\Helpers\Util::makeRoute('company', 'Reference\CompanyController');
        \App\Helpers\Util::makeRoute('company-type', 'Reference\CompanyTypeController');
        \App\Helpers\Util::makeRoute('uom', 'Reference\UomController');
        \App\Helpers\Util::makeRoute('incoterm', 'Sms\Reference\IncotermController');

    });




    Route::get("vc",function (){
        $vendors=VendorDirectory::whereNull('vendorCode')->orWhere('vendorCode', '=', '')->orWhere('vendorCode', 'exists', false)->get();
        foreach ($vendors as $v){
            $name = explode(' ', $v->coyName );

            if(count($name) > 1){
                $s1 = substr($name[0], 0, 1);
                $s2 = substr($name[1], 0, 1);
                $prefix = strtoupper($s1.$s2);
            } else {
                $s1 = substr($name[0], 0, 1);
                $s2 = $s1;
                $prefix = strtoupper($s1.$s2);
            }

            $prefix = 'V'.$prefix;

            //cari max vendorSeq
            $seq = VendorDirectory::where('vendorPrefix','=', $prefix )->count();
            $seq++;
            $v->vendorPrefix = $prefix;
            $v->vendorSeq = $seq;
            $v->vendorCode = $prefix.str_pad($seq, 5, STR_PAD_LEFT);
            $v->save();

            print_r($v);
        }
    });

    Route::get('qr', function (){
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
    } );

    Route::get("jnf",function (){
        $jobNos=JobRegister::Where('jobNo', '!=', '')->where('jobNo', 'exists', true)->get();

        foreach ($jobNos as $v){

            $seq = substr( $v->jobNo, 5, 3 );
            $seq = intval($seq);

            $v->Urut = $seq;

            $prefix = substr( $v->jobNo, 0, 5 );
            $v->jobNoPrefix = $prefix;
            $v->save();

            print_r($v);
        }
    });

    Route::get("replaceUrl",function (){
        $library=Library::get();

        foreach ($library as $v){

            $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
            $v->save();

            print_r($v);
        }
    });

    Route::get("pr-num",function (){
        $preq = \App\Models\Sms\ProcurementLogistic\PurchaseRequisition::get();

        foreach ($preq as $v){


            if(!isset($v->requestNoPrefix) || $v->requestNoPrefix == '' ){
                $rp = explode('-', $v->requestNo );
                array_pop($rp);
                $rp = implode('-', $rp);
                $v->requestNoPrefix = $rp;
                $v->save();
            }

            print $v->requestNoPrefix ."\r\n" ;
        }

        $sreq = \App\Models\Sms\ProcurementLogistic\ServiceRequisition::get();

        foreach ($sreq as $v){


            if(!isset($v->serviceRequestNoPrefix) || $v->serviceRequestNoPrefix == '' ){
                $rp = explode('-', $v->serviceRequestNo );
                array_pop($rp);
                $rp = implode('-', $rp);
                $v->serviceRequestNoPrefix = $rp;
                $v->save();
            }

            print $v->serviceRequestNoPrefix ."\r\n" ;
        }
    });

    Route::get("glossaryUrl",function (){
        $library=Glossary::get();

        foreach ($library as $v){

            $v->Picture = str_replace('http://project.', 'http://sms.', $v->Picture);
            $v->save();

            print_r($v);
        }
    });

    Route::get("catalogueUrl",function (){
        $library=Catalogue::get();

        foreach ($library as $v){

            $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
            $v->save();

            print_r($v);
        }
    });

    Route::get("gaDrawingUrl",function (){
        $library=GaDrawing::get();

        foreach ($library as $v){

            $v->mediaUrl = str_replace('http://project.', 'http://sms.', $v->mediaUrl);
            $v->save();

            print_r($v);
        }
    });

    Route::get("changejobstatus",function (){

        $date = date('Y-m-d', time());
        $name = Auth::user()->name;

        return response()->json([
            'result'=>'OK',
            'date'=>$date,
            'name'=>$name,
            'message' => 'Succes'
        ]);

    });

    // filter jobno

    Route::get("jobnumber",function (Request $request){
        $q = $request->get("q");
        // $jobs=JobRegister::Where('participatingCompany', '=', $q)->get();
        $jobs = JobRegister::OrderBy('jobNo','asc')
        ->where('participatingCompany','=',$q)
        ->where('jobNo','NOT LIKE','B%')
        ->where('jobStatus','NOT LIKE','Closed')
        // ->where(substr('jobNo',2,1) ,'LIKE', 1)
        ->get();

        $jobNo = [];
        // print_r($jobs);
        foreach ($jobs as $v){
            $jobNo[] = [ 'text'=>$v->jobNo. ' ' .$v->project, 'value'=>$v->jobNo  ];
            // $v->save();
            // print_r($v);

        }
        return response()->json([
            'result'=>'OK',
            'data'=>$jobNo,
            'message' => 'Succes'
        ]);

    });

    //filter cost center
    Route::get("costcenter",function (Request $request){
        $q = $request->get("q");
        $cost=CostCenter::Where('participatingCompany', '=', $q)->get();

        $costCenterCode = [];
        // print_r($jobs);
        foreach ($cost as $v){
            $costCenterCode[] = [ 'text'=>$v->costCenterCode. ' ' .$v->project, 'value'=>$v->costCenterCode  ];
            // $v->save();
            // print_r($v);

        }
        return response()->json([
            'result'=>'OK',
            'data'=>$costCenterCode,
            'message' => 'Succes'
        ]);

    });

    Route::get("actDate",function (){
        $actualDate=JobRegister::WhereNull('actualDelivery')->orWhere('actualDelivery', '=', '')->orWhere('actualDelivery', 'exists', false)->get();

        foreach ($actualDate as $v){


            $date = Carbon::parse($v->actualDelivery);
            if($date == ''){
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

    Route::get("reportase", function (){
        $report = new \App\Reports\MyReport();
        $report->run();
        return view("reports.report",["report"=>$report]);
    });

    Route::get("reportprint", function (){
        $report = new \App\Reports\MyReport();
        $report->run()
            ->export()
            ->pdf([
                'format'=>'A4',
                'orientation' => 'portrait'
            ])->toBrowser('user.pdf', true);
        //return view("reports.report",["report"=>$report]);
    });

    Route::get("prt", function (){
        $report = new \App\Reports\PrintPdf();
        $html = '<h5>Hello Word</h5>';

        Exporter::export( $html )
            ->pdf(array(
                "format"=>"A4",
                "orientation"=>"portrait"
            ))
            ->toBrowser("myfile.pdf", true);

    });

});
