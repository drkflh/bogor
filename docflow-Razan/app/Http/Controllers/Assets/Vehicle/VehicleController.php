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
use App\Models\Assets\Vehicle;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Vehicle();
    }

    public function getIndex()
    {
        $this->title = 'Vehicle';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'assets';
        $this->res_path = 'views/assets/vehicle';
        $this->yml_file = 'fields';

        /* YML for custom form layout */
        //$this->yml_layout_file = 'layout';

        /* YML for custom page navigation */
        //$this->nav_file = 'nav';
        //$this->nav_path = 'views/clinic/patient';

        $this->template_var = [ 'hasSideNav'=>true ];

        $this->data_url = 'assets/vehicle';

        $this->add_url = 'assets/vehicle/add';

        $this->update_url = 'assets/vehicle/edit';

        $this->del_url = 'assets/vehicle/del';

        $this->item_data_url = 'assets/vehicle/data';

        $this->del_url = 'assets/vehicle/del';

        $this->clone_url = 'assets/vehicle/clone';

        $this->download_url = 'assets/vehicle/dlxl';

        $this->can_add = true;

        $this->can_upload = true;

        $this->can_download_xls = true;

        $this->can_download_csv = true;

        $this->import_commit_url = 'assets/vehicle/commit';

        $this->logo = env('APP_LOGO');

        /* Use custom form layout */
        $this->form_view = 'form.flatgrid';

        $this->grid = [
            ['col'=>[4,4,4]]
        ];

        $this->table_slot_view = 'assets.vehicle.tableslot';

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

    /*  Example External data interceptopr
     *
     *
     * */
    public function externalData($data, $request)
    {
        /* dev param only */
        // $doccd= 'KMN05-AWI01';
        // $visdt='2019-11-01';
        // $result = KmnUtil::getDoctorPatient($doccd, $visdt);
        // $plist = json_decode( $result->getBody()->getContents(), true );
        // $data = $plist['results'];
        // for($i=0;$i < count($plist);$i++){
        //     if(isset($data[$i])){
        //         $data[$i]['_id'] = $data[$i]['patSingleId'];
        //     }
        // }

        return parent::externalData($data, $request); // TODO: Change the autogenerated stub
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

    public function getOp($id){

        $this->nav_section = 'users';
        $this->yml_file = 'op';
        $this->res_path = 'views/clinic/patient';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/clinic/patient';
        $this->logo = env('APP_LOGO');

        $patient = User::find($id);

        $this->title = $patient->name;

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

        $this->data['auxData'] = array_merge( $uiOptions ,$formOptions);

        return parent::formGenerator();
    }

}
