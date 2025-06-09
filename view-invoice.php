<?php
	// Check if 'keyval' GET parameter is provided
	if (!isset($_GET['keyval'])) {
		echo json_encode(["error" => "No key value provided"]);
		exit;
	}

	$keyval = $_GET['keyval'];

	// Read the JSON file
	$jsonFile = 'data.json'; // Replace with your actual file path
	if (!file_exists($jsonFile)) {
		echo json_encode(["error" => "JSON file not found"]);
		exit;
	}

	$jsonData = file_get_contents($jsonFile);
	$data = json_decode($jsonData, true); // Decode as associative array

	// Validate JSON decoding
	if (json_last_error() !== JSON_ERROR_NONE) {
		echo json_encode(["error" => "Invalid JSON format"]);
		exit;
	}

	// Search for matching key
	$found = null;
	foreach ($data as $item) {
		if (isset($item['key']) && $item['key'] === $keyval) {
			$found = $item;
			break;
		}
	}

	// Output result
	if ($found) {
		echo json_encode($found);
	} else {
		echo json_encode(["error" => "Invalid key entered"]);
	}
?>