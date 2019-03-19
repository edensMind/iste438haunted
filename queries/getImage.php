<?php

require '../vendor/autoload.php';

$record = $_GET["record"];

$bucket = (new MongoDB\Client)->haunted->selectGridFSBucket();
$file = $bucket->findOne(["filename" => $record]);
if (is_null($file)) {
  http_response_code(404);
  die();
}
header("Content-Type: image/jpeg");
header("Content-Length: " . $file['length']);
$data = $bucket->openDownloadStream($file['_id']);
$out = fopen('php://output', 'w');
stream_copy_to_stream($data, $out);

?>
