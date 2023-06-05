<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.19
 */
use Illuminate\Support\Facades\Route;
Route::prefix('v1/mobile')->middleware(['api'])->group(function (){

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

	\App\Helpers\Util::makeApiRoute('central/project/timereport', 'Api\Central\Project\TimeReportController');
