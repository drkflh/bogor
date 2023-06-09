<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Assets\Vehicle;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Vehicle\CarType;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleTypeController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->model = new CarType();
    }

    public function getIndex()
    {
        $this->title = 'Type';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        //$this->nav_section = 'assets';
        $this->res_path = 'views/cars/vehicletype';
        $this->yml_file = 'fields';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'assets/vehicletype';

        $this->add_url = 'assets/vehicletype/add';

        $this->update_url = 'assets/vehicletype/edit';

        $this->item_data_url = 'assets/vehicletype/data';

        $this->param_url = 'assets/vehicletype/param';

        $this->del_url = 'assets/vehicletype/del';

        $this->clone_url = 'assets/vehicletype/clone';

        $this->download_url = 'assets/vehicletype/dlxl';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'assets/vehicletype/commit';

        $this->logo = env('APP_LOGO');

        /* Use custom form layout
        *  default to form.flatgrid
        *  change form_view & view_layout
        */
        // use custom form
        //$this->form_view = 'form.custom';
        // or use html template for mote detailed control without having to fiddle with YML
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'cars.vehicletype.formlayout';

        $this->form_dialog_size = '';

        $this->table_slot_view = 'cars.vehicletype.table_slot';
        $this->table_head_slot_view = 'cars.vehicletype.table_head_slot';
        $this->table_action_view = 'cars.vehicletype.table_action';
        $this->table_modal_view = 'cars.vehicletype.table_modal';

        $this->table_methods_view = 'cars.vehicletype.table_methods';
        $this->table_computed_view = 'cars.vehicletype.table_computed';
        $this->table_watch_view = 'cars.vehicletype.table_watch';


        $this->add_methods_view = 'cars.vehicletype.add_methods';
        $this->add_computed_view = 'cars.vehicletype.add_computed';
        $this->add_watch_view = 'cars.vehicletype.add_watch';

        $this->edit_methods_view = 'cars.vehicletype.edit_methods';
        $this->edit_computed_view = 'cars.vehicletype.edit_computed';
        $this->edit_watch_view = 'cars.vehicletype.edit_watch';

        //$this->view_layout = 'form.viewcustom';

        /* modify grid settings
        *  default to [['col'=>[6,6]],[['col'=>[4,4,4]]]
        */
        //$this->grid = [
        //    ['col'=>[4,4,4]]
        //];

        /* slot view for cell formating
        */
        //$this->table_slot_view = 'car.management.tableslot';

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = $formOptions;

        return parent::getIndex();
    }

    public function postIndex(Request $request)
    {
        //$this->defOrderField = 'IODate';
        //$this->defOrderDir = 'desc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
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



    /*  Example API Proxy
     *
     *
     * */
    public function getKonsulData($id)
    {
        $client = new Client();
        $result = $client->get(env('KMN_DATA_URL').'/'.$id, [
            'form_params' => [
                'sample-form-data' => 'value'
            ]
        ]);

        return response($result->getBody())
            ->withHeaders([
                'Content-Type' => 'application/json'
            ]);

        return response()->content($result);

    }

    /* Custom form sample route method
     * requires manual route setting
     * */
    public function getCustomForm($id){

        $this->nav_section = 'users';
        $this->yml_file = 'op';
        $this->res_path = 'views/clinic/patient';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/clinic/patient';
        $this->yml_layout_file = 'op_layout';
        $this->logo = env('APP_LOGO');

        /* Injected model data, merged with vue data model as well
         * */

        $patient = User::find(trim($id));

        $this->title = $patient->name ?? '';

        $this->show_title = false;

        $this->data['_id'] = Util::makeDataModel( '_id', trim($id), 'text', 'text', trim($id) );

        $pat = ($patient)? $patient->toArray(): [];

        $this->data['patient'] = Util::makeDataModel( 'patient', $pat , 'object', 'object', $pat  );

        $imageNote = url(Storage::disk('local')->url('images/default_draw.png'));

        $this->data['imageNote'] = Util::makeDataModel( 'imageNote', $imageNote, 'text', 'text', $imageNote );

        $this->item_data_url = 'clinic/kd/'.$id;

        $this->add_url = 'clinic/konsul/add';

        $this->update_url = 'clinic/konsul/relay';

        $this->autosave_url = 'clinic/konsul/autosave';

        $this->item_id = $id;

        $this->has_tab = true;

        $this->form_view = 'form.flatgridpage';

        $this->form_mode = 'edit';

        $this->can_autosave = false;

        $this->can_add = true;

        $this->can_lock = true;

        $this->grid = [
            ['col'=>[7,5]],
        ];

        $imageNote = url(Storage::disk('local')->url('images/default_draw.jpg'));

        $this->data['anamnesa'] = Util::makeDataModel( 'anamnesa', $imageNote, 'text', 'text', $imageNote );
        $tabContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_tab_template.html') );
        $popviewContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_pop_template.html') );

        $terapiObatFields = [
            ['key'=>'mata', 'label'=>'Mata'],
            ['key'=>'namaObat', 'label'=>'Obat'],
            ['key'=>'aturanPakai', 'label'=>'Aturan Pakai'],
        ];

        $sc = JsonTemplate::get()->toArray();
        foreach( $sc as $s ){
            $prosedurSchemaOptions[] = [ 'text'=>$s['name'], 'value'=>$s['key'] ];
        }

        // setup right side bar
        $rangeTime = [];
        for($i = 1; $i < 11; $i++){
            $rangeTime[] = ['text'=>$i, 'value'=>$i];
        }

        $rangeDurasi = [
            ['text'=>5, 'value'=>5],
            ['text'=>10, 'value'=>10],
            ['text'=>15, 'value'=>15],
            ['text'=>20, 'value'=>20],
            ['text'=>30, 'value'=>30],
            ['text'=>40, 'value'=>40],
            ['text'=>50, 'value'=>50],
            ['text'=>60, 'value'=>60],
            ['text'=>90, 'value'=>90],
            ['text'=>120, 'value'=>120]
        ];

        $rsbParams = [
            'nextVisit'=>[
                'jenis'=>[
                    ['text'=>'LOGMAR', 'value'=>'LOGMAR'],
                    ['text'=>'NCT', 'value'=>'NCT'],
                    ['text'=>'Refraksi Lengkap', 'value'=>'Refraksi Lengkap'],
                    ['text'=>'Tidak Perlu Refraksi', 'value'=>'Tidak Perlu Refraksi'],
                    ['text'=>'Visus Kasar', 'value'=>'Visus Kasar'],
                ],
                'satuanWaktu'=>[
                    ['text'=>'Tahun', 'value'=>'Tahun'],
                    ['text'=>'Bulan', 'value'=>'Bulan'],
                    ['text'=>'Minggu', 'value'=>'Minggu'],
                    ['text'=>'Hari', 'value'=>'Hari'],
                ],
                'rangeWaktu'=>$rangeTime,
                'rangeDurasi'=>$rangeDurasi
            ],
            'status'=>[
                'yesNo'=>[
                    ['text'=>'Yes', 'value'=>'Yes'],
                    ['text'=>'No', 'value'=>'No'],
                ],
                'openClose'=>[
                    ['text'=>'Open', 'value'=>'Open'],
                    ['text'=>'Close', 'value'=>'Close'],
                ],
            ],
            'jenisSC'=>[
                ['text'=>'BCL', 'value'=>'BCL'],
                ['text'=>'NCT', 'value'=>'NCT'],
                ['text'=>'SPC', 'value'=>'SPC'],
            ],
            'gradeKatarak'=>[
                ['text'=>1, 'value'=>1],
                ['text'=>2, 'value'=>2],
                ['text'=>3, 'value'=>3],
                ['text'=>4, 'value'=>4],
                ['text'=>5, 'value'=>5],
                ['text'=>'Black/Hypermature', 'value'=>'Black/Hypermature'],
                ['text'=>'Post Op', 'value'=>'Post Op'],
                ['text'=>'Ops Luar', 'value'=>'Ops Luar'],
            ],

        ];
        $rsbModel = [
            'nextVisit'=>[
                'jenis'=>'',
                'waktu'=>1,
                'satuanWaktu'=>'Hari',
                'keterangan'=>''
            ],
            'durasiOp'=>[
                'durasiMenit'=>0
            ],
            'gradeKatarak'=>[
                'OS'=>'',
                'OD'=>''
            ],
            'infeksi'=>[
                'terjadiInfeksi'=>'',
                'kultur'=>'',
                'keterangan'=>'',
                'catatan'=>''
            ],
            'kondisiKhusus'=>[
                'jatuhTempo'=>'',
                'status'=>'',
                'jenisSC'=>'',
                'keterangan'=>''
            ],

        ];
        $rsbTemplate = file_get_contents( resource_path('views/clinic/patient/sidebar.html') );

        $this->right_sidebar_data = [];
        $this->right_sidebar_template = "`".$rsbTemplate."`";
        $this->right_sidebar_model = $rsbModel;
        $this->right_sidebar_params = $rsbParams;

        $diagnosaFields = [
            ['key'=>'mata', 'label'=>'Mata'],
            ['key'=>'icdx', 'label'=>'ICD-X'],
        ];

        $diagnosaObjDef = ['mata'=>'', 'icdx'=>''];
        $diagnosaParams = [
            'mataoptions'=>[
                ['text'=>'OD', 'value'=>'OD'],
                ['text'=>'OS', 'value'=>'OS'],
                ['text'=>'ODS', 'value'=>'ODS'],
            ],
            'icdxDefault'=>$diagnosaObjDef,
            'icdxUrl'=>url('api/v1/core/icdx'),
        ];

        $diagnosaContent = [];
        $diagnosaTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_diagnosa_form.html') )."`";


        $terapiObatObjDef = [
            'namaObat'=>'',
            'namaObatTeks'=>'',
            'aturanPakai'=>'',
            'aturanPakaiTeks'=>'',
            'mata'=>'',
            'icdx'=>'',
            'jumlah'=>0,
            'keterangan'=>''
        ];

        $terapiObatParams = [
            'mataoptions'=>[
                ['text'=>'OD', 'value'=>'OD'],
                ['text'=>'OS', 'value'=>'OS'],
                ['text'=>'ODS', 'value'=>'ODS'],
            ],
            'icdxDefault'=>$terapiObatObjDef,
            'icdxUrl'=>url('api/v1/core/icdx'),
            'jenisObatUrl'=>url('api/v1/core/obat'),
            'aturanPakaiUrl'=>url('api/v1/core/aturanpakai'),
        ];

        $terapiObatContent = [];
        $terapiObatTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_terapi_obat_form.html') )."`";
        $terapiNonObatContent = [];

        $pemeriksaanAwalTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_pemeriksaan_awal.html') )."`";

        $uiOptions = [
            'diagnosaFields'=>$diagnosaFields,
            'diagnosaParams'=>$diagnosaParams,
            'diagnosaContent'=>json_encode($diagnosaContent),
            'diagnosaTemplate'=>$diagnosaTemplate,
            'diagnosaObjDef'=>json_encode($diagnosaObjDef),

            'terapiObatFields'=>$terapiObatFields,
            'terapiObatParams'=>$terapiObatParams,
            'terapiObatTemplate'=>$terapiObatTemplate,
            'terapiObatObjDef'=>json_encode($terapiObatObjDef),
            'terapiObatContent'=>$terapiObatContent,

            'terapiNonObatContent'=>$terapiNonObatContent,


            'tabViewTemplate'=> "`".$tabContentTemplate."`",
            'popviewContentTemplate'=> "`".$popviewContentTemplate."`",
            'pemeriksaanAwalTemplate'=>$pemeriksaanAwalTemplate,
            'contentTabs'=>[],

        ];



        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->js_load_transform = 'clinic.patient.konsul_js_load_transform';

        $this->js_post_transform = 'clinic.patient.konsul_js_post_transform';

        $this->js_tab_change = 'clinic.patient.konsul_js_tab_change';

        $this->js_pop_open = 'clinic.patient.konsul_js_pop_open';

        $this->aux_data['patientData'] = '{}';

        return parent::formGenerator();
    }

    public function getOp($id = null){

        $this->nav_section = 'users';
        $this->yml_file = 'op';
        $this->res_path = 'views/clinic/patient';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/clinic/patient';
        $this->yml_layout_file = 'op_layout';
        $this->logo = env('APP_LOGO');

        $patient = User::find(trim($id));

        $this->title = $patient->name ?? '';

        $this->show_title = false;

        $this->data['_id'] = Util::makeDataModel( '_id', trim($id), 'text', 'text', trim($id) );

        $pat = ($patient)? $patient->toArray(): [];

        $this->data['patient'] = Util::makeDataModel( 'patient', $pat , 'object', 'object', $pat  );

        $imageNote = url(Storage::disk('local')->url('images/default_draw.png'));

        $this->data['imageNote'] = Util::makeDataModel( 'imageNote', $imageNote, 'text', 'text', $imageNote );

        $this->item_data_url = 'clinic/kd/'.$id;

        $this->add_url = 'clinic/operasi/add';

        $this->update_url = 'clinic/operasi/relay';

        $this->autosave_url = 'clinic/operasi/autosave';

        $this->item_id = $id;

        $this->has_tab = true;

        $this->form_view = 'form.flatgridpage';

        $this->form_mode = 'edit';

        $this->can_autosave = false;

        $this->can_add = true;

        $this->can_lock = true;

        $this->grid = [
            ['col'=>[7,5]],
        ];

        $imageNote = url(Storage::disk('local')->url('images/default_draw.jpg'));

        $this->data['anamnesa'] = Util::makeDataModel( 'anamnesa', $imageNote, 'text', 'text', $imageNote );
        $tabContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_tab_template.html') );
        $popviewContentTemplate = file_get_contents( resource_path('views/clinic/patient/konsul_pop_template.html') );

        $terapiObatFields = [
            ['key'=>'mata', 'label'=>'Mata'],
            ['key'=>'namaObat', 'label'=>'Obat'],
            ['key'=>'aturanPakai', 'label'=>'Aturan Pakai'],
        ];

        $sc = JsonTemplate::get()->toArray();
        foreach( $sc as $s ){
            $prosedurSchemaOptions[] = [ 'text'=>$s['name'], 'value'=>$s['key'] ];
        }

        // setup right side bar
        $rangeTime = [];
        for($i = 1; $i < 11; $i++){
            $rangeTime[] = ['text'=>$i, 'value'=>$i];
        }

        $rangeDurasi = [
            ['text'=>5, 'value'=>5],
            ['text'=>10, 'value'=>10],
            ['text'=>15, 'value'=>15],
            ['text'=>20, 'value'=>20],
            ['text'=>30, 'value'=>30],
            ['text'=>40, 'value'=>40],
            ['text'=>50, 'value'=>50],
            ['text'=>60, 'value'=>60],
            ['text'=>90, 'value'=>90],
            ['text'=>120, 'value'=>120]
        ];

        $rsbParams = [
            'nextVisit'=>[
                'jenis'=>[
                    ['text'=>'LOGMAR', 'value'=>'LOGMAR'],
                    ['text'=>'NCT', 'value'=>'NCT'],
                    ['text'=>'Refraksi Lengkap', 'value'=>'Refraksi Lengkap'],
                    ['text'=>'Tidak Perlu Refraksi', 'value'=>'Tidak Perlu Refraksi'],
                    ['text'=>'Visus Kasar', 'value'=>'Visus Kasar'],
                ],
                'satuanWaktu'=>[
                    ['text'=>'Tahun', 'value'=>'Tahun'],
                    ['text'=>'Bulan', 'value'=>'Bulan'],
                    ['text'=>'Minggu', 'value'=>'Minggu'],
                    ['text'=>'Hari', 'value'=>'Hari'],
                ],
                'rangeWaktu'=>$rangeTime,
                'rangeDurasi'=>$rangeDurasi
            ],
            'status'=>[
                'yesNo'=>[
                    ['text'=>'Yes', 'value'=>'Yes'],
                    ['text'=>'No', 'value'=>'No'],
                ],
                'openClose'=>[
                    ['text'=>'Open', 'value'=>'Open'],
                    ['text'=>'Close', 'value'=>'Close'],
                ],
            ],
            'jenisSC'=>[
                ['text'=>'BCL', 'value'=>'BCL'],
                ['text'=>'NCT', 'value'=>'NCT'],
                ['text'=>'SPC', 'value'=>'SPC'],
            ],
            'gradeKatarak'=>[
                ['text'=>1, 'value'=>1],
                ['text'=>2, 'value'=>2],
                ['text'=>3, 'value'=>3],
                ['text'=>4, 'value'=>4],
                ['text'=>5, 'value'=>5],
                ['text'=>'Black/Hypermature', 'value'=>'Black/Hypermature'],
                ['text'=>'Post Op', 'value'=>'Post Op'],
                ['text'=>'Ops Luar', 'value'=>'Ops Luar'],
            ],

        ];
        $rsbModel = [
            'nextVisit'=>[
                'jenis'=>'',
                'waktu'=>1,
                'satuanWaktu'=>'Hari',
                'keterangan'=>''
            ],
            'durasiOp'=>[
                'durasiMenit'=>0
            ],
            'gradeKatarak'=>[
                'OS'=>'',
                'OD'=>''
            ],
            'infeksi'=>[
                'terjadiInfeksi'=>'',
                'kultur'=>'',
                'keterangan'=>'',
                'catatan'=>''
            ],
            'kondisiKhusus'=>[
                'jatuhTempo'=>'',
                'status'=>'',
                'jenisSC'=>'',
                'keterangan'=>''
            ],

        ];
        $rsbTemplate = file_get_contents( resource_path('views/clinic/patient/sidebar.html') );

        $this->right_sidebar_data = [];
        $this->right_sidebar_template = "`".$rsbTemplate."`";
        $this->right_sidebar_model = $rsbModel;
        $this->right_sidebar_params = $rsbParams;

        $diagnosaFields = [
            ['key'=>'mata', 'label'=>'Mata'],
            ['key'=>'icdx', 'label'=>'ICD-X'],
        ];

        $diagnosaObjDef = ['mata'=>'', 'icdx'=>''];
        $diagnosaParams = [
            'mataoptions'=>[
                ['text'=>'OD', 'value'=>'OD'],
                ['text'=>'OS', 'value'=>'OS'],
                ['text'=>'ODS', 'value'=>'ODS'],
            ],
            'icdxDefault'=>$diagnosaObjDef,
            'icdxUrl'=>url('api/v1/core/icdx'),
        ];

        $diagnosaContent = [];
        $diagnosaTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_diagnosa_form.html') )."`";


        $terapiObatObjDef = [
            'namaObat'=>'',
            'namaObatTeks'=>'',
            'aturanPakai'=>'',
            'aturanPakaiTeks'=>'',
            'mata'=>'',
            'icdx'=>'',
            'jumlah'=>0,
            'keterangan'=>''
        ];

        $terapiObatParams = [
            'mataoptions'=>[
                ['text'=>'OD', 'value'=>'OD'],
                ['text'=>'OS', 'value'=>'OS'],
                ['text'=>'ODS', 'value'=>'ODS'],
            ],
            'icdxDefault'=>$terapiObatObjDef,
            'icdxUrl'=>url('api/v1/core/icdx'),
            'jenisObatUrl'=>url('api/v1/core/obat'),
            'aturanPakaiUrl'=>url('api/v1/core/aturanpakai'),
        ];


        $terapiObatContent = [];
        $terapiObatTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_terapi_obat_form.html') )."`";

        $terapiNonObatContent = [];



        $pemeriksaanAwalTemplate = "`".file_get_contents( resource_path('views/clinic/patient/konsul_pemeriksaan_awal.html') )."`";

        $opInformasiTemplate = "`".file_get_contents( resource_path('views/clinic/patient/op_informasi.html') )."`";

        $uiOptions = [
            'diagnosaFields'=>$diagnosaFields,
            'diagnosaParams'=>$diagnosaParams,
            'diagnosaContent'=>json_encode($diagnosaContent),
            'diagnosaTemplate'=>$diagnosaTemplate,
            'diagnosaObjDef'=>json_encode($diagnosaObjDef),

            'terapiObatFields'=>$terapiObatFields,
            'terapiObatParams'=>$terapiObatParams,
            'terapiObatTemplate'=>$terapiObatTemplate,
            'terapiObatObjDef'=>json_encode($terapiObatObjDef),
            'terapiObatContent'=>$terapiObatContent,

            'terapiNonObatContent'=>$terapiNonObatContent,


            'tabViewTemplate'=> "`".$tabContentTemplate."`",
            'popviewContentTemplate'=> "`".$popviewContentTemplate."`",
            'pemeriksaanAwalTemplate'=>$pemeriksaanAwalTemplate,
            'opInformasiTemplate'=>$opInformasiTemplate,
            'contentTabs'=>[],

        ];



        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->js_load_transform = 'clinic.patient.op_js_load_transform';

        $this->js_post_transform = 'clinic.patient.op_js_post_transform';

        $this->js_tab_change = 'clinic.patient.konsul_js_tab_change';

        $this->js_pop_open = 'clinic.patient.konsul_js_pop_open';

        $this->aux_data['patientData'] = '{}';

        return parent::formGenerator();
    }

}
