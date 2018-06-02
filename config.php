<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

	define("DB_PATH", "myproj.db");
	define("FULL_IMAGES_PATH", dirname(__FILE__) . "\assets\images");
	define("SHORT_IMAGES_PATH", "assets/images/");
	define("IMAGE_EXTENSIONS", [
	    'image/jpeg' => 'jpeg',
	    'image/png' => 'png',
	    'image/jpg' => 'jpg'
	]);
	define("ALLOWED_IMAGE_TYPES", ["gif", "png", "jpg"]);

	header('X-Frame-Options: SAMEORIGIN');
	
	include_once 'includes/classes/Scripts.php';
	include_once 'includes/classes/Database.php';
	include_once 'includes/classes/Image.php';
		
	
	$scripts = new Scripts();
	
	$scripts->addJavascript("assets/javascript/plugins/googlepicker", "googlepicker.js", true);
	$scripts->addJavascript("https://apis.google.com/js", "api.js?onload=onApiLoad", true);
	$scripts->addJavascript("assets/javascript/custom", "main.js", true);

	$scripts->addStylesheet("assets/css/plugins/bootstrap", "bootstrap.css");
	$scripts->addStylesheet("assets/css/custom", "main.css");
?>