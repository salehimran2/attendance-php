<?php

// Enable cross origin resource sharing from certain URLs
if (isset($_SERVER) && isset($_SERVER['HTTP_ORIGIN'])) {
  switch ($_SERVER['HTTP_ORIGIN']) {
    case 'https://ggorlen.github.io':
      header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
      header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
      header('Access-Control-Max-Age: 1000');
      header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
    break;
  }
}
?>
