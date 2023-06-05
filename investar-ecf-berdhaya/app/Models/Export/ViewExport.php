<?php
namespace App\Models\Export;
use App\Helpers\TimeUtil;
use Carbon\Carbon;
use Flynsarmy\DbBladeCompiler\Facades\DbView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 25/11/19
 * Time: 21.04
 */
class ViewExport implements FromView
{
    use Exportable;

    protected $data;
    protected $template;
    protected $pageSize;

    public function __construct($template , $data, $pageSize )
    {
        $this->template = $template;
        $this->data = $data;
        $this->pageSize = $pageSize;
    }

    public function view(): View
    {
        return DbView::make($this->template)
            ->field('template')
            ->with('pageSize', $this->pageSize )
            ->with($this->data);
    }

}
