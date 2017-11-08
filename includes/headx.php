<?php
	
	// Get the application settings and parameters
	date_default_timezone_set('Asia/Dhaka');
	require_once "config/params.php";
	require_once "includes/classes/session.php";
	require_once "config/dbconnection.php";
	require_once "includes/classes/commons.php";

	// Start the session if it's not yet set 
	// and make it available on 
	// all pages which include the header.php
	!isset($_SESSION) ? session::init(): null;

	// Get some common objects ready for various files
	$dbh 	= new Dbconnect();
	$commons = new Commons($dbh);
	
?>
