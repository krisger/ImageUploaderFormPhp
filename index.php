<?php
	require 'config.php';   
?>
<!DOCTYPE html>
<html>
	<head>
		<?php
		  echo $scripts->loadScripts();
		  echo $scripts->loadSheets();
		?>
		<title>Image Uploader</title>
	</head>
	<body class="container">
		<?php include 'templates/image-upload-form.php'; ?>
		<?php include 'templates/images.php'; ?>
		
	</body>
</html>