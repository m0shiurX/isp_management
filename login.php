<?php

	// Start from getting the header which contains some settings we need
	require_once 'includes/headx.php';

	// Prevent admin from comming back here
	// if he's already logged in
	if (isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'index.php');
	}

?>
<!DOCTYPE html>
<html>
<head>
	<title>Authenticate yourself !</title>
	<link rel="stylesheet" type="text/css" href="component/css/style.css">
	<style media="screen">
	body { 
	   	background-image: url("component/img/bg.png");
	    background-position: center center;
		background-repeat:  no-repeat;
		background-attachment: fixed;
		background-size:  cover;
		background-color: lightblue;
	}
	</style>
</head>
<body>
<div class="admin-box">

	<?php  if ( isset($_SESSION['error']) ): ?>
		<div class="pannel panel-warning">
			<?= $_SESSION['error'] ?>
		</div>
	<?php session::destroy('error'); endif ?>

	  <form action="approve.php" method="post"  class="form-signin">
	  		<h2 class="form-signin-heading">Authenticate yourself!</h2>
	  			<input type="text" name="username" id="username" class="form-control" placeholder="username" required autofocus>	  		
	  			<input type="password" name="password" id="password" class="form-control" placeholder="password" required>
	  			<button type="submit" class="btn btn-default">Log in</button>
	  </form>
</div>
<?php include 'includes/footer.php'; ?>
</body>
</html>

