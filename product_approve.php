<?php

	// Start from getting the hader which contains some settings we need
	require_once 'includes/headx.php';
	// require the admins class which containes most functions applied to admins
	require_once "includes/classes/admin-class.php";

	$admins	= new Admins($dbh);

	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$name = htmlentities($_POST['name']);
			$unit = htmlentities($_POST['unit']);
			$details = htmlentities($_POST['details']);
			$category = htmlentities($_POST['category']);
			if (!$admins->addNewProduct($name, $unit, $details, $category)) 
			{
				echo "Sorry Data could not be inserted !";
			}else {
				echo "Well! You've successfully inserted new data!";
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleteProduct($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$name = htmlentities($_POST['name']);
		$unit = htmlentities($_POST['unit']);
		$details = htmlentities($_POST['details']);
		$category = htmlentities($_POST['category']);
		$id = $_POST['id'];
		if (!$admins->updateProduct($id, $name, $unit, $details, $category)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {

			$commons->redirectTo(SITE_PATH.'products.php');
		}

	}else{
		$products = $admins->fetchProducts();
		if (isset($products) && sizeof($products) > 0){ 
			foreach ($products as $product) { ?>
    <tr>
        <td class="search" scope="row">
            <?=$product->pro_id?>
        </td>
        <td>
            <button type="button" class="btn btn-success btn-sm" id="edit" data-toggle="modal" data-target="#edit-<?=$product->pro_id?>">EDIT</button>
            <!-- Update modal -->
            <div class="fade modal" id="edit-<?=$product->pro_id?>">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4>Edit Details</h4>
                        </div>
                        <form method="POST" action="product_approve.php?p=edit">
                            <div class="modal-body">
                                <!-- The async form to send and replace the modals content with its response -->
                                <!-- form content -->
                                <input type="hidden" name="id" id="<?=$product->pro_id?>" value="<?=$product->pro_id?>">
                                <div class="form-group has-success">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="nm-<?=$product->pro_id?>" name="name" value="<?=$product->pro_name?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="unit">Unit</label>
                                    <input type="text" class="form-control" id="un-<?=$product->pro_id?>" name="unit" value="<?=$product->pro_unit?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="details">Details</label>
                                    <input type="text" class="form-control" id="dt-<?=$product->pro_id?>" name="details" value="<?=$product->pro_details?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="category">Select Category</label>
                                    <select class="form-control form-control-sm" name="category" id="category">
										      	<option><?=$product->pro_category?></option>
										        <?php
										        $categories = $admins->fetchCategory();
										        	if (isset($categories) && sizeof($categories) > 0){ 
										        	foreach ($categories as $category) { ?>
										        	<option value='<?=$category->cat_name?>'><?=$category->cat_name?></option>
										        <?php }} ?>
										      </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" onclick="upData(<?=$product->pro_id?>)" class="btn btn-primary">Update</button>
                                <a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- modalend -->
            <button type="button" id="delete" onclick="delData(<?=$product->pro_id?>)" class="btn btn-warning btn-sm">DELETE</button>
        </td>
        <td class="search">
            <?=$product->pro_name?>
        </td>
        <td>
            <?=$product->pro_unit?>
        </td>
        <td class="search">
            <?=$product->pro_details?>
        </td>
        <td class="search">
            <?=$product->pro_category?>
        </td>
    </tr>
    <?php
			}
		}
	}
?>
