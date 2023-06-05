<html>
<head>
    <title>TNDE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> 
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="http://newtnde.aplog.co.id/images/app/tnde/favicon.png">    
    <style type="text/css">
        body{
            font-family: 'Calibri';
        }
         .judul-halaman{
            padding: 12px 10px;
            margin-bottom: 12px;
            font-family: 'Calibri';
            font-size: 18px;
            -webkit-border-radius: 0px;
            -moz-border-radius: 0px;
            border-radius: 0px;
            color: #333333;
            border-bottom: 1px solid #ccc;
            background-color: #fff;
            font-weight: bold;
         }
         .konten-area{
            float: left;
            width: 100%;
            clear: both;
            background: #FFFFFF;
              background-color: rgb(255, 255, 255);
            margin: 15px 0px;
            padding: 15px 0px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            padding-top: 0px;
         }
         .konten-inner{
/*            padding-left: 20px;
            padding-right: 20px;*/
            padding-bottom: 20px;
         }
         .page-header{
            margin-top: 0px;
            margin-bottom: 0px;
            border-bottom: none;
            background: #e07f2a;;
            -webkit-border-radius: 2px;
            -moz-border-radius: 2px;
            border-radius: 2px;
         }
         .page-header h3{
            font-family: 'Calibri';
            font-size: 16px;
            text-transform: uppercase;
            margin-top: 0px;
            margin-bottom: 0px;
            padding-top: 8px;
            color: #FFFFFF;
         }
         .page-header h3 i {
            color: #FFFFFF;
            width: 24px;
            text-align: center;
            margin-left: 8px;
            font-size: 16px;
         }
         .form-group{
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-left: 0px !important;
            margin-right: 0px !important;
            /**background: #e6e6e6;*/
            margin-top: 0px;
            margin-bottom: 1px;
            padding-top: 5px;
            padding-bottom: 5px;
         }
         .panel-default > .panel-heading {
           background-color: #e07f2a;
         }
         .panel-title a:after {
            font-family:Fontawesome;
            content:'\f077';
            float:right;
            font-size:10px;
            font-weight:300;
        }
        .panel-title a.collapsed:after {
            font-family:Fontawesome;
            content:'\f078';
        }

        @media only screen and (min-width: 600px) {
            .control-label{
                text-align: right;
            }
        }
      </style>
</head>
<body>
{{--    <!-- {{ dd($doc) }} -->--}}
<div class="container-fluid">
    <div class="row" style="position: relative;">
        <div class="col-md-12">
            <div class="row judul-halaman">
                <!-- <table>
                    <tbody>
                        <tr>
                            <td width="30%"><img src="https://aplog.co/global/web/frontend/images/logo.png" width="*" height="50px"></td>
                            <td width="70%" style="padding-left: 15px;">
                                <h3>TATA NASKAH DINAS ELEKTRONIK</h3>
                                <span><strong>PT Angkasa Pura Logistics</strong></span>
                            </td>
                        </tr>
                    </tbody>
                </table> -->   
                <div class="col-sm-12 col-md-2" style="padding-bottom: 10px;">
                    <img src="https://aplog.co/global/web/frontend/images/logo.png" width="*" height="50px">
                </div>
                <div class="col-sm-12 col-md-10">
                    <span style="font-size: 20px;">TATA NASKAH DINAS ELEKTRONIK</span><br>
                    <span><strong>PT Angkasa Pura Logistics</strong></span>
                </div>             
            </div>   
            <div class="konten-area">
                <div class="konten-inner">
                    <div class="row">
                        <div class="col-md-12">
                                <p>Informasi surat ini dinyatakan sah dan sesuai dengan sistem Informasi Tata Naskah Dinas Elektronik milik PT Angkasa Pura Logistics</p>
                                <div class="panel-group">
                                    <div class="panel panel-default">
                                        <div class="panel-heading" style="color:#fff;"><i class="fa fa-file-text"></i> Informasi Surat
                                        </div>
                                        <div class="panel-body" style="line-height: 35px">
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Nomor :</strong></div>
                                                <div class="col-md-10">{{ $doc['docNo'] }}</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Tanggal :</strong></div>
                                                <div class="col-md-10">{{ $doc['docDate'] }}</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Perihal :</strong></div>
                                                <div class="col-md-10">{{ $doc['subject'] }}</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Tujuan :</strong></div>
                                                <div class="col-md-10">
                                                    <ol>                                        
                                                        @foreach ($doc['recipient'] as $val)
                                                           <li>
                                                                {{ $val['obj']['name'] }}
                                                                <br>{{ $val['obj']['jobTitle'] }}
                                                                
                                                            </li>
                                                        @endforeach
                                                    </ol>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Pembuat Surat :</strong></div>
                                                <div class="col-md-10">{{ $doc['ownerName'] }}</div>
                                            </div>
                                            <div class="form-group">
                                                <div class="control-label col-md-2"><strong>Tanggal Surat Dibuat :</strong></div>
                                                <div class="col-md-10">
                                                    {{ date('d M Y h:i:s', strtotime($doc['created_at'])) }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            <!-- Collapse -->
                            <div class="col-md-12">
                                    <!-- <h3 class="h3">More About Us</h3> -->
                                    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel panel-default">
                                                    <div class="panel-heading" role="tab" id="headingOne">
                                                            <h4 class="panel-title"> <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="color:#fff;"> Pemaraf  </a> </h4>
                                                    </div>
                                                    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                                            <div class="panel-body">
                                                                <div class="table-responsive">
                                                                <table class="table table-striped table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="5%">No</th>
                                                                            <th width="25%">Nama</th>
                                                                             <th width="45%">Jabatan</th>
                                                                             <th width="25%">Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr><?php $no=1; ?> 
                                                                            @foreach ($doc['signer'] as $key => $sign)
                                                                                <td>{{ $no }}.</td>
                                                                                <td>{{ $sign['obj']['name'] }}</td>
                                                                                <td>{{ $sign['obj']['jobTitle'] }}</td> 
                                                                                <td>{{ $doc['signingStatus'][$key]['obj']['decision'] }}</td>
                                                                                <?php $no++; ?>
                                                                            @endforeach
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            </div>
                                                    </div>
                                            </div>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="headingTwo">
                                                    <h4 class="panel-title"> 
                                                        <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo" style="color:#fff;"> Verifikator </a> 
                                                    </h4>
                                                </div>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
                                                        <div class="panel-body">
                                                            <div class="table-responsive">
                                                                <table class="table table-striped table-hover">
                                                                    <thead>
                                                                        <tr>
                                                                            <th width="5%">No</th>
                                                                            <th width="25%">Nama</th>
                                                                             <th width="45%">Jabatan</th>
                                                                             <th width="25%">Status</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr><?php $no=1; ?> 
                                                                            @foreach ($doc['draftRecipient'] as $key => $draft)
                                                                                <td>{{ $no }}.</td>
                                                                                <td>{{ $draft['obj']['name'] }}</td>
                                                                                <td>{{ $draft['obj']['jobTitle'] }}</td> 
                                                                                <td>{{ $doc['draftStatus'][$key]['obj']['decision'] }}</td>
                                                                                <?php $no++; ?>
                                                                            @endforeach
                                                                            
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                </div>
                                            </div>
                                            
                                    </div>
                            </div>
                        
                    </div>


                        
                    <!-- </form> -->
                </div>
            </div>
        </div>        
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
</body>
</html>

