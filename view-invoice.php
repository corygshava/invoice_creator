<?php
	$keyOn = isset($_GET['thekey']);
	$thedata = "[]";

	// Check if 'keyval' GET parameter is provided
	if ($keyOn) {

		$keyval = $_GET['thekey'];

		// Read the JSON file
		$jsonFile = 'thedata/accessdata.json'; // Replace with your actual file path
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
		if ($found != null) {
			$thedata = json_encode($found);
		} else {
			$thedata = json_encode(array());
		}

		// echo "$thedata";
	}

	$theform = "<div class=\"content\">
        <div class=\"w3-card callout smallz themeround s-autoform-2\">
            <h1 class=\"hedtxt w3-center\">Enter Invoice key</h1>
            <hr>
            <form>
            	<div>
            		<label>your Invoice key</label>
            		<input type=\"text\" name=\"thekey\" placeholder=\"enter key here...\">
            	</div>
            	<button class=\"cta-button active\">check key</button>
            </form>
        </div>
    </div>";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Viewer</title>

    <link rel="stylesheet" type="text/css" href="css/w3.css">
    <link rel="stylesheet" type="text/css" href="css/styles.css">
    <link rel="stylesheet" type="text/css" href="css/s-autoform.css">
</head>
<body>
	<?php
		include 'elements/navbar.php';
	?>
	<?php
		if(!$keyOn){
	?>
	
	<?=$theform?>

	<?php
		} else {
			if($found == null){
	?>
	<?=$theform?>
	<script>alert('Invalid invoice key, try again')</script>
	<?php
			} else {
	?>

	<div class="content">
		<section class="whitebg">
			<h3 class="w3-center" id="titleShow">Invoice title</h3>
			<!-- Item List -->
			<div class="item-list" id="itemsContainer"></div>
			<div class="final-guy w3-grey" id="totals">
			</div>
		</section>
	</div>

	<script src="js/app.js"></script>
	<script>
		let alldata = <?=$thedata?>;
		invoice_title = alldata.data.title;
		invoiceItems = alldata.data.items;

		renderItems();
	</script>

	<?php
			}
		}
	?>
</body>
</html>