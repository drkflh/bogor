<?php

namespace App\Jobs;

use App\Helpers\TimeUtil;
use App\Models\Export\GenericExportCollection;
use Box\Spout\Common\Exception\InvalidArgumentException;
use Box\Spout\Common\Exception\IOException;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Exception\WriterNotOpenedException;
use Carbon\Carbon;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Laravie\SerializesQuery\Eloquent;
use Laravie\SerializesQuery\Query;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;

class QueriedExportXlsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $model;
    protected $filepath;
    protected $filedriver;
    protected $writer;
    protected $headings;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($model, $headings ,$filepath, $filedriver ,$writer)
    {
        $this->model = $model;
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
        //$result = DB::connection($this->connection_name)->table($this->collection_name)

        $model = Query::unserialize($this->model);
        $result = $model->get() ;

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
                $val = isset($r[$h]) ? $r[$h] : null;
                if( is_array( $val ) || is_object(is_array( $val ))){
                    $val = json_encode( $val );
                }
                if(is_null( $val ) ){
                    $val = '-';
                }
                $rx = $val;
                $cells[] = WriterEntityFactory::createCell($rx);
            }
            $srow = WriterEntityFactory::createRow($cells);
            $writer->addRow($srow);
        }
        $writer->close();

    }

}
