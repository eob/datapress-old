<?php
/*
 * For every request, log the referrer, client ip, time, and all
 * GET-request variables.  These are stores in one line per
 * request.  Keys and values are encoded as key:base64(value),
 * and key-value pairs of one request are separated by commas. 
 * The logfile is specified by a variable $logfile set in config.php.
 */
require_once('config.php');

$logstr = "";

$ref = base64_encode($_SERVER['HTTP_REFERER']);
$ip = base64_encode($_SERVER['REMOTE_ADDR']);
$time = base64_encode(time());

$logstr = "referer:$ref,ip:$ip,time:$time,";

foreach ($_GET as $key => $value) {
  if (!strcmp($key, "_")) {
    continue;
  }
  $logstr .= "$key:$value,";
}

$logstr = rtrim($logstr, ",");

$logstr .= "\n";

if (!$handle = fopen($logfile, 'a')) {
  echo "Cannot open file ($logfile)";
  exit;
}

fwrite($handle, $logstr);
fclose($handle);
header("Content-type: text/javascript");
echo "";
?>
