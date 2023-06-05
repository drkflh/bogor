<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.19
 */
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/member','middleware'=>['api'] ], function (){
    \App\Helpers\Util::makeApiRoute('data', 'Api\Core\MemberController');
    \App\Helpers\Util::makeApiRoute('lansia', 'Api\Silani\MemberLansia\LansiaController');
    \App\Helpers\Util::makeApiRoute('profile', 'Api\Silani\MemberLansia\LansiaController');
    \App\Helpers\Util::makeApiRoute('penilaian-pengguna', 'Api\Silani\MemberLansia\PenilaianPenggunaController');

    \App\Helpers\Util::makeApiRoute('program-bansos', 'Api\Silani\MemberLansia\ProgramBansosController');

    \App\Helpers\Util::makeApiRoute('program-kegiatan', 'Api\Silani\MemberLansia\ProgramKegiatanController');
    \App\Helpers\Util::makeApiRoute('peserta-kegiatan', 'Api\Silani\MemberLansia\PesertaKegiatanController');

    \App\Helpers\Util::makeApiRoute('permintaan-fasilitas', 'Api\Silani\MemberLansia\PermintaanFasilitasController');
    \App\Helpers\Util::makeApiRoute('permintaan-homecare', 'Api\Silani\MemberLansia\PermintaanHomeCareController');

});

Route::group(['prefix' => 'v1/case','middleware'=>['api'] ], function (){
    \App\Helpers\Util::makeApiRoute('member', 'Api\Silani\MemberCaseController');
    \App\Helpers\Util::makeApiRoute('lansia', 'Api\Silani\CaseManager\LansiaController');

    \App\Helpers\Util::makeApiRoute('laporan-lapangan', 'Api\Silani\CaseManager\LaporanLapanganController');

    \App\Helpers\Util::makeApiRoute('program-bansos', 'Api\Silani\CaseManager\ProgramBansosController');
    \App\Helpers\Util::makeApiRoute('peserta-bansos', 'Api\Silani\CaseManager\PesertaBansosController');

    \App\Helpers\Util::makeApiRoute('program-kegiatan', 'Api\Silani\CaseManager\ProgramKegiatanController');
    \App\Helpers\Util::makeApiRoute('peserta-kegiatan', 'Api\Silani\CaseManager\PesertaKegiatanController');

    \App\Helpers\Util::makeApiRoute('permintaan-fasilitas', 'Api\Silani\CaseManager\PermintaanFasilitasController');
    \App\Helpers\Util::makeApiRoute('permintaan-homecare', 'Api\Silani\CaseManager\PermintaanHomeCareController');

});

Route::group(['prefix' => 'v1/content','middleware'=>['api'] ], function (){
    \App\Helpers\Util::makeApiRoute('berita', 'Api\Silani\Content\BeritaController');
    \App\Helpers\Util::makeApiRoute('tips', 'Api\Silani\Content\TipsController');
});
	\App\Helpers\Util::makeApiRoute('sms/reference/incoterm', 'Api\sms\reference\IncotermController');
