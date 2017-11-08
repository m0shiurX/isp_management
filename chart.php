<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';

	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	$products = $admins->fetchProductionStats();
	$data = array();
	foreach ($products as $product) {
		$data[] = $product;
	}
	// echo "<pre>";
	print json_encode($data);
	// print_r($data);
	// echo "</pre>";
?>