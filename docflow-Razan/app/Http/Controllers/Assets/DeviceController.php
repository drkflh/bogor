<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Assets;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Assets\Device;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeviceController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Device();
    }

    public function getIndex()
    {
        $this->title = 'Device';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';
        $this->res_path = 'views/assets/device';
        $this->yml_file = 'fields';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'assets/device';

        $this->add_url = 'assets/device/add';

        $this->update_url = 'assets/device/edit';

        $this->del_url = 'assets/device/del';

        $this->item_data_url = 'assets/device/data';

        $this->del_url = 'assets/device/del';

        $this->can_add = true;

        $this->logo = env('APP_LOGO');

        /* Use custom form layout */
        //$this->form_view = 'form.custom';

        //$this->table_slot_view = 'assets.device.tableslot';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::getIndex();
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    protected function rowPostProcess($row)
    {
        /* modify or add new fields */
        //$row['linkConsult'] = url('clinic/patient/km/'.$row['_id']);
        //$row['linkOp'] = url('clinic/patient/op/'.$row['_id']);

        return parent::rowPostProcess($row);
    }

    /* Custom form sample route method
     * requires manual route setting
     * */
    public function getCustomForm($id){

        $this->nav_section = 'users';
        $this->yml_file = 'customform';
        $this->res_path = 'views/custom/form/path';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/custom/form/path';
        $this->logo = env('APP_LOGO');

        /* Injected model data, merged with vue data model as well
         * */
        $patient = User::find($id);

        $this->title = $patient->name;

        /* Merge injected data with with vue data model as well
        `* data with the same var name / index will be overriden by injected data
         * */
        $this->data['patient'] = json_encode($patient->toArray());
        $this->data['imageNote'] = "'".url(Storage::disk('local')->url('images/default_draw.png'))."'";


        $icdarray = [
            ['description'=>'134.5 AAAbbb Keterangan tambahan atas ICD-X'],
            ['description'=>'134.6 AAAbbb Keterangan tambahan atas ICD-X'],
            ['description'=>'134.7 AAAbbb Keterangan tambahan atas ICD-X'],
        ];

        $icdfields = [
            [ 'key'=>'description', 'label'=>'Description'],
            [ 'key'=>'actions', 'label'=>'Action' ]
        ];

        $icdTableModel = [
            'data'=>$icdarray,
            'fields'=>$icdfields
        ];

        $this->data['icdxTable'] = json_encode($icdTableModel);

        $uiOptions = [
            'tabs'=>[
                ['title'=>'2020-01-03', 'key'=>'2020-01-03', 'content'=>'form' ],
                ['title'=>'2020-01-02', 'key'=>'2020-01-02', 'content'=>'static' ],
                ['title'=>'2020-01-01', 'key'=>'2020-01-01', 'content'=>'static' ],
                ['title'=>'2019-12-28', 'key'=>'2020-12-28', 'content'=>'static' ],
                ['title'=>'2019-12-23', 'key'=>'2020-12-23', 'content'=>'static' ],
                ['title'=>'2019-12-20', 'key'=>'2020-12-20', 'content'=>'static' ],
                ['title'=>'2019-12-18', 'key'=>'2020-12-18', 'content'=>'static' ],
                ['title'=>'2019-12-11', 'key'=>'2020-12-11', 'content'=>'static' ],
                ['title'=>'2019-12-10', 'key'=>'2020-12-10', 'content'=>'static' ],
                ['title'=>'2019-12-09', 'key'=>'2020-12-09', 'content'=>'static' ],
            ],
            'contents'=>['satu', 'dua', 'tiga'],
        ];

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        return parent::formGenerator();
    }

}
