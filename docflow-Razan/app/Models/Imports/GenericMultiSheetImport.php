<?php
namespace App\Models\Imports;

use App\Models\Imports\Importsession;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Events\BeforeSheet;

/**
 * Created by PhpStorm.
 * User: awidarto
 * Date: 20/04/19
 * Time: 18.41
 */

class GenericMultiSheetImport implements ToCollection,WithHeadingRow, WithEvents
{
    use RegistersEventListeners;

    protected $updatekey;
    protected $mode;
    protected $sessId;
    protected $headindex;

    protected $currentSheetName;
    protected $currentSheetIndex = 0;

    /**
     * GenericImport constructor.
     */
    public function __construct($session,$headindex, $mode= 'insert', $updatekey='_id')
    {
        $this->importid = $session;
        $this->headindex = $headindex;
        $this->mode = $mode;
        $this->updatekey = $updatekey;
    }

    public function registerEvents(): array
    {
        return [
            BeforeSheet::class => function(BeforeSheet $event) {
                $this->currentSheetName = $event->getSheet()->getTitle();
                $this->currentSheetIndex++;
                debug($this->currentSheetIndex);
            }
        ];
    }

    public function collection(Collection $rows)
    {
        foreach($rows as $row){

            if( $row->filter()->isNotEmpty() ){

                $imodel = new Importsession();

                $imodel->importid = $this->importid;
                foreach ($row as $field=>$val){
                    if($field != ''){
                        $imodel->{$field} = $val;
                    }
                }
                $imodel->sheetName = $this->currentSheetName;
                $imodel->sheetIndex = $this->currentSheetIndex;

                if($this->mode == 'insert'){
                    unset($imodel->_id);
                }

                $imodel->save();

            }

        }
    }

    public function headingRow(): int
    {
        return intval( $this->headindex );
    }
}
