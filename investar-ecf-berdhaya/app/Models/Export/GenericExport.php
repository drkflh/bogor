<?php
namespace App\Models\Export;
use App\Helpers\TimeUtil;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 25/11/19
 * Time: 21.04
 */
class GenericExport implements FromArray, WithHeadings
{
    use Exportable;

    protected $model;
    protected $limit;
    protected $page;
    protected $headings;
    protected $timefields;
    protected $entity;

    public function __construct($model, $limit = 10000, $page = 0, $headings = [], $timefields = [], $entity )
    {
        $this->model = $model;
        $this->limit = $limit;
        $this->page = $page;
        $this->headings = $headings;
        $this->timefields = $timefields;
        $this->entity = $entity;
    }

    public function array(): array
    {
        $skip = $this->limit * intval($this->page);
        $result = $this->model->take($this->limit)->skip($skip)->get();

        $out = [];

        foreach($result as $r){
            $items = [];
            $hid = 0;
            foreach ($this->headings as $h){
                if( in_array($h , $this->timefields)){
                    $item  =  TimeUtil::out( Carbon::make($r->{$h}) , $this->entity, $h );
                }else{
                    $item = $r->{$h} ?? "";
                }
                $items[$hid] = $item;
                $hid++;
            }
            $out[] = $items;
        }


        return $out;
    }

    public function headings(): array
    {
        if(empty($this->headings)){

            $h = $this->model->first();
            if($h){
                $heads = array_keys( $h->toArray() );
                return $heads;
            }else{
                return [];
            }

        }else{
            return $this->headings;
        }

    }
}
