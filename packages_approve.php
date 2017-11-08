<?php
	require_once 'includes/headx.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$name = htmlentities($_POST['name']);
			$price = htmlentities($_POST['price']);
			if (!$admins->addNewPackage($name, $price)) 
			{
				echo "Sorry Data could not be inserted !";
			}else {
				echo " Data  inserted !";
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deletePackage($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$name = $_POST['name'];
		$price = $_POST['price'];
		$id = $_POST['id'];
		if (!$admins->updatePackage($id, $name, $price)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {

            $commons->redirectTo(SITE_PATH.'packages.php');
            
		}

	}else{

        $packages = $admins->getPackages();
        if (isset($packages) && sizeof($packages) > 0){
            foreach ($packages as $package){
                ?>
            <tr>
                <td><?=$package->id?></td>
                <td><?=$package->name?></td>
                <td><?=$package->fee?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" id="edit" data-toggle="modal" data-target="#edit-<?=$package->id?>">EDIT</button>
                    <!-- Update modal -->
                    <div class="fade modal" id="edit-<?=$package->id?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>Edit Packages</h4>
                                </div>
                                <form method="POST" action="packages_approve.php?p=edit">
                                    <div class="modal-body">
                                        <input type="hidden" id="<?=$package->id?>" value="<?=$package->id?>">
                                        <div class="form-group has-success">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="nm-<?=$package->id?>" value="<?=$package->name?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="text" class="form-control" id="pr-<?=$package->id?>" value="<?=$package->fee?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" onclick="upData(<?=$package->id?>)" class="btn btn-primary">Update</button>
                                        <a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="delete" onclick="delData(<?=$package->id?>)" class="btn btn-warning btn-sm">DELETE</button>
                </td>
            </tr>
        <?php   }
		}
	}
?>
