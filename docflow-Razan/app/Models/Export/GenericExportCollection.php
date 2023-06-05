<?php
namespace App\Models\Export;
use App\Helpers\TimeUtil;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
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
class GenericExportCollection implements FromCollection, WithHeadings, ShouldQueue
{
    use Exportable;

    protected $collection_name;
    protected $connection_name;
    protected $limit;
    protected $page;
    protected $headings;
    protected $timefields;
    protected $entity;

    public function __construct( $collection_name, $connection_name , $headings, $limit = 0, $page = 0,$timefields = [], $entity = '' )
    {
        $this->collection_name = $collection_name;
        $this->connection_name = $connection_name;
        $this->headings = $headings;
        $this->timefields = $timefields;
        $this->limit = $limit;
        $this->page = $page;
        $this->entity = $entity;
    }

    public function collection(): Collection
    {

        if($this->limit == 0){
            $result = DB::connection($this->connection_name)->table($this->collection_name)
                ->get() ;
        }else{
            $skip = $this->limit * intval($this->page);
            $result = DB::connection($this->connection_name)->table($this->collection_name)
                ->take($this->limit)
                ->skip($skip)
                ->get() ;
        }

//        $out = [];
//
//        foreach($result as $r){
//            $items = [];
//            $hid = 0;
//            foreach ($this->headings as $h){
//                if( !empty( $this->timefields) && in_array($h , $this->timefields)){
//                    $item  =  TimeUtil::out( Carbon::make($r->{$h}) , $this->entity, $h );
//                }else{
//                    $item = $r->{$h} ?? "-";
//                }
//                $items[$hid] = $item;
//                $hid++;
//            }
//            $out[] = $items;
//        }


        return $result;
    }

    public function headings(): array
    {
        return $this->headings;
    }


}
