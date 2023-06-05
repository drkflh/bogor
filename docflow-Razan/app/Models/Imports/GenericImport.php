<?php
namespace App\Models\Imports;

use App\Models\Imports\Importsession;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 20/04/19
 * Time: 18.41
 */

class GenericImport implements ToCollection,WithHeadingRow
{
    protected $updatekey;
    protected $mode;
    protected $sessId;
    protected $headindex;
    protected $aux;
    protected $auxOverrides;
    protected $additive;


    /**
     * GenericImport constructor.
     */
    public function __construct($session,$headindex, $mode= 'insert', $updatekey='_id', $aux = false, $auxOverrides = [], $additive = true)
    {
        $this->importid = $session;
        $this->headindex = $headindex;
        $this->mode = $mode;
        $this->updatekey = $updatekey;
        $this->aux = $aux;
        $this->auxOverrides = $auxOverrides;
        $this->additive = $additive;
    }

    public function collection(Collection $rows)
    {
        foreach($rows as $row){

            if( $row->filter()->isNotEmpty() ){

                $imodel = new Importsession();

                $imodel->importid = $this->importid;
                foreach ($row as $field=>$val){
                    if($field != ''){
                        $val = $this->override($field, $val);
                        $imodel->{$field} = $val;
                    }
                }


                if($this->additive && $this->aux){
                    if(is_array($this->aux)){
                        foreach($this->aux as $k=>$v){
                            $imodel->{$k} = $v;
                        }
                    }
                }

                if($this->mode == 'insert'){
                    unset($imodel->_id);
                }

                $imodel->save();

            }

        }
    }

    private function override($field, $val)
    {
        $this->aux = (array) $this->aux;
        debug($this->aux);
        debug($this->auxOverrides);

        if($this->aux && !empty($this->auxOverrides)){
            info( 'auxoverride', [ $field, $this->aux, $this->auxOverrides ]);
            if(in_array($field, $this->auxOverrides )){
                if(isset( $this->aux[$field]  ) ){
                    return $this->aux[$field];
                }else{
                    return $val;
                }
            }
            return $val;
        }
        return $val;

    }

    public function headingRow(): int
    {
        return intval( $this->headindex );
    }
}
