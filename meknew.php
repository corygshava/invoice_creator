<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Invoice Creator</title>

	<link rel="stylesheet" type="text/css" href="css/w3.css">
	<link rel="stylesheet" type="text/css" href="css/styles.css">

	<script src="js/app.js"></script>
	<script src="js/logbox.js"></script>
</head>
<body>
	<?php
		include 'elements/navbar.php';
	?>

	<div class="content t0">
		<section class="whitebg" id="inputarea">
			<div class="card">
				<h2 class="themetxt">Invoice Title:</h2>
				<input type="text" placeholder="Enter invoice title" id="invTitle" class="mynpt">
				<hr>
				<!-- Item Inputs -->
				<div class="item-inputs">
					<input type="text" placeholder="Item Name" id="inv_item" class="mynpt">
					<input type="text" placeholder="Amount" id="inv_amt" class="mynpt">
					<button id="addbtn">Add</button>
				</div>
			</div>
		</section>

		<section class="whitebg">
			<h3 class="w3-center" id="titleShow">Invoice title</h3>
			<!-- Item List -->
			<div class="item-list" id="itemsContainer"></div>
			<div class="final-guy w3-grey" id="totals">
			</div>
		</section>
	</div>

	<div class="actions">
		<section class="holder whitebg">
			<button onclick="saveToLocal()">Save locally</button>
			<button onclick="loadFromLocal()">Load saved</button>
			<button onclick="deleteFromLocal()">Delete locally</button>
			<button onclick="uploadData()">Upload to Server</button>
		</section>
	</div>

	<script>
		window.addEventListener('load',() => {
			mek_log_box("enter details to continue");
		})
	</script>
</body>
</html>