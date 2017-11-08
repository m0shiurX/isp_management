<?php
	require_once 'includes/headx.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';

	if($page == 'add'){
			$name = htmlentities($_POST['name']);
			if (!$admins->addNewCategory($name)) 
			{
				echo "Sorry Data could not be inserted !";
			}else {
				echo " Data  inserted !";
			}
	}else if($page == 'del'){
		$id = $_POST['id'];
		if (!$admins->deleteCategory($id)) 
		{
			echo "Sorry Data could not be deleted !";
		}else {
			echo "Well! You've successfully deleted a product!";
		}

	}else if($page == 'edit'){
		$name = $_POST['name'];
		$price = $_POST['price'];
		$id = $_POST['id'];
		if (!$admins->updateCategory($id, $name)) 
		{
			echo "Sorry Data could not be inserted !";
		}else {

            $commons->redirectTo(SITE_PATH.'categories.php');
            
		}

	}else{

        $categories = $admins->getCategories();
        if (isset($categories) && sizeof($categories) > 0){
            foreach ($categories as $category){
                ?>
            <tr>
                <td><?=$category->cat_id?></td>
                <td><?=$category->cat_name?></td>
                <td>
                    <button type="button" class="btn btn-success btn-sm" id="edit" data-toggle="modal" data-target="#edit-<?=$category->cat_id?>">EDIT</button>
                    <!-- Update modal -->
                    <div class="fade modal" id="edit-<?=$category->cat_id?>">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4>Edit Category</h4>
                                </div>
                                <form method="POST" action="categories_approve.php?p=edit">
                                    <div class="modal-body">
                                        <input type="hidden" id="<?=$category->cat_id?>" value="<?=$category->cat_id?>">
                                        <div class="form-group has-success">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="nm-<?=$category->cat_id?>" value="<?=$category->cat_name?>" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" onclick="upData(<?=$category->cat_id?>)" class="btn btn-primary">Update</button>
                                        <a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <button type="button" id="delete" onclick="delData(<?=$category->cat_id?>)" class="btn btn-warning btn-sm">DELETE</button>
                </td>
            </tr>
        <?php   }
		}
	}
?>
