<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use sbourdette\MongoQueueMonitor\Traits\IsMonitored;
use setasign\Fpdi\Fpdi;
use SimpleSoftwareIO\QrCode\Generator;

class EmbedQRJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    protected $qr_string = '';
    protected $encoding = 'p';
    protected $options = ['encoding'=>'p'];
    protected $source;
    protected $output;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($qr_string, $source, $output , $options = ['encoding'=>'p'])
    {
        $this->qr_string = $qr_string;
        $this->encoding = $options['encoding'] ?? 'p';
        $this->options = $options;
        $this->source = $source;
        $this->output = $output;
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $source = $this->source;
        $output = $this->output;
        $data = $this->qr_string;

        $qrd = new Generator();
        $qr = $qrd->format('png')
            ->size(220)->color(0, 0, 0 )
            ->errorCorrection('H')
            ->style('round' )
            ->backgroundColor(255, 255, 255)
            ->margin(2)
            ->generate($data);

        file_put_contents( storage_path('tmp/'.$data.'.png'), $qr );

        $image = storage_path('tmp/'.$data.'.png');

        $pdf = new Fpdi();
        $pageCount = $pdf->setSourceFile($source);
        for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
            // import a page
            $templateId = $pdf->importPage($pageNo);
            $pdf->AddPage();
            // use the imported page and adjust the page size
            $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

            if($pageNo == 1){
                $width = $pdf->GetPageWidth();
                $pdf->Image($image,($width - 75),5,15,15); // X start, Y start, X width, Y width in mm
                $pdf->SetFont('Helvetica','',10); // Font Name, Font Style (eg. 'B' for Bold), Font Size
                $pdf->SetTextColor(0,0,0); // RGB
                $pdf->Text($width - 60,10,$data);
            }

            $pdf->SetFont('Helvetica', '', 8);
            $pdf->SetXY(15, 5);
            $pdf->Write(8, 'Cedar DMS - Document Management System');
        }

        $pdf->Output($output, "F");

    }
}
