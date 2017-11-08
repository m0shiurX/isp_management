<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';

	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	// check if the form is submitted
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$username = $_POST['username'];
			$email = $_POST['email'];
			$password = $_POST['password'];
			$repassword = $_POST['repassword'];
			$fullname = $_POST['fullname'];
			$address = $_POST['address'];
			$contact = $_POST['contact'];

			if (isset($_POST)) 
			{

				$errors = array();

				// Check if password are the same
				if (!$admins->ArePasswordSame($_POST['password'], $_POST['repassword'])) 
				{
					session::set('errors', ['The two passwords do not match.']);
				}elseif ($admins->adminExists($_POST['username'])) {
					session::set('errors', ['This username is already in use by another admin.']);
				}elseif (!$admins->addNewAdmin($username, $password, $email, $fullname, $address, $contact)) {
					session::set('errors', ['An error occured while saving the new admin.']);
				}else{
					session::set('confirm', 'New admin added successfully!');
					unset($_POST['repassword']);
				}
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleteUser($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$username = $_POST['username'];
		$email = $_POST['email'];
		$full_name = $_POST['full_name'];
		$address = $_POST['address'];
		$contact = $_POST['contact'];
		$user_id = $_POST['user_id'];
		if (!$admins->updateAdmin($user_id, $username, $email, $full_name, $address, $contact)) 
		{	
			//echo "$user_id $username $email $full_name $address $contact";
			echo "Sorry Data could not be Updated !";
		}else {
			$commons->redirectTo(SITE_PATH.'user.php');
		}

	}else{
		$users = $admins->fetchAdmin(); 
		if (isset($users) && sizeof($users) > 0) {
			foreach ($users as $user){ ?>
				<tr>
					<td scope="row"><?=$user->user_id ?></td>
					<td>
						<button type="button" id="edit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-<?=$user->user_id?>">EDIT</button>
						<div class="fade modal" id="edit-<?=$user->user_id?>">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">×</button>
										<h4>Edit Details</h4>
									</div>
									<form method="POST">
										<div class="modal-body">
											<!-- The async form to send and replace the modals content with its response -->
											<!-- form content -->
											<input type="hidden" id="<?=$user->user_id ?>" value="<?=$user->user_id?>">

											<div class="form-group has-success">
												<label for="name">Full Name</label>
												<input type="text" class="form-control" id="fnm-<?=$user->user_id?>"  value="<?=$user->full_name?>" required>
											</div>
											<div class="form-group">
												<label for="Username">Username</label>
												<input type="text" class="form-control" id="usr-<?=$user->user_id?>"  value="<?=$user->user_name?>" required>
											</div>
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" class="form-control" id="em-<?=$user->user_id?>"  value="<?=$user->email?>" required>
											</div>
											<div class="form-group">
												<label for="details">Address</label>
												<input type="text" class="form-control" id="ad-<?=$user->user_id?>"  value="<?=$user->address?>" required>
											</div>
											<div class="form-group">
												<label for="contact">Contact</label>
												<input type="text" class="form-control" id="con-<?=$user->user_id?>"   value="<?=$user->contact?>" required>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit"  onclick="updateData(<?=$user->user_id?>)" class="btn btn-primary">Update</button>
											<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
										</div>
									</form>
								</div>
							</div>
						</div>
						<button type="submit" id="delete" onclick="delData(<?=$user->user_id ?>)" class="btn btn-warning btn-sm disabled">DELETE</button>
					</td>
					<td class="search"><?=$user->user_name?></td>
					<td class="search"><?=$user->full_name?></td>
					<td class="search"><?=$user->email?></td>
					<td class="search"><?=$user->contact?></td>
					<td class="search"><?=$user->address?></td>
				</tr>
			<?php
			}
		}
	}
?>