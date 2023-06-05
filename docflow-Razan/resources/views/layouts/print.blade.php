<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('SITE_NAME','') }} - {{ env('SITE_TITLE') }}</title>
    <!-- core:css -->
{{--    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/core/core.css">--}}
    <!-- endinject -->
{{--    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/overpass/stylesheet.css">--}}
    <link href="{{ url('themes/dashforge') }}/lib/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/fonts/feather-font/css/iconfont.css">
    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/vendors/flag-icon-css/css/flag-icon.min.css">

{{--    <link rel="stylesheet" href="{{ url('css/app.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ url('themes/nobleui') }}/assets/css/demo_1/style.css">--}}

    <!-- Theme CSS overrides -->
{{--    <link rel="stylesheet" href="{{ url('/') }}/css/noble.css">--}}

    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ url(env('APP_FAVICON', 'favicon.ico')) }}" />

    <script src="{{ url(mix('js/app.js')) }}"></script>

{{--    <link href="//db.onlinewebfonts.com/c/a78cfad3beb089a6ce86d4e280fa270b?family=Calibri" rel="stylesheet" type="text/css"/>--}}

    <style>
        @font-face {font-family: "Calibri";
            src: url("{{ url('/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.eot"); /* IE9*/
            src: url("{{  url( '/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.eot?#iefix") format("embedded-opentype"), /* IE6-IE8 */
            {{--url("{{  url( '/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.woff2") format("woff2"), /* chrome、firefox */--}}
            url("{{  url( '/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.woff") format("woff"), /* chrome、firefox */
            url("{{  url( '/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.ttf") format("truetype"), /* chrome、firefox、opera、Safari, Android, iOS 4.2+*/
            url("{{  url( '/fonts/Calibri/font-face' ) }}/a78cfad3beb089a6ce86d4e280fa270b.svg#Calibri") format("svg"); /* iOS 4.1- */
        }
        .ellipsis {
            max-width: 500px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        .text-top {
            vertical-align: top !important;
        }

        .text-middle {
            vertical-align: middle !important;
        }

        .text-20 {
            max-width: 20px;
            min-width: 20px;
            width: 20px !important;
        }

        .text-25 {
            max-width: 25px;
            min-width: 25px;
            width: 25px !important;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .text-50 {
            max-width: 50px;
            min-width: 50px;
            width: 50px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }
        .text-75 {
            max-width: 75px;
            min-width: 75px;
            width: 75px;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }

        .text-100 {
            max-width: 100px;
            min-width: 100px;
            width: 100px;
        }

        .text-125 {
            max-width: 125px;
            min-width: 125px;
            width: 125px;
        }

        .text-150 {
            max-width: 150px;
            min-width: 150px;
            width: 150px;
            overflow: auto;
            white-space: break-spaces;
        }

        .text-175 {
            white-space: nowrap;
            max-width: 175px;
            min-width: 175px;
            width: 175px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-200 {
            white-space: nowrap;
            max-width: 200px;
            min-width: 200px;
            width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-250 {
            max-width: 250px;
            min-width: 250px;
            width: 250px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-275 {
            max-width: 275px;
            min-width: 275px;
            width: 275px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-300 {
            max-width: 300px;
            min-width: 300px;
            width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-350 {
            max-width: 350px;
            min-width: 350px;
            width: 350px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-400 {
            max-width: 400px;
            min-width: 400px;
            width: 400px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-450 {
            max-width: 450px;
            min-width: 450px;
            width: 450px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .text-500 {
            max-width: 500px;
            min-width: 500px;
            width: 500px;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        @media screen {
            .headerLeft{
                display: none;
                text-align: right;
            }
            .headerRight{
                display: none;
                text-align: right;
            }
        }
        @page  {
            margin-top: {{ $marginTop ?? '45mm' }};
            margin-left: {{ $marginLeft ?? '10mm' }};
            margin-right: {{ $marginRight ?? '10mm' }};
            margin-bottom: {{ $marginBottom ?? '20mm' }};

            @if($pageSize != '')
                size: {{ $pageSize }};
            @endif

            @if(in_array('With Header', $headerSetting) )
                @top-left{
                    content: element(headerLeft);
                }

                @top-center{

                }

                @top-right{
                    content: element(headerRight);
                }
            @endif


            @if(in_array('With Page Number', $numberSetting) )
                @if($numberPosition == 'Right')
                    @bottom-right {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
                @if($numberPosition == 'Center')
                    @bottom-center {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
                @if($numberPosition == 'Left')
                    @bottom-left {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
            @else
                @bottom-right {
                    content: none ;
                }
            @endif

            @if(in_array('With Footer', $footerSetting) )
                @if(in_array('Full Footer', $footerSetting) )
                    @bottom-center{
                        content: element(footerFull);
                    }
                @else
                    @bottom-center{
                        content: element(footerCenter);
                    }
                    @bottom-left{
                        content: element(footerLeft);
                    }
                @endif
            @endif

        }

        @page :first{
            margin: 15mm;
            margin-left: {{ $marginLeft ?? '10mm' }};
            margin-right: {{ $marginRight ?? '10mm' }};
            margin-bottom: {{ $marginBottom ?? '20mm' }};

            @if(in_array('First Page Header', $headerSetting) )
                @top-left{
                    content: element(headerLeft);
                }

                @top-center{

                }

                @top-right{
                    content: element(headerRight);
                }
            @else
                @top-left{
                    content: none;
                }

                @top-center{
                    content: none;
                }
                @top-right{
                    content: none;
                }
            @endif

            @if(in_array('First Page Number', $numberSetting) )
                @if($firstNumberPosition == 'Right')
                    @bottom-right {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
                @if($firstNumberPosition == 'Center')
                    @bottom-center {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
                @if($firstNumberPosition == 'Left')
                    @bottom-left {
                        font-family: Calibri,sans-serif;
                        font-weight: normal;
                        font-size: 8pt;
                        content: {!! $numberFormat ?? "'Hal ' counter(page) ' dari ' counter(pages)"  !!}  ;
                    }
                @endif
            @else
                @bottom-right {
                    content: none ;
                }
            @endif


            @if(in_array('First Page Footer', $footerSetting) )
                @if(in_array('Full Footer', $footerSetting) )
                    @bottom-center{
                        content: element(footerFull);
                    }
                @else
                    @bottom-center{
                        content: element(footerCenter);
                    }
                    @bottom-left{
                        content: element(footerLeft);
                    }
                @endif
            @else
                @bottom-center{
                    content: none;
                }
                @bottom-left{
                    content: none;
                }
            @endif

  }

        .pagebreak { page-break-before: always; } /* page-break-after works, as well */

        .headerLeft{
            position: running(headerLeft);
        }

        .headerRight{
            position: running(headerRight);
        }

        .footerLeft{
            position: running(footerLeft);
        }

        .footerCenter{
            position: running(footerCenter);
        }

        .footerFull{
            position: running(footerFull);
        }

        .footerLeft img{
            width:20mm;
        }

        .footerRight{
            position: running(footerRight);
            text-align: right;
            font-size:8pt;
            font-family: Calibri, -apple-system, system-ui, BlinkMacSystemFont, Arial;
        }

        .pagination{
            text-align: right;
            font-size:8pt;
            font-family: Calibri, -apple-system, system-ui, BlinkMacSystemFont, Arial;
        }

        body, .body {
            width: 100%;
            font-size: 10pt;
            font-family: Calibri, -apple-system, system-ui, BlinkMacSystemFont, Arial;
            background-color: white !important;
        }
        p, table, td, th {
            font-size: 10pt;
            font-family: Calibri, -apple-system, system-ui, BlinkMacSystemFont, Arial;
            background-color: white !important;
        }
        td {
            vertical-align: top;
        }
        hr{
            margin: 8px;
        }
    </style>

</head>
<body >
    <div class="headerLeft">
        @yield('headLeft')
    </div>
    <div class="headerRight">
        @yield('headRight')
    </div>

    @if(in_array('Full Footer', $footerSetting) )
        <div class="footerFull">
            @yield('footerFull')
        </div>
    @else
        <div class="footerRight">

        </div>
        <div class="footerLeft">
            @yield('footerLeft')
        </div>

        <div class="footerCenter">
            @yield('footerCenter')
        </div>
    @endif
{{--    @if(in_array('With Footer', $footerSetting) )--}}
{{--    @endif--}}

    <div class="content">
        @yield('content')
    </div>

</body>
</html>
