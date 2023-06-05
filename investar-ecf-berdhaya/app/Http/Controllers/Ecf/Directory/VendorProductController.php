<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Ecf\Directory;

use App\Helpers\App\EcfUtil;
use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Reference\Product;
use App\Models\Reference\VendorProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorProductController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/ecf/directory';

        $this->yml_file = 'vendor_product_controller';

        $this->entity = 'Vendor Product';

        $this->auth_entity = 'ecf-directory-vendor-product-catalog';

        $this->controller_base = 'ecf/directory/vendor-product-list';

        $this->view_base = 'ecf.directory.vendorproduct';

        $this->model = new VendorProduct();
    }

    public function getIndex()
    {
        $this->title = 'Vendor Product';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'ecf.directory.vendorproduct.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'ecf.directory.vendorproduct.view_layout';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();
        $formOptions['unitOptions'] = EcfUtil::toOptions(EcfUtil::getUnits(),'uom','uom', false);
        $formOptions['vendorCodeOptions'] = EcfUtil::toOptions(EcfUtil::getVendors(),['vendorCode','coyName' ],'vendorCode', false);
        $formOptions['categoryOptions'] = EcfUtil::toOptions(EcfUtil::getCategories(),'category','category', false);
        $formOptions['currencyOptions'] = RefUtil::toOptions(RefUtil::getCurrency(), 'name','name', false);

        $this->aux_data = $formOptions;
        $this->with_advanced_search = false;

        return parent::getIndex();
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function beforeSave($data)
    {

        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}