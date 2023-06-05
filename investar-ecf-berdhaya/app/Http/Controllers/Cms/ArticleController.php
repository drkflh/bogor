<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Cms;

use App\Helpers\AuthUtil;
use App\Helpers\CmsUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Cms\Article;
use App\Models\Cms\Category;
use App\Models\Cms\Section;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArticleController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/cms';
        $this->yml_file = 'article_controller';

        $this->entity = 'Article';
        $this->view_base = 'cms.article';
        $this->auth_entity = 'cms-article';
        $this->controller_base = 'cms/article';

        $this->clone_name_field = 'title';

        $this->model = new Article();
    }

    /**
     * @hideFromAPIDocumentation
     * @return mixed
     */
    public function getIndex()
    {
        $this->title = 'Article';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->template_var = [ 'hasSideNav'=>true ];


        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->import_commit_url = 'cms/article/commit';

        $this->logo = env('APP_LOGO');

        $this->show_title = true;

        $this->viewer_layout = 'cms.article.formlayout';

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'cms.article.formlayout';
        $this->form_dialog_size = 'xl';

        $this->can_approve = false;
        $this->can_request_approval = false;
        $this->can_revise = false;

        $this->add_as_page = true;
        $this->edit_as_page = true;

        $this->title_fields = 'title';

        return parent::getIndex();
    }

    public function setupInjector($uiOptions, $data = null)
    {
        $uiOptions = Injector::setModel( Category::orderBy('categoryCode') ) // gunakan model sebagai input, set query disini
        ->toModelArray() // akan running query dan menghasilkan array object
        ->toOptions('categoryName', 'categoryCode', true) // jadikan option untuk select
        ->injectOption('category', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        $uiOptions = Injector::setModel( Section::orderBy('sectionCode') ) // gunakan model sebagai input, set query disini
        ->toModelArray() // akan running query dan menghasilkan array object
        ->toOptions('sectionName', 'sectionCode', true) // jadikan option untuk select
        ->injectOption('section', $uiOptions); // inject ke uioptions, gunakan nama field biasa tanpa suffix, suffix & prefix akan dihandle di fungsi injectOption

        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        $formOptions['sectionOptions'] = CmsUtil::toOptions(CmsUtil::getSection(), 'sectionName', 'sectionCode');
        $formOptions['statusOptions'] = [ [ 'text'=>"Draft", 'value'=>"Draft" ], [ 'text'=>"Published", 'value'=>"Published" ], [ 'text'=>"Unpublished", 'value'=>"Unpublished" ]];

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __('Add').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'cms.article.formlayout';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $this->page_redirect_after_save = true;

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $id;

        $this->title = __('Edit').' '.$item->title;

        /* Use custom form layout */
        $this->form_layout = 'cms.article.formlayout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $this->page_redirect_after_save = true;

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    /**
     * @hideFromAPIDocumentation
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function postIndex(Request $request)
    {

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {
        return parent::getParam(); // TODO: Change the autogenerated stub
    }



    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    // Transform fields before commited into the database collection ( xls import )
    public function beforeImportCommit($data)
    {
        //example : transform imported data to datetime field
        // $data['IODate'] = ImportUtil::excelDateToNormal($data['IODate']);
        // $data['DocDate'] = ImportUtil::excelDateToNormal($data['DocDate']);
        // $data['RetDate'] = ImportUtil::excelDateToNormal($data['RetDate']);
        // $data['DispDate'] = ImportUtil::excelDateToNormal($data['DispDate']);
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeImportCommit($data); // TODO: Change the autogenerated stub
    }


    public function beforeUpdate($id, $data)
    {
        $data['version'] = config('dbversions.product_categories');
        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }
}
