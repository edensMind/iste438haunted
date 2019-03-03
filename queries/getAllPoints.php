<?php

	require '../vendor/autoload.php'; // include Composer's autoloader

	$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->Haunted->Locations;

	$result = $collection->find();

	$locations = array();
    
	foreach ($result as $entry) {
		$location=array(
			"city"=>$entry["city"],
			"country"=>$entry["country"],
			"description"=>$entry["description"],
			"location"=>$entry["location"],
			"state"=>$entry["state"],
			"state_abbrev"=>$entry["state_abbrev"],
			"longitude"=>$entry["longitude"],
			"latitude"=>$entry["latitude"]
		);
		array_push($locations, $location);
	}

	echo json_encode($locations);

?>

