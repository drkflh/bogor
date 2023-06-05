<?php

namespace App\Jobs;

use App\Events\ExportDone;
use App\Helpers\TimeUtil;
use App\Models\Export\GenericExportCollection;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Carbon\Carbon;
use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use MongoDB\BSON\ObjectId;
use MongoDB\BSON\UTCDateTime;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExportXlsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $collection_name;
    protected $connection_name;
    protected $filepath;
    protected $filedriver;
    protected $writer;
    protected $headings;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($collection_name, $connection_name, $headings ,$filepath, $filedriver ,$writer)
    {
        $this->collection_name = $collection_name;
        $this->connection_name = $connection_name;
        $this->headings = $headings;
        $this->filepath = $filepath;
        $this->filedriver = $filedriver;
        $this->writer = $writer;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //echo $this->collection_name.' '.$this->connection_name.' '.$this->filepath.' '.$this->filedriver.' '.$this->writer;

        $fullpath = storage_path('app/'.$this->filepath);

        $result = DB::connection($this->connection_name)->table($this->collection_name)
            ->get() ;

        if($this->writer == \Maatwebsite\Excel\Excel::XLSX ){
            $writer = WriterEntityFactory::createXLSXWriter()
                ->setShouldCreateNewSheetsAutomatically(true)
                ->openToFile($fullpath);
        }else{
            $writer = WriterEntityFactory::createCSVWriter()
                ->openToFile($fullpath);
        }
        $headrow = WriterEntityFactory::createRowFromArray($this->headings);
        $writer->addRow($headrow);

        foreach($result as $r){
            $cells = [];
            foreach($this->headings as $h){
                $val = isset($r[$h]) ? $r[$h] : '--';
                $val = $val ?? '--';
                if( $val instanceof UTCDateTime){
                    $val = $val->toDateTime()->format('Y-m-d H:is');
                }
                if($val instanceof ObjectId){
                    $val = $val->serialize();
                }
                if( is_array( $val ) ){
                    if(is_null( $val ) || empty($val) ){
                        $val = '--';
                    }else{
                        try {
                            $val = json_encode($val);
                        }catch(\Exception $exception){
                            $val = '--';
                        }
                    }
                }
                if( is_object( $val ) ){
                    if(is_null( $val ) || empty($val) ){
                        $val = '--';
                    }else{
                        try {
                            $val = serialize( $val );
                        }catch(\Exception $exception){
                            $val = '--';
                        }
                    }
                }
                if(is_null( $val ) || empty($val) ){
                    $val = '--';
                }
                $rx = $val;
                $cell = WriterEntityFactory::createCell($rx);
                if(is_null($cell)){
                    $cells[] = WriterEntityFactory::createCell(' ');
                }else{
                    $cells[] = $cell ;
                }
            }
            $srow = WriterEntityFactory::createRow($cells);
            try {
                $writer->addRow($srow);
            }catch (Exception $exception){

            }
        }
        $writer->close();

        broadcast( new ExportDone() ) ;
    }

}
