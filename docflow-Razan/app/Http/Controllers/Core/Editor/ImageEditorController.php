<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Core\Editor;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Fcm;
use App\Models\Core\Mongo\Uploaded;
use App\Models\Core\Mongo\User;
use App\Models\Obj\JsonTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageEditorController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Uploaded();
    }

    public function getIndex()
    {
        $this->title = 'ImageEditor';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';
        $this->res_path = 'views/core/fcmregister';
        $this->yml_file = 'fields';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'fcmregister';

        $this->add_url = 'fcmregister/add';

        $this->update_url = 'fcmregister/edit';

        $this->del_url = 'fcmregister/del';

        $this->item_data_url = 'fcmregister/data';

        $this->del_url = 'fcmregister/del';

        $this->can_add = true;

        $this->logo = env('APP_LOGO');

        /* Use custom form layout */
        //$this->form_view = 'form.custom';

        //$this->table_slot_view = 'fcmregister.tableslot';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::getIndex();
    }

    public function getEdit($id = null){

        $this->nav_section = 'users';
        $this->yml_file = 'con';
        $this->res_path = 'views/clinic/patient';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/clinic/patient';
        $this->yml_layout_file = 'op_layout';
        $this->logo = env('APP_LOGO');

        $this->title = 'Image Editor';

        $this->show_title = false;

        $this->data['_id'] = Util::makeDataModel( '_id', trim($id), 'text', 'text', trim($id) );

        $imageNote = url(Storage::disk('local')->url('images/default_draw.png'));

        $this->data['imageNote'] = Util::makeDataModel( 'imageNote', $imageNote, 'text', 'text', $imageNote );

        $this->item_data_url = 'api/v1/mobile/patient/op';

        $this->item_id = $id;

        $this->has_tab = true;

        $this->form_view = 'form.imageeditorpage';

        $this->form_mode = 'edit';

        $this->can_autosave = true;

        $this->can_lock = true;

        $this->grid = [
            ['col'=>[7,5]],
        ];

        $imageNote = url(Storage::disk('local')->url('images/default_draw.jpg'));

        $this->data['anamnesa'] = Util::makeDataModel( 'anamnesa', $imageNote, 'text', 'text', $imageNote );


        $icdTableModel = [
            ['description'=>'134.5 AAAbbb Keterangan tambahan atas ICD-X'],
            ['description'=>'134.6 AAAbbb Keterangan tambahan atas ICD-X'],
            ['description'=>'134.7 AAAbbb Keterangan tambahan atas ICD-X'],
        ];

        $this->data['diagnosa'] = Util::makeDataModel( 'diagnosa', $icdTableModel, 'array', 'array', $icdTableModel );

        $this->data['icdxTable'] = Util::makeDataModel( 'icdxTable', $icdTableModel, 'array', 'array', $icdTableModel );

        //$tabContentTemplate = Util::templateView('key', 'konsul-mata-static-tab');

        $tabContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_tab_template.html') );
        $popviewContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_pop_template.html') );

        $informasiTemplate = Util::templateView('key', 'informasi-laporan-operasi');

        $firstTab = [
            'key'=> date('d-m-Y', time()),
            'title'=> 'Konsul '.date('d-m-Y', time()),
            'content'=> ''
        ];

        $informasi = [
            [
                'function'=>'Operator',
                'actor'=>'dr. Ari Djatikusumo, SpM',
            ],
            [
                'function'=>'Instrumen',
                'actor'=>'Putu Ari Surya Ardi Kayasa',
            ],
            [
                'function'=>'Anestesi',
                'actor'=>'dr. Ari Djatikusumo, SpM',
            ],
            [
                'function'=>'Sirkulasi',
                'actor'=>'Putu Ari Surya Ardi Kayasa',
            ],
            [
                'function'=>'Tipe Operasi',
                'actor'=>'dr. Ari Djatikusumo, SpM',
            ],
            [
                'function'=>'Anestesi',
                'actor'=>'Putu Ari Surya Ardi Kayasa'
            ]
        ];

        $this->data['informasi'] = Util::makeDataModel( 'informasi', $informasi, 'array', 'array', $informasi );

        $terapiObatFields = [
            ['key'=>'deskripsi', 'label'=>'Deskripsi'],
        ];

        $sc = JsonTemplate::get()->toArray();
        foreach( $sc as $s ){
            $prosedurSchemaOptions[] = [ 'text'=>$s['name'], 'value'=>$s['key'] ];
        }

        $uiOptions = [
            'prosedurSchema'=>Util::templateJson('key', 'load-form-schema' ),
            'prosedurSchemaOptions'=>$prosedurSchemaOptions,
            'prosedurOptions'=>[
                'validateAfterLoad'=> false,
                'validateAfterChanged'=> true,
                'validateAsync'=> true
            ],
            'dataInformasi'=>$informasi,
            'terapiObatFields'=>$terapiObatFields,
            'contents'=>['satu', 'dua', 'tiga'],
            'tabViewTemplate'=> "`".$tabContentTemplate."`",
            'popviewContentTemplate'=> "`".$popviewContentTemplate."`",
            'informasiTemplate'=> "`".$informasiTemplate."`",
            'contentTabs'=>[],
            'firstTab'=>$firstTab
        ];



        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->js_load_transform = 'clinic.patient.konsul_js_load_transform';

        $this->js_tab_change = 'clinic.patient.konsul_js_tab_change';

        $this->js_pop_open = 'clinic.patient.konsul_js_pop_open';

        $this->aux_data['patientData'] = '{}';

        return parent::formGenerator();
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
