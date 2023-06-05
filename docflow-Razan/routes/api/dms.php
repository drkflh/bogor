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
	\App\Helpers\Util::makeApiRoute('dwf/admin/archive-doc-type', 'Api\Dwf\Admin\ArchiveDocTypeController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/archive-location', 'Api\Dwf\Admin\ArchiveLocationController');
	\App\Helpers\Util::makeApiRoute('dwf/admin/archive-group', 'Api\Dwf\Admin\ArchiveGroupController');
