<?php
	// Start from getting the header which contains some settings we need
	require_once 'includes/header.php';

	if (isset($_SESSION['admin_session']) )
	{
		session::destroy('admin_session');
		$commons->redirectTo(SITE_PATH.'login.php');
	}
