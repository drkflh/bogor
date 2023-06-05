<?php
namespace App\Helpers\App;


use App\Models\Dms\CallCode;
use App\Models\Dms\CoyCode;
use App\Models\Dms\Doc;
use App\Models\Dms\DocDisposal;
use App\Models\Dms\DocType;
use App\Models\Reference\Area;
use App\Models\Reference\Province;
use App\Models\Reference\City;
use App\Models\Core\Mongo\Sequence;
use App\Models\Sms\SalesOperation\JobRegister;
use App\Models\Directory\VendorDirectory;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfParser\PdfParserException;
use setasign\Fpdi\PdfParser\Type\PdfTypeException;
use setasign\Fpdi\PdfReader\PdfReaderException;
use SimpleSoftwareIO\QrCode\Generator;


class DmsUtil {

    public static function toOptions($data, $text, $value, $all = true)
    {
        $opt = [];

        if($all){
            $opt[] = [ 'text'=>'All', 'value'=>'all'  ];
        }

        foreach ($data as $d){
            if( isset($d[$text]) ){
                if($value == '_object'){
                    $opt[] = [ 'text'=>$d[$text], 'value'=>$d  ];
                }else{
                    $opt[] = [ 'text'=>$d[$text], 'value'=>$d[$value]  ];
                }
            }
        }

        return $opt;

    }

    public static function getDocType($group = null)
    {
        if(is_null($group)){
            $doctypes = DocType::whereNull('DocTypeGroup')
                ->orWhere('DocTypeGroup','exists',false)
                ->orderBy('DocType', 'asc')->get();
        }else{
            $doctypes = DocType::where('DocTypeGroup','=',$group)->orderBy('DocType', 'asc')->get();
        }
        return $doctypes->toArray();
    }

    public static function getCompany()
    {
        $coycodes = CoyCode::orderBy('CoyCode', 'asc')->get();
        return $coycodes->toArray();
    }

    public static function getYearOptions()
    {
        $disposal = DocDisposal::orderBy('CoyCode', 'asc')->get();
        return $disposal->toArray();
    }

  public static function getProvince()
  {
    $coycodes = Area::groupBy('provinceName')->orderBy('provinceName', 'asc')->get();
    return $coycodes->toArray();
  }

  public static function getCity($provinceName)
  {
    // if(count($province)) {
    //     $coycodes = City::where('_id', '=', $province[0]['_id'])->orderBy('cityCode', 'asc')->get();
    //     return $coycodes->toArray();
    // }
    $coycodes = Area::where('provinceName','=',$provinceName)->groupBy('cityName')->orderBy('cityName', 'asc')->get();
    return $coycodes->toArray();
  }

    public static function getTopics()
    {
        $fields = [
            'Topic',
            'TopicDescr',
            'DocClass' ,
            'Group' ,
            'ActiveYrs' ,
            'DispPer' ,
            'Function' ,
            'FunctionDescr' ,
            'Department' ,
            'DepartmentDescr' ,
        ];
        //$disposal = CallCode::orderBy('Topic','asc')->get();
        $disposal = CallCode::groupBy('Topic')
            ->orderBy('Topic','asc')
            ->get($fields);

        $topics = $disposal->toArray();

        for($i = 0; $i < count($topics); $i++ ){
            $topics[$i]['LongDescr'] = $topics[$i]['Topic'] .' '.$topics[$i]['TopicDescr'];
        }
        return $topics;
    }

    public static function getTopic($topic)
    {
        $topic = CallCode::where('Topic','=', trim($topic))->first();

        if($topic){
            return $topic->toArray();
        }else{
            return false;
        }
    }

    public static function getSequence($entity, $padded = true)
    {
        $sequencer = new Sequence();

        $seq = $sequencer->getNewId($entity);

        return ($padded)? str_pad($seq, env('NUM_PAD', 5), '0', STR_PAD_LEFT ) : $seq;

    }

    public static function getVendors()
    {
        $vendorlist = VendorDirectory::where('vendorCode', 'exists', true)->orderBy('vendorCode', 'asc')->get();

        $vendors = $vendorlist->toArray();

        for($i = 0; $i < count($vendors); $i++ ){
            $vendors[$i]['LongDescr'] = ($vendors[$i]['vendorCode'] ?? '') .' '.$vendors[$i]['coyName'];
        }
        return $vendors;
    }

    public static function embedQR( $source, $output, $qr_string )
    {

        $qr_opt = new QROptions([
            'version'    => 5,
            'outputType' => QRCode::OUTPUT_IMAGE_PNG,
            'eccLevel'   => QRCode::ECC_L,
        ]);

        $qr_obj = new QRCode($qr_opt);

        $qr_obj->render( $qr_string , storage_path('temp/'.$qr_string.'.png') );

        //file_put_contents( storage_path('temp/'.$qr_string.'.png'), $qr );

        $image = storage_path('temp/'.$qr_string.'.png');

        $pdf = new Fpdi();

        try {
            $pageCount = $pdf->setSourceFile($source);
            for($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                // import a page
                $templateId = $pdf->importPage($pageNo);
                $pdf->AddPage();
                // use the imported page and adjust the page size
                $pdf->useTemplate($templateId, ['adjustPageSize' => true]);

                if($pageNo == 1){
                    $width = $pdf->GetPageWidth();
                    $pdf->SetFillColor(255,255,255);
                    $pdf->Rect(($width - 60),1,66,15, 'F' );
                    $pdf->Image($image,($width - 60),1,15,15); // X start, Y start, X width, Y width in mm
                    $pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size
                    $pdf->SetTextColor(0,0,0); // RGB
                    $pdf->Text($width - 45,10,$qr_string);
                }else{
                    $width = $pdf->GetPageWidth();
                    $pdf->SetFont('Helvetica','',8); // Font Name, Font Style (eg. 'B' for Bold), Font Size
                    $pdf->SetTextColor(0,0,0); // RGB
                    $pdf->Text($width - 60,10,$qr_string);
                }
            }

            $pdf->Output($output, "F");

            return [ 'status'=>true, 'msg'=>'QR successfully added.' ];

        } catch (PdfParserException $e) {
            return [ 'status'=>false, 'msg'=>$e->getMessage() ];
        } catch (PdfTypeException $e){
            return [ 'status'=>false, 'msg'=>$e->getMessage() ];
        } catch (PdfReaderException $e){
            return [ 'status'=>false, 'msg'=>$e->getMessage() ];
        }


    }

}
