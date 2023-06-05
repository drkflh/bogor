<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.19
 */
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/mobile','middleware'=>['api'] ], function (){

    \App\Helpers\Util::makeApiRoute('project', 'Api\Lumbungku\ProjectController');
    \App\Helpers\Util::makeApiRoute('task', 'Api\Lumbungku\TaskController');
    \App\Helpers\Util::makeApiRoute('report', 'Api\Lumbungku\ReportController');

});
	\App\Helpers\Util::makeApiRoute('dwf/document', 'Api\dwf\document\DocumentController');
	\App\Helpers\Util::makeApiRoute('dwf/document', 'Api\Dwf\DocumentController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/group-alias', 'Api\Dwf\Admin\GroupAliasController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/job-group', 'Api\Dwf\Admin\JobGroupController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/disposition-item', 'Api\Dwf\Admin\DispositionItemController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/archive-type', 'Api\Dwf\Admin\ArchiveTypeController');
	\App\Helpers\Util::makeApiRoute('fms/cattle-profile', 'Api\Fms\CattleProfileController');
	\App\Helpers\Util::makeApiRoute('fms/farm', 'Api\Fms\FarmController');
	\App\Helpers\Util::makeApiRoute('fms/observation', 'Api\Fms\ObservationController');
	\App\Helpers\Util::makeApiRoute('fms/environment', 'Api\Fms\EnvironmentController');
	\App\Helpers\Util::makeApiRoute('fms/reproduction', 'Api\Fms\ReproductionController');
	\App\Helpers\Util::makeApiRoute('fms/insemination', 'Api\Fms\InseminationController');
	\App\Helpers\Util::makeApiRoute('fms/dairy-production', 'Api\Fms\DairyProductionController');
	\App\Helpers\Util::makeApiRoute('fms/medical-treatment', 'Api\Fms\MedicalTreatmentController');
	\App\Helpers\Util::makeApiRoute('fms/med-administered-drug', 'Api\Fms\MedAdministeredDrugController');
	\App\Helpers\Util::makeApiRoute('fms/semen-inventory', 'Api\Fms\SemenInventoryController');
	\App\Helpers\Util::makeApiRoute('fms/vaccination', 'Api\Fms\VaccinationController');
	\App\Helpers\Util::makeApiRoute('fms/birth', 'Api\Fms\BirthController');
	\App\Helpers\Util::makeApiRoute('fms/weight-log', 'Api\Fms\WeightLogController');
	\App\Helpers\Util::makeApiRoute('fms/food-supply', 'Api\Fms\FoodSupplyController');
	\App\Helpers\Util::makeApiRoute('fms/admin/breed', 'Api\Fms\Admin\BreedController');
	\App\Helpers\Util::makeApiRoute('fms/fresh-check', 'Api\Fms\FreshCheckController');
	\App\Helpers\Util::makeApiRoute('fms/pregnant-check', 'Api\Fms\PregnantCheckController');
	\App\Helpers\Util::makeApiRoute('fms/konsultasi', 'Api\Fms\KonsultasiController');
