<nav class="w3-hide-small w3-hide-medium">
	<div class="logo">
		<b>Invoice Creator</b>
	</div>
	<div class="navlinks links" id="sitelinks">
		<a href="index.php">home</a>
		<a href="meknew.php">create</a>
		<a href="view-invoice.php">view invoice</a>
	</div>
</nav>

<div class="options w3-hide-large">
	<div class="menu navlinks" data-copyme="#sitelinks">
	</div>
</div>

<script type="text/javascript">
	var menu = document.querySelector('.menu');
	var _mypage = document.title;

	var isuploader = (_mypage.indexOf('upload') > 0) ? 0 : 1;
	menu.querySelectorAll('a')[isuploader].className = "current";
</script>
