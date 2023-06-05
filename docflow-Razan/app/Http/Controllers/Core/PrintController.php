<?php
/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 13/11/19
 * Time: 21.43
 */
namespace App\Http\Controllers\Core;

use App\Helpers\AuthUtil;
use App\Helpers\Util;
use App\Http\Controllers\Core\AdminController;
use App\Models\Core\Mongo\User;
use App\Models\Core\Mongo\Role;
use App\Models\Core\PrintCache;
use App\Models\Export\ViewExport;
use App\Models\Obj\AclObject;
use App\Models\Obj\PrintTemplate;
use Flynsarmy\DbBladeCompiler\Facades\DbView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use koolreport\instant\Exporter;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use WeasyPrint\WeasyPrint;

class PrintController extends PublicController
{
    /**
     * UserController constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->res_path = 'views/core/role';
        $this->yml_file = 'fields';

        $this->entity = 'Print';

        $this->model = new Role();

    }

    public function getPrint($templateslug, $id )
    {
        $data = PrintCache::find($id);

        if(PrintTemplate::where('slug', '=', $templateslug)->count() > 0 ){
            $template = PrintTemplate::where('slug', '=', $templateslug)->first();
        }else{
            $template = PrintTemplate::where('slug', '=', 'default')->first();
        }

        $pageSize = $template->pageSize ?? 'A4 portrait';
        $headerFooterSetting = $template->headerFooterSetting ?? [];
        $headerSetting = $template->headerSetting ?? [];
        $footerSetting = $template->footerSetting ?? [];
        $numberSetting = $template->numberSetting ?? [];
        $numberFormat = $template->numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)";
        $numberPosition = $template->numberPosition ?? 'Right';
        $firstNumberPosition = $template->firstNumberPosition ?? 'Right';

        if( $data && $template){
            \Debugbar::disable();
            $html = DbView::make($template)->field('template')
                ->with($data->toArray())
                ->with('pageSize', $pageSize )
                ->with('headerFooterSetting', $headerFooterSetting )
                ->with('headerSetting', $headerSetting )
                ->with('footerSetting', $footerSetting )
                ->with('numberSetting', $numberSetting )
                ->with('numberFormat', $numberFormat )
                ->with('numberPosition', $numberPosition )
                ->with('firstNumberPosition', $firstNumberPosition )
                ->render();

            $site = url('/');
            debug($site);

            if(env('PRINT_AS_PDF', false)){
                if( strpos($site,'localhost') || strpos($site,'127.0.0.1') ){

                }else{
                    $html = str_replace( $site, 'http://localhost', $html );
                }
            }

            return $html;
        }else{
            return 'Template not found';
        }
    }

    public function getPdf($templateslug, $id )
    {
        $data = PrintCache::find($id);

        if(PrintTemplate::where('slug', '=', $templateslug)->count() > 0 ){
            $template = PrintTemplate::where('slug', '=', $templateslug)->first();
        }else{
            $template = PrintTemplate::where('slug', '=', 'default')->first();
        }

        $pageSize = $template->pageSize ?? '';
        $headerFooterSetting = $template->headerFooterSetting ?? [];

        $marginTop = $template->marginTop ?? '45mm';
        $marginLeft = $template->marginLeft ?? '10mm';
        $marginRight = $template->marginRight ?? '10mm';
        $marginBottom = $template->marginBottom ?? '20mm';

        $headerSetting = $template->headerSetting ?? [];
        $footerSetting = $template->footerSetting ?? [];
        $numberSetting = $template->numberSetting ?? [];
        $numberFormat = $template->numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)";
        $numberPosition = $template->numberPosition ?? 'Right';
        $firstNumberPosition = $template->firstNumberPosition ?? 'Right';

        if( $data && $template){

            \Debugbar::disable();

            $html = DbView::make($template)->field('template')
                ->with($data->toArray())
                ->with('pageSize', $pageSize )
                ->with('headerFooterSetting', $headerFooterSetting )
                ->with('marginTop', $marginTop )
                ->with('marginLeft', $marginLeft )
                ->with('marginRight', $marginRight )
                ->with('marginBottom', $marginBottom )
                ->with('headerSetting', $headerSetting )
                ->with('footerSetting', $footerSetting )
                ->with('numberSetting', $numberSetting )
                ->with('numberFormat', $numberFormat )
                ->with('numberPosition', $numberPosition )
                ->with('firstNumberPosition', $firstNumberPosition )
                ->render();

//            $header = DbView::make($template)->field('headRight')->with($data->toArray())->render();
//
//            $fpath = 'exports/'.$templateslug.'_fmt_'.date('Y_m_d_H_i_s', time());

            $site = url('/');

            if( strpos($site,'localhost') || strpos($site,'127.0.0.1') ){

            }else{
                $html = str_replace( $site, 'http://localhost', $html );
            }

            //$html = '<h5>Hello</h5>';
            //$pdf = App::make('dompdf.wrapper');
            //$pdf->loadHTML($html);
            //return $pdf->stream();

            /**
             * Weasyprint
             * This is the best so far
             *
             */
            $weasyprint = WeasyPrint::make($html);

            return $weasyprint->inline($templateslug.'.pdf');

            /**
             * Snappy
             * pretty fast but cannot read @page css
             */
            //$snappy = App::make('snappy.pdf.wrapper');
            //$headUrl = url( 'page-header/'.$templateslug.'/'.$id );
            //return $snappy->loadHTML($html)
            //    //->setOption('header-html', $headUrl)
            //    ->setOption('header-line', true)
            //    ->setOption('footer-right', 'Page [page] of [topage]')
            //    //->setOption('header-html', $header)
            //    ->inline($templateslug.'_'.$id.'.pdf');

//            $temp_dir = sys_get_temp_dir();
//            $filename = $temp_dir.'/'.$templateslug.'_'.$id.'.html';
//
//            file_put_contents( $filename, $html );
//            Exporter::export($filename)
//                ->pdf([])
//                ->toBrowser($templateslug.'_'.$id.'.pdf');

        }else{
            return 'Template not found';
        }
    }

    public function getPageHeader($templateslug, $id )
    {
        $data = PrintCache::find($id);

        debug('template-data');
        debug($data->toArray());

        $template = PrintTemplate::where('slug', '=', $templateslug)->first();

        if( $data && $template){
            \Debugbar::disable();
            $header = DbView::make($template)->field('headRight')->with($data->toArray())->render();
            return $header;
        }else{
            return 'Template not found';
        }
    }

}
