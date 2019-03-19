<?php

// $record = $_POST["record"];

$record = "4501";


// In practice, $fileId denotes the _id of an existing file in GridFS
$fileId = new MongoDB\BSON\ObjectId;
$bucket = (new MongoDB\Client)->haunted->selectGridFSBucket();
$data = $bucket->openDownloadStream($fileId);
$out = fopen('php://output', 'w');
stream_copy_to_stream($data, $out);

?>
