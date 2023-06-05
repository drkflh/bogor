<?php

return [
  'binary' => env( 'WEASYPRINT_BIN' , '/usr/local/bin/weasyprint') ,
  'cache_prefix' => 'weasyprint-cache_',
  'timeout' => 3600,
];
