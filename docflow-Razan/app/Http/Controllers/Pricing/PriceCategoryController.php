<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Pricing;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Cars\CarCategory;
use App\Models\Core\Mongo\User;
use App\Models\Pricing\PriceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PriceCategoryController extends AdminController

{
    public function __construct()
    {
        parent::__construct();
        // this must be set to use ACL
        $this->auth_entity = 'price-service';

        // set controller path
        $this->controller_base = 'price/service';

        // set view base to include standard slot
        $this->view_base = 'pricing.priceservice';
        $this->model = new PriceService();
    }

    public function getIndex()
    {
        $this->title = 'Price Category';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        //$this->nav_section = 'assets';
        $this->res_path = 'views/pricing/pricecategory';
        $this->yml_file = 'fields';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->logo = env('APP_LOGO');

        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'pricing.priceservice.formlayout';
        $this->form_dialog_size = 'md';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::getIndex();
    }

}
