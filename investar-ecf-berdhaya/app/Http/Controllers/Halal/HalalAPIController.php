<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Halal;

use App\Helpers\AuthUtil;
use App\Helpers\ImportUtil;
use App\Helpers\Util;
use App\Helpers\RefUtil;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Halal\HalalProduct;
use App\Models\Halal\BizProfile;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class HalalAPIController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/halal';

        $this->yml_file = 'halalproduct_controller';

        $this->entity = 'Halal Product';

        $this->auth_entity = 'halal-product';

        $this->controller_base = 'halal/halal-product';

        $this->view_base = 'halal.halalproduct';

        $this->model = new HalalProduct();
    }

    public function getIndex()
    {
        $this->title = 'Halal Product';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.halalproduct.form_layout';
        $this->form_dialog_size = 'lg';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'halal.halalproduct.view_layout';
        $this->viewer_dialog_size = 'lg';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = false;
        $this->edit_as_page = false;
        $this->with_advanced_search = false;
        $this->update_title_fields = '"<h4>'.__('Ubah')." ".'" + this.name + "</h4>"';
        $this->view_title_fields = '"<h4>'.__('Lihat')." ".'" + this.name + "</h4>"';

        // $this->page_additional_view = 'halal.halalproduct.page_additional';

        $this->add_filler = false;

        return parent::getIndex();
    }

    public function regHalal(Request $request){

        $mail = Auth::user()->email;
        $param = '';

        $sihalal = Http::post('http://dev-api.halal.go.id/v1/users',[

       
        ])->body();

        if($mail){
            return response()->json([
                'status' => 'Success',
                'msg' => 'Success',
                'code' => 0,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'Username or password not found',
                'code' => 400,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'Parameter not found : ', $param,
                'code' => 401,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'You are an unauthorization',
                'code' => 402,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'Parameter : ', $param ,'cannot be empty',
                'code' => 410,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'No data found',
                'code' => 420,
                'data' => '' 
            ]);
        }else if($mail){
            return response()->json([
                'status' => 'Failed',
                'msg' => 'The parameter value is not as  expected',
                'code' => 430,
                'data' => '' 
            ]);
        }else {
            return response()->json([
                'status' => 'Failed',
                'msg' => 'Failed',
                'code' => 500,
                'data' => '' 
            ]);
        }


        //  $result_json = json_decode($sihalal, true);
        //  print_r($result_json['data']['userid']);

    
    }
}