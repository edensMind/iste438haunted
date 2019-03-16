<?php

	require '../vendor/autoload.php'; // include Composer's autoloader

	$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->haunted->places;

	$doc_record = (int)$_POST["record"];
	$comment = $_POST["comment"];

	// db.places.update({record:5824}, {$addToSet: {comments: ["test1, test2"]}})
	// db.places.find({record:5824}).pretty()


	$updateResult = $collection->updateOne(
	    [ 'record' => $doc_record ],
	    [ '$addToSet' => ['comments' => $comment] ]
	);

	echo json_encode("Matched: ".$updateResult->getMatchedCount()." Modified: ".$updateResult->getModifiedCount());
?>