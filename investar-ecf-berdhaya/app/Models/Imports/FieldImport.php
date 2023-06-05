<?php
namespace App\Models\Imports;

use App\Models\Imports\Importsession;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 20/04/19
 * Time: 18.41
 */

class FieldImport implements ToModel,WithHeadingRow
{
    protected $structure = [];

    /**
     * GenericImport constructor.
     */
    public function __construct()
    {

        $this->structure  =  config('util.field_structure');


    }



    public function model(array $row)
    {
        $data = [];
        if (isset($row['name'])) {
            foreach ($this->structure as $label=>$val){
                $data[ $val['field'] ] = $row[ $val['field'] ] ;
            }
        }else{

        }

        return new Importsession($data);

    }

    public function headingRow(): int
    {
        return 1;
    }
}
