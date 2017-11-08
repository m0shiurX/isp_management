<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';

	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	// check if the form is submitted
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$full_name = $_POST['full_name'];
			$nid = $_POST['nid'];
			$address = $_POST['address'];
			$package = $_POST['package'];
			$conn_location = $_POST['conn_location'];
			$email = $_POST['email'];
			$ip_address = $_POST['ip_address'];
			$conn_type = $_POST['conn_type'];
			$contact = $_POST['contact'];

			if (isset($_POST)) 
			{

				$errors = array();
				// Check if password are the same
				if (!$admins->addCustomer($full_name, $nid, $address, $conn_location, $email, $package, $ip_address, $conn_type, $contact)) 
				{
					session::set('errors', ['Couldn\'t Add New Customer']);
				}else{
					session::set('confirm', 'New customer added successfully!');
				}
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deletecustomer($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$id = $_POST['id'];
		$full_name = $_POST['full_name'];
		$nid = $_POST['nid'];
		$address = $_POST['address'];
		$conn_location = $_POST['conn_location'];
		$email = $_POST['email'];
		$package = $_POST['package'];		
		$ip_address = $_POST['ip_address'];
		$conn_type = $_POST['conn_type'];
		$contact = $_POST['contact'];
		if (!$admins->updateCustomer($id, $full_name, $nid, $address, $conn_location, $email, $package, $ip_address,  $conn_type, $contact)) 
		{	
			//echo "$id $customername $email $full_name $address $contact";
			echo "Sorry Data could not be Updated !";
		}else {
			$commons->redirectTo(SITE_PATH.'customers.php');
		}

	}else{
		$customers = $admins->fetchCustomer(); 
		if (isset($customers) && sizeof($customers) > 0) {
			foreach ($customers as $customer){
				$packageInfo = $admins->getPackageInfo($customer->package_id);
				$package_name = $packageInfo->name;
				 ?>
				<tr>
					<td scope="row"><?=$customer->id ?></td>
					<td>
						<button type="button" id="edit" class="btn btn-success btn-sm" data-toggle="modal" data-target="#edit-<?=$customer->id?>">EDIT</button>
						<div class="fade modal" id="edit-<?=$customer->id?>">
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
											<input type="hidden" id="<?=$customer->id ?>" value="<?=$customer->id?>">

											<div class="form-group has-success">
												<label for="name">Full Name</label>
												<input type="text" class="form-control" id="fnm-<?=$customer->id?>"  value="<?=$customer->full_name?>" required>
											</div>
											<div class="form-group">
												<label for="nid">NID</label>
												<input type="text" class="form-control" id="nid-<?=$customer->id?>"  value="<?=$customer->nid?>" required>
											</div>
											<div class="form-group">
												<label for="address">Address</label>
												<input type="text" class="form-control" id="ad-<?=$customer->id?>"  value="<?=$customer->address?>" required>
											</div>
											<div class="form-group">
											<label for="package">Select Package</label>
												<select class="form-control form-control-sm" name="package" id="pk-<?=$customer->id?>">
												<option value='<?=$customer->package_id?>'><?=$package_name?></option>
												<?php 
													$packages = $admins->getPackages();
													if (isset($packages) && sizeof($packages) > 0){ 
														foreach ($packages as $package) { ?>
														<option value='<?=$package->id?>'><?=$package->name?></option>
												<?php }} ?>
												</select>
											</div>
											<div class="form-group">
												<label for="ip">IP Address</label>
												<input type="text" class="form-control" id="ip-<?=$customer->id?>"  value="<?=$customer->ip_address?>" required>
											</div>
											<div class="form-group">
												<label for="contact">Contact</label>
												<input type="text" class="form-control" id="con-<?=$customer->id?>"   value="<?=$customer->contact?>" required>
											</div>
											<div class="form-group">
												<label for="conlocation">Connection Location</label>
												<input type="text" class="form-control" id="conn_loc-<?=$customer->id?>"   value="<?=$customer->conn_location?>" required>
											</div>
											<div class="form-group">
												<label for="type">Connection Type</label>
												<input type="text" class="form-control" id="ct-<?=$customer->id?>"   value="<?=$customer->conn_type?>" required>
											</div>
											<div class="form-group">
												<label for="email">Email</label>
												<input type="text" class="form-control" id="em-<?=$customer->id?>"   value="<?=$customer->email?>" required>
											</div>
										</div>
										<div class="modal-footer">
											<button type="submit"  onclick="updateData(<?=$customer->id?>)" class="btn btn-primary">Update</button>
											<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
										</div>
									</form>
								</div>
							</div>
						</div>
						<button type="submit" id="delete" onclick="delData(<?=$customer->id ?>)" class="btn btn-warning btn-sm">DELETE</button>
					</td>
					<td class="search"><?=$customer->full_name?></td>
					<td class="search"><?=$customer->nid?></td>
					<td class="search"><?=$customer->address?></td>
					<td class="search"><?=$package_name?></td>
					<td class="search"><?=$customer->ip_address?></td>
					<td class="search"><?=$customer->email?></td>
					<td class="search"><?=$customer->conn_type?></td>
					<td class="search"><?=$customer->contact?></td>
				</tr>
			<?php
			}
		}
	}
?>