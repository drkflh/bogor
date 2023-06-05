<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 21/12/19
 * Time: 18.19
 */
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1/mobile','middleware'=>['api'] ], function (){

    \App\Helpers\Util::makeApiRoute('halal/halal-product', 'Api\Halal\HalalProductController');
    \App\Helpers\Util::makeApiRoute('halal/sponsor-program', 'Api\Halal\SponsorProgramController');
    \App\Helpers\Util::makeApiRoute('halal/sponsor-deposit', 'Api\Halal\SponsorDepositController');
    \App\Helpers\Util::makeApiRoute('halal/sponsor-voucher', 'Api\Halal\SponsorVoucherController');
    \App\Helpers\Util::makeApiRoute('halal/halal-certification', 'Api\Halal\HalalCertificationController');
    \App\Helpers\Util::makeApiRoute('halal/biz-profile', 'Api\Halal\BizProfileController');
    \App\Helpers\Util::makeApiRoute('halal/reference/asal-pelaku', 'Api\Halal\Reference\AsalPelakuController');
    \App\Helpers\Util::makeApiRoute('halal/reference/skala-usaha', 'Api\Halal\Reference\SkalaUsahaController');
    \App\Helpers\Util::makeApiRoute('halal/reference/jenis-badan-usaha', 'Api\Halal\Reference\JenisBadanUsahaController');
    \App\Helpers\Util::makeApiRoute('halal/reference/self-declare', 'Api\Halal\Reference\SelfDeclareController');
    \App\Helpers\Util::makeApiRoute('halal/reference/lembaga-pendamping', 'Api\Halal\Reference\lembagaPendampingController');
    \App\Helpers\Util::makeApiRoute('halal/reference/negara', 'Api\Halal\Reference\NegaraController');
    \App\Helpers\Util::makeApiRoute('halal/reference/area-pemasaran', 'Api\Halal\Reference\AreaPemasaranController');
    \App\Helpers\Util::makeApiRoute('halal/reference/provinsi', 'Api\Halal\Reference\ProvinsiController');
    \App\Helpers\Util::makeApiRoute('halal/reference/kabupaten', 'Api\Halal\Reference\KabupatenController');
    \App\Helpers\Util::makeApiRoute('halal/reference/kecamatan', 'Api\Halal\Reference\KecamatanController');
    \App\Helpers\Util::makeApiRoute('halal/reference/pendamping', 'Api\Halal\Reference\PendampingController');
    \App\Helpers\Util::makeApiRoute('halal/admin/owner-penyelia-profile', 'Api\Halal\Admin\OwnerPenyeliaProfileController');
	\App\Helpers\Util::makeApiRoute('halal/product-sertification', 'Api\Halal\ProductSertificationController');
	\App\Helpers\Util::makeApiRoute('halal/validator-profile', 'Api\Halal\ValidatorProfileController');
	\App\Helpers\Util::makeApiRoute('halal/permohonan-sertifikasi', 'Api\Halal\PermohonanSertifikasiController');

    \App\Helpers\Util::makeApiRoute('halal/funding-request', 'Api\Halal\FundingRequestController');

});

	\App\Helpers\Util::makeApiRoute('halal/funding-request', 'Api\Halal\FundingRequestController');
	\App\Helpers\Util::makeApiRoute('test/ctd', 'Api\Test\CtdController');
