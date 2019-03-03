<?php 

// $record = $_POST["record"];

$record = "4501";


// In practice, $fileId denotes the _id of an existing file in GridFS
$fileId = new MongoDB\BSON\ObjectId;

$bucket = (new MongoDB\Client)->haunted->selectGridFSBucket();

$file = fopen('/path/to/my-output-file.txt', 'wb');

$bucket->downloadToStream($fileId, $file);

?>