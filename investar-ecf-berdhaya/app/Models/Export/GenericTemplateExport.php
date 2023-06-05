<?php
namespace App\Models\Export;
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
class GenericTemplateExport implements FromArray, WithHeadings {

    protected $model;
    protected $limit;
    protected $page;
    protected $headings;

    public function __construct($model, $limit = 10000, $page = 0, $headings = [] )
    {
        $this->model = $model;
        $this->limit = $limit;
        $this->page = $page;
        $this->headings = $headings;
    }



    public function array(): array
    {
        debug($this->headings);
        return $this->model;
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
