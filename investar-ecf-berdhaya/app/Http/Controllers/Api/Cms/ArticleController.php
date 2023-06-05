<?php

namespace App\Http\Controllers\Api\Cms;

use App\Http\Controllers\Api\Core\ApiAdminController;
use App\Models\Cms\Article;

class ArticleController extends ApiAdminController
{

    public function __construct()
    {
        $this->controller_name = strtolower( str_replace('Controller', '', get_class()) );
        $this->model = new Article();

        $this->res_path = 'models'; // under resources ,ie: resources/models
        $this->yml_file = 'cms_article'; // name of yml ,ie: member.yml
        $this->entity = 'article';

    }

    public function beforeOutput($data)
    {
        //$data->addOut = "ADD BEFORE OUTPUT";
        return parent::beforeOutput($data); // TODO: Change the autogenerated stub
    }


    public function beforeSave($data)
    {
        //$data->beforeSave = 'BEFORE';
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    public function afterSave($data)
    {
        //$data->afterSave = 'AFTER';
        return parent::afterSave($data); // TODO: Change the autogenerated stub
    }


}
