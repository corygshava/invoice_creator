<nav class="w3-hide-small w3-hide-medium">
	<div class="logo">
		<b>Uploader</b>
	</div>
	<div class="links">
		<a href="index.php">home</a>
		<a href="meknew.php">create</a>
		<a href="view-invoice.php">view invoice</a>
	</div>
	<?php
		if(isset($_COOKIE['accesstoken'])){
			?>
				<a href="logout.php">logout</a>
			<?php
		}
	?>
</nav>
