<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/12/19
 * Time: 23.33
 */
namespace App\Http\Controllers\Dwf\Admin;

use App\Helpers\AuthUtil;
use App\Helpers\NumberUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Http\Controllers\Core\UserController;
use App\Models\Cms\Article;
use App\Models\Core\Mongo\Member;
use App\Models\Dwf\Doc;
use App\Models\Core\Mongo\User;
use App\Models\Dwf\Document;
use App\Models\Silani\MasterData\Lansia;
use App\Models\Silani\Request\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends AdminController
{
    public function __construct()
    {
        parent::__construct();

        $this->model = new Doc();
    }

    public function getIndex()
    {
        $this->title = 'Dashboard';

        $cname = substr(strrchr(get_class($this), '\\'), 1);
        $this->controller_name = str_replace('Controller', '', $cname);

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/dwf/admin/dashboard';

        $this->template_var = [ 'hasSideNav'=>false ];

        $this->can_add = true;

        $this->data_url = 'admin/fieldreport';

        $this->table_view = env('ADMIN_DASHBOARD_VIEW', 'trips.dashboard');

        return parent::getIndex();
    }

    public function getDashboard($id = null){

        $this->nav_section = 'users';
        $this->yml_file = 'fields';
        $this->res_path = 'views/dwf/admin/dashboard';
        $this->nav_file = 'nav';
        $this->nav_path = 'views/partials/app/dms';
        $this->yml_layout_file = 'tracking_layout';
        $this->logo = env('APP_LOGO');

        $user = User::find(trim($id));

        $this->title = 'Dashboard';

        $this->show_title = false;

        $this->data['_id'] = Util::makeDataModel( '_id', trim($id), 'text', 'text', trim($id) );

        $this->item_data_url = 'dwf/dashboard/data';

        $this->item_id = 1;

        $this->has_tab = false;

        $this->form_mode = 'edit';

        $this->form_view = 'form.htmlformpage';

        $this->form_type = 'html';

        $this->form_layout = 'dwf.admin.dashboard.dashboard';

        $this->page_refresh_button = true;

        $this->customLoader = 'this.$refs.cardResponse.updateChart();';

        $uiOptions = [
            'contentTabs'=>[],
        ];

        $formOptions = Util::loadResYaml($this->yml_file,$this->res_path)->toFormOption();

        $formOptions['circularBarOptionEfisiensi'] = [
            'chart'=>[
                'type'=>'radialBar'
            ],
            'plotOptions'=>[
                'radialBar'=>[
                    'startAngle'=> 0,
                    'hollow'=>[
                        'size'=>'65%',
                        'background'=> "white"
                    ]
                ]
            ],
            'stroke'=>[
                'lineCap'=>'round'
            ],
            'labels'=>['Efisiensi']
        ];
        $formOptions['circularBarOptionCancel'] = [
            'chart'=>[
                'type'=>'radialBar'
            ],
            'plotOptions'=>[
                'radialBar'=>[
                    'startAngle'=> 0,
                    'hollow'=>[
                        'size'=>'65%',
                        'background'=> "white"
                    ]
                ]
            ],
            'stroke'=>[
                'lineCap'=>'round'
            ],
            'labels'=>['Cancel']
        ];

        $this->aux_data = array_merge( $uiOptions ,$formOptions);

        return parent::formGenerator();
    }


    public function getData($id, $additional_data = null)
    {
        $auth = Auth::user();

        $genderTotal = 250;
        $totalLansia = 1500;
        $population['cardInfoLansia'] = [
            'thTable'=>['#', 'Provinsi', 'Total Lansia'],
            'thClass'=>['text-25', 'text-50', 'text-50'],
            'lansiaGender'=>$lansiaGender ?? [],
            'lansiaKotaCount'=>$lansiaKotaCount ?? [],
            'label'=>'Lansia',
            'totalUser'=>$genderTotal,
            'BtnView'=>'master-data/lansia',
            'detail'=>[
                ['las la-user-plus', 'Member Lansia Tercatat', $totalLansia],
            ]
        ];

        $timeSpan = [ Carbon::now(env('DEFAULT_TIME_ZONE'))->startOfMonth(), Carbon::now(env('DEFAULT_TIME_ZONE'))->endOfMonth() ];
        $inception = Document::orderBy('createdAt','asc')->first();
        $todate = Document::orderBy('createdAt', 'desc')->first();

        $thisMonthNotaDinas = Document::where('docType','=','nota-dinas')
            ->whereBetween( 'createdAt', $timeSpan )
            ->count();
        $thisMonthSuratDinas = Document::where('docType','=','surat-dinas')
            ->whereBetween( 'createdAt', $timeSpan )
            ->count();
        $thisMonthLembarDisposisi = Document::where('docType','=','lembar-disposisi')
            ->whereBetween( 'createdAt', $timeSpan )
            ->count();
        $thisMonthMemoInternal = Document::where('docType','=','memo-internal')
            ->whereBetween( 'createdAt', $timeSpan )
            ->count();

        $sysNotaDinas = Document::where('docType','=','nota-dinas')->count();
        $sysSuratDinas = Document::where('docType','=','surat-dinas')->count();
        $sysLembarDisposisi = Document::where('docType','=','lembar-disposisi')->count();
        $sysMemoInternal = Document::where('docType','=','memo-internal')->count();

        $notaDinas = Document::where('docType','=','nota-dinas');
        $suratDinas = Document::where('docType','=','surat-dinas');
        $lembarDisposisi = Document::where('docType','=','lembar-disposisi');
        $memoInternal = Document::where('docType','=','memo-internal');

        if(!AuthUtil::isAdmin()){
            $notaDinas = $notaDinas->where('ownerId','=', Auth::user()->_id);
            $suratDinas = $suratDinas->where('ownerId','=', Auth::user()->_id);
            $lembarDisposisi = $lembarDisposisi->where('ownerId','=', Auth::user()->_id);
            $memoInternal = $memoInternal->where('ownerId','=', Auth::user()->_id);
        }

        $totalNotaDinas = $notaDinas->count();
        $totalSuratDinas = $suratDinas->count();
        $totalDisposisi = $lembarDisposisi->count();
        $totalMemoInternal = $memoInternal->count();

        $notaDinasApproved = Document::where('docType','=','nota-dinas')->where('docStatus','=','RELEASED');
        $suratDinasApproved = Document::where('docType','=','surat-dinas')->where('docStatus','=','RELEASED');
        $lembarDisposisiApproved = Document::where('docType','=','lembar-disposisi')->where('docStatus','=','RELEASED');
        $memoInternalApproved = Document::where('docType','=','memo-internal')->where('docStatus','=','RELEASED');

        if(!AuthUtil::isAdmin()){
            $notaDinasApproved = $notaDinasApproved->where('ownerId','=', Auth::user()->_id);
            $suratDinasApproved = $suratDinasApproved->where('ownerId','=', Auth::user()->_id);
            $lembarDisposisiApproved = $lembarDisposisiApproved->where('ownerId','=', Auth::user()->_id);
            $memoInternalApproved = $memoInternalApproved->where('ownerId','=', Auth::user()->_id);
        }

        $totalNotaDinasApproved = $notaDinasApproved->count();
        $totalSuratDinasApproved = $suratDinasApproved->count();
        $totalDisposisiApproved = $lembarDisposisiApproved->count();
        $totalMemoInternalApproved = $memoInternalApproved->count();

        $totalNotaDinasPct = $totalNotaDinas == 0 ? 0 : ( $totalNotaDinasApproved / $totalNotaDinas ) * 100;
        $totalSuratDinasPct = $totalSuratDinas == 0 ? 0 : ( $totalSuratDinasApproved / $totalSuratDinas ) * 100;
        $totalDisposisiPct = $totalDisposisi == 0 ? 0 : ( $totalDisposisiApproved / $totalDisposisi ) * 100;
        $totalMemoInternalPct = $totalMemoInternal == 0 ? 0 : ( $totalMemoInternalApproved / $totalMemoInternal ) * 100;

        $population['cardRequestTotal'] = [
            'labelSuratDinas'=>'Surat Dinas',
            'thisMonthSuratDinas'=>'<span style="font-size: 14pt;">Bulan Ini </span>'.$thisMonthSuratDinas.'</span>',
            'totalSuratDinas'=>$totalSuratDinasApproved,
//            'totalSuratDinas'=>$totalSuratDinasApproved.' <span style="font-size: 18pt;" >( '.( number_format( $totalSuratDinasPct , 0, ',', '.') ).'% )</span>',
            'sysSuratDinas'=>'<span style="font-size: 14pt;">Total </span>'.$sysSuratDinas,
            'labelNotaDinas'=>'Nota Dinas',
            'thisMonthNotaDinas'=>'<span style="font-size: 14pt;">Bulan Ini </span>'.$thisMonthNotaDinas,
            'totalNotaDinas'=>$totalNotaDinasApproved,
//            'totalNotaDinas'=>$totalNotaDinasApproved.' <span style="font-size: 14pt;" >( '.( number_format( $totalNotaDinasPct , 0, ',', '.') ).'% )</span>',
            'sysNotaDinas'=>'<span style="font-size: 14pt;">Total </span>'.$sysNotaDinas,
            'labelDisposisi'=>'Disposisi',
            'thisMonthDisposisi'=>'<span style="font-size: 14pt;">Bulan Ini </span>'.$thisMonthLembarDisposisi.'</span>',
            'totalDisposisi'=>$totalDisposisiApproved,
//            'totalDisposisi'=>$totalDisposisiApproved.' <span style="font-size: 14pt;" >( '.( number_format( $totalDisposisiPct , 0, ',', '.') ).'% )</span>',
            'sysLembarDisposisi'=>'<span style="font-size: 14pt;">Total </span>'.$sysLembarDisposisi,
            'labelMemo'=>'Memo Internal',
            'thisMonthMemo'=>'<span style="font-size: 14pt;">Bulan Ini </span>'.$thisMonthMemoInternal.'</span>',
            'totalMemo'=>$totalMemoInternalApproved,
//            'totalMemo'=>$totalMemoInternalApproved.' <span style="font-size: 14pt;" >( '.( number_format( $totalMemoInternalPct , 0, ',', '.') ).'% )</span>',
            'sysMemoInternal'=>'<span style="font-size: 14pt;">Total </span>'.$sysMemoInternal,

        ];

        $age = Carbon::make($inception->createdAt)->diffInDays( Carbon::make($todate->createdAt) );

        $totalCm = Document::whereBetween( 'createdAt', $timeSpan )->count();
        $totalLn = Document::where('docType','=','nota-dinas')
                    ->orWhere('docType','=','surat-dinas')
                    ->orWhere('docType','=','lembar-disposisi')
                    ->orWhere('docType','=','memo-internal')
                    ->count();
        $totalAd = Document::count() / $age;
        $population['cardRequestTotalByRole'] = [
            'title'=>['Case Manager', 'Lansia', 'Admin'],
            'totalCm'=>$totalCm,
            'totalLn'=>$totalLn,
            'totalAd'=> number_format($totalAd) ,
        ];
        $percentEfisiensi = 23;
        $percentCancel = 76;
        $population['cardEfisiensi'] = [
            'percentEfisiensi'=>$percentEfisiensi,
            'percentCancel'=>$percentCancel,
        ];
        $caseManager = 23;
        $handleLansia = 100;
        $population['infoCaseManager'] = [
            'label'=>'Case Manager',
            'totalUser'=>$caseManager,
            'BtnView'=>'user-management/case-manager',
            'thTable'=>['#', 'Avatar', 'Case Manager', 'Lansia', 'Permintaan Hari Ini', 'Permintaan Bulan Ini', 'Rata-rata Permintaan Perbulan'],
            'thClass'=>['text-25'],
            'tdTable'=>$handleLansia,
        ];
        $article = null;
        $population['cardArticle'] = [
            'data'=>$article,
        ];
        $population['cardPendidikan'] = [
            'title'=>'Pendidikan',
            'pendidikanLansiaCount'=>$lansiaPendidikanCount ?? [],
        ];
        $population['cardLayanan'] = [
            'title'=>'Grafik Layanan',
        ];
        $population['cardAge'] = [
            'title'=>'Rentang Usia Lansia',
            'lansiaUsiaCount'=> $lansiaUsiaCount ?? [],
        ];
        $population['cardResponse'] = [
            'title'=>'Naskah dalam 1 Bulan',
        ];

        if(Auth::check()){
            return response()->json($population, 200);
        }else{
            return response('Unauthorized', 401);
        }
    }

    public function getTransaksi()
    {
        $a = Carbon::now()->startOfMonth()->toDateString();
        $b = Carbon::now()->endOfMonth()->toDateString();
        $startMonth = Carbon::parse($a);
        $endMonth = Carbon::parse($b);
        $permintaanBulanIni = Document::where('docType','=','nota-dinas')
            ->orWhere('docType','=','surat-dinas')
            ->orWhere('docType','=','lembar-disposisi')
            ->orWhere('docType','=','memo-internal')
            ->whereBetween('createdAt',[$startMonth, $endMonth])->groupBy('createdAt')->orderBy('createdAt', 'asc')->get();

        $jumlah = $permintaanBulanIni->transform(function($item){
            $item->createdAt = date('Y-m-d', strtotime($item->createdAt));
            return $item;
        })->groupBy('createdAt');

        $data = [];
        foreach ($jumlah as $key => $p){
            $key = Carbon::make($key)->format('d M Y');
            $data[$key] = $p->count();

        }
        return response()->json($data);

    }



    public function postIndex(Request $request)
    {
        $this->defOrderField = 'createdDate';
        $this->defOrderDir = 'desc';

        return parent::postIndex($request); // TODO: Change the autogenerated stub
    }

    public function additionalQuery($model, Request $request)
    {
        return $model;
    }

    public function beforeSave($data)
    {
        $data['roleId'] = AuthUtil::getRoleId('Employee');
        return parent::beforeSave($data); // TODO: Change the autogenerated stub
    }

}
