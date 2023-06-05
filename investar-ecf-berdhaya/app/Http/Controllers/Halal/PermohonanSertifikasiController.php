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
use App\Helpers\RefUtil;
use App\Helpers\Util;
use App\Helpers\Injector;
use App\Http\Controllers\Core\AdminController;
use App\Models\Halal\PermohonanSertifikasi;
use App\Models\Core\Mongo\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PermohonanSertifikasiController extends AdminController

{
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'models/controllers/halal';

        $this->yml_file = 'permohonansertifikasi_controller';

        $this->entity = 'Permohonan Sertifikasi';

        $this->auth_entity = 'permohonan-sertifikasi';

        $this->controller_base = 'halal/permohonan-sertifikasi';

        $this->view_base = 'halal.permohonansertifikasi';

        $this->model = new PermohonanSertifikasi();
    }

    public function getIndex()
    {
        $this->title = 'Permohonan Sertifikasi';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);
        $this->show_title = true;
        /**
        * Set form layout
        */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.permohonansertifikasi.form_layout';
        $this->form_dialog_size = 'xl';

        /**
        * Set Viewer layout
        */
        $this->viewer_layout = 'halal.permohonansertifikasi.view_layout';
        $this->viewer_dialog_size = 'xl';

        $this->runAcl();
        $this->runUrlSet();
        $this->runViewSet();
        $this->runMoreMenu();

        $this->add_as_page = true;
        $this->edit_as_page = true;
        $this->with_advanced_search = false;

        $this->add_filler = true;

        return parent::getIndex();
    }

    
    public function setupInjector($uiOptions, $data = null)
    {

        $uiOptions = Injector::setObject('bizOutlets') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [   
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama Outlet', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Alamat', 'key'=>'alamat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Kab/Kota', 'key'=>'kab_kota', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Provinsi', 'key'=>'provinsi', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Negara', 'key'=>'negara ', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Kode Pos', 'key'=>'kode_pos', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [   
                'id_pu'=>'',
                'nama'=>'',
                'alamat'=>'',
                'kab_kota'=>'',
                'provinsi'=> '',
                'negara'=>'',
                'kode_pos'=> ''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('halal.permohonansertifikasi.outlet')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('bizFactories') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [   
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama Pabrik', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Alamat', 'key'=>'alamat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Kab/Kota', 'key'=>'kab_kota', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Provinsi', 'key'=>'provinsi', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Negara', 'key'=>'negara', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Kode Pos', 'key'=>'kode_pos', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Status', 'key'=>'status_milik', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [   
                'id_pu'=>'',
                'nama'=>'',
                'alamat'=>'',
                'kab_kota'=>'',
                'provinsi'=> '',
                'negara'=>'',
                'kode_pos'=> '',
                'status_milik'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('halal.permohonansertifikasi.factories')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('businessBizLegality') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [   
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Jenis', 'key'=>'jenis_surat', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Jenis Surat Lainnya', 'key'=>'jenis_surat_lainnya', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'No Surat', 'key'=>'no_surat', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'Tanggal', 'key'=>'tgl_surat', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Masa Berlaku', 'key'=>'masa_berlaku', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'Instansi Penerbit', 'key'=>'instansi_penerbit', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [   
                'id_pu'=>'',
                'jenis_surat'=>'',
                'jenis_surat_lainnya'=>'',
                'no_surat'=>'',
                'tgl_surat'=>'',
                'masa_berlaku'=> '',
                'instansi_penerbit'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('halal.permohonansertifikasi.aspeklegal')->render()) // set template
        ->injectObject($uiOptions);

        $uiOptions = Injector::setObject('businessBizPenyelia') // name variable / field yang akan diinject
        ->setObjFields( // mwnambahkan setting field untuk table
            [   
                [ 'label'=>'Id PU', 'key'=>'id_pu', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Nama', 'key'=>'nama', 'class'=>'text-70' , 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'No KTP', 'key'=>'no_ktp', 'class'=>'text-70', 'type'=>'String', 'validator'=>'required'  ],
                [ 'label'=>'No. SK Penyelia', 'key'=>'no_sertifikat', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Tgl SK', 'key'=>'tgl_sertifikat', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'No Sk', 'key'=>'no_sk', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Tgl SK ', 'key'=>'tgl_sk', 'class'=>'text-70', 'type'=>'String' , 'validator'=>''  ],
                [ 'label'=>'Kontak', 'key'=>'no_kontak', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ],
                [ 'label'=>'KTP', 'key'=>'file_ktp', 'class'=>'text-70 text-center', 'type'=>'String' , 'validator'=>'required'  ],
                [ 'label'=>'Agama', 'key'=>'agama', 'class'=>'text-70 text-center', 'type'=>'string', 'validator'=>'required'  ]
            ]
        )->setObjDef( // set object default
            [   
                'id_pu'=>'',
                'nama'=>'',
                'no_ktp'=>'',
                'no_sertifikat'=>'',
                'tgl_sertifikat'=> '',
                'no_sk'=>'',
                'tgl_sk'=>'',
                'no_kontak'=> '',
                'file_ktp'=>'',
                'agama'=>''
            ]
        )->setObjParams(
            [
                // 'uom' => $formOptions['uomOptions'] = RefUtil::toOptions(RefUtil::getUom(),'uom','uom', false),
            ]
        )
        ->setObjTemplate(view('halal.permohonansertifikasi.penyeliahalal')->render()) // set template
        ->injectObject($uiOptions);

        return parent::setupInjector($uiOptions, $data); // TODO: Change the autogenerated stub
    }

    public function setupFormOptions($formOptions, $data = null)
    {
        // $formOptions['businessBizCompanytType'] = RefUtil::toOptions(RefUtil::getCompanyTypes(),'companyType','companyType', false);
        $formOptions['businessBizIdTypeOptions'] = [
            ['text'=>'NIB', 'value'=>'NIB'],
            ['text'=>'NIK', 'value'=>'NIK']
        ];
        $formOptions['businessBizContactWAOptions'] = [
            ['text'=>'+62', 'value'=>'+62']
        ];

        return parent::setupFormOptions($formOptions, $data); // TODO: Change the autogenerated stub
    }

    public function getAdd(Request $request, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->title = __($this->entity);

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.permohonansertifikasi.form_layout';

        $this->runAcl();
        $this->runUrlSet('add');
        $this->runPageViewSet('add');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        return parent::getAdd($request, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getEdit(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('Edit').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->form_layout = 'halal.permohonansertifikasi.form_layout';

        $this->runAcl();
        $this->runUrlSet('edit');
        $this->runPageViewSet('edit');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        $this->page_redirect_after_save = true;

        $this->page_class = 'col-lg-6 col-md-10 col-xs-12';

        $this->bottom_action = true;

        $this->save_button_label = 'Next';

        return parent::getEdit($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function getView(Request $request, $id, $keyword0 = null, $keyword1 = null, $keyword2 = null)
    {
        $this->view_title_fields = $this->entity;

        $item = $this->model->find($id);

        $this->item_id = $item->_id;

        $this->title = __('View').' '.$this->entity;

        /* Use custom form layout */
        $this->form_view = 'form.html'; // use plain html
        $this->viewer_layout = 'halal.permohonansertifikasi.view_layout';

        $this->runAcl();
        $this->runUrlSet('view');
        $this->runPageViewSet('view');

        $uiOptions = [];

        $uiOptions = $this->setupInjector($uiOptions);

        $formOptions = Util::loadResYaml($this->yml_file, $this->res_path)->toFormOption();

        $formOptions = $this->setupFormOptions($formOptions);

        $this->aux_data = array_merge( $uiOptions ,$formOptions);
        return parent::getView($request, $id, $keyword0, $keyword1, $keyword2); // TODO: Change the autogenerated stub
    }

    public function postClone(Request $request)
    {
        $this->revision_key = 'requestNo';
        return parent::postClone($request);
    }

    public function postIndex(Request $request)
    {
//        $this->defOrderField = 'Item';
//        $this->defOrderDir = 'asc';
        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        /* sample query modifier */
        //$model = $model->where('roleId','=', AuthUtil::getRoleId('Employee') );
        if( AuthUtil::isAdmin() ){

        }else{
            $model = $model->where('ownerId', '=', Auth::user()->_id );
        }
        return $model;
    }

    public function beforeSave($data)
    {
        /* sample callback / hook */
        //$data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data);
    }

    public function beforeUpdateForm($population)
    {
        return parent::beforeUpdateForm($population); // TODO: Change the autogenerated stub
    }

    public function beforeUpdate($id, $data)
    {

        return parent::beforeUpdate($id, $data); // TODO: Change the autogenerated stub
    }

    public function getParam()
    {

        return parent::getParam(); // TODO: Change the autogenerated stub
    }

    protected function rowPostProcess($row)
    {

        return parent::rowPostProcess($row);
    }

}