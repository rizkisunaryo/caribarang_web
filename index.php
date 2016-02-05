<?php 
include_once 'constants.php';
include_once 'inc/db.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>CariBarang</title>
	<meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" />
	<script type="text/javascript" src="http://code.jquery.com/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>
	<?php

	if (isset($_GET['form_submit'])) {
		
	} else {
		include_once 'index_form.php';
	}

	?>
</body>
</html>