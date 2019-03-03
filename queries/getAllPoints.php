<?php

	require '../vendor/autoload.php'; // include Composer's autoloader

	$client = new MongoDB\Client("mongodb://localhost:27017");
	$collection = $client->haunted->places;

	$lng = (float)$_POST['lng'];
	$lat = (float)$_POST['lat'];

// { loc:
//    { $near: 
//    	{
//       $geometry: 
//       {
//         type: "Point" ,
//         coordinates: [ -77.4875, 43.10867 ]
//       },
//       $maxDistance: 5000
//     }
//   }
// }, 

	// $result = $collection->find(Array("coordinates" => Array('$near'=> Array($lng,$lat), '$maxDistance' => 50 ) ));
	$result = $collection->find(Array("coordinates" => Array('$within' => Array('$center'=> Array(Array($lng,$lat), 250/3963.2 ) ) )));

	$locations = array();
    
	foreach ($result as $entry) {
		$location=array(
			"record"=>$entry["record"],
			"city"=>$entry["city"],
			"country"=>$entry["country"],
			"description"=>$entry["description"],
			"location"=>$entry["location"],
			"state"=>$entry["state"],
			"state_abbrev"=>$entry["state_abbrev"],
			"coordinates"=>$entry["coordinates"]
		);
		array_push($locations, $location);
	}

	echo json_encode($locations);

?>

