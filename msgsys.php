<?php

$channel = $_POST['channel'];
if (isset($_POST['jsondata'])) $jsonData = $_POST['jsondata'];
$method = $_POST['method'];
$user = $_POST['user'];

$filepath = dirname($_SERVER['SCRIPT_FILENAME']) . "/" . $channel;

if ($method === 'sent') {
  $fileuser = $filepath . "_" . $user;
  file_put_contents($filepath, "\r\n\r\n" . $jsonData, FILE_APPEND | LOCK_EX);
  if (!file_exists($fileuser)) file_put_contents($fileuser, "0");
} else if ($method === 'get') {
  $fileuser = $filepath . "_" . $user;
  if (!file_exists($fileuser)) file_put_contents($fileuser, "0");
  $filelen = file_get_contents($fileuser);
  $filepathlen = filesize($filepath);
  if ($filelen == $filepathlen) { http_response_code(404); return; }
  $handle = fopen($filepath, "r+");
  if (isset($handle)) {
    $block = 1;
    flock($handle, LOCK_SH, $block);
    fseek($handle, $filelen);
    $output = fread($handle, $filepathlen - $filelen);
    flock($handle, LOCK_UN);
    fclose($handle);
    file_put_contents($fileuser, $filepathlen);
    echo $output;
  } else {
    http_response_code(404);
  }
} else if ($method == 'delete') {
  $fileuser = $filepath . "_" . $user;
  if (file_exists($fileuser)) unlink($fileuser);
}