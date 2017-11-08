<?php
	require_once "includes/headx.php";
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
	require_once "includes/classes/admin-class.php";
    $admins	= new Admins($dbh);
    ?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset=" utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="component/css/bootstrap.css"> <!-- CSS bootstrap -->
	<link rel="stylesheet" href="component/css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="component/css/reset.css"> <!-- Resource style -->
	<link rel="stylesheet" href="component/css/invoice.css"> <!-- CSS bootstrap -->    
	<script src="component/js/modernizr.js"></script> <!-- Modernizr -->
	<title>Categories | Netway</title>
</head>
<body>
<div class="container">
    <div class="row">
        <br>
        <button class="btn btn-success" data-toggle="modal" data-target="#add_category">Add new Packages</button>
		<button class="btn btn-danger pull-right" onclick="window.opener.location.reload();window.close();">Close</button>
    </div>
    <div class="row">
        <table class="table table-striped table-bordered">
            <thead class="thead-inverse">
                <tr>
                    <th>SL </th>
                    <th>Name</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
    <div class="message">Do not remove categories.</div>
</div>
	<!-- New modal -->
	<div class="modal fade" id="add_category">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">×</button>
					<h4>Category details</h4>
				</div>
				<form id="insert_form" method="POST">
					<div class="modal-body">
                        <fieldset>
                            <div class="form-group has-success">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                            </div>
                        </fieldset>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary">Submit</button>
						<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
					</div>
				</form>
		  </div>
		</div>
	</div>
</body>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">

		$('#insert_form').on('submit',function(event){
			event.preventDefault();
			$.ajax({
				url: "categories_approve.php?p=add",
				method:"POST",
				data:$('#insert_form').serialize(),
				success: function (data) {
					$('#insert_form')[0].reset();
					$('#add_category').modal('hide');
						viewData();
				}
			});
		});
		function viewData() {
			$.ajax({
				method: "GET",
				url:"categories_approve.php",
				success: function(data){
					$('tbody').html(data);
				}
			});
		}
		function delData(del_id){
			var id = del_id;
			$.ajax({
				method:"POST",
				url: "categories_approve.php?p=del",
				data: "id="+id,
				success: function (data){
					viewData();
				}
			});
		}
		function upData(str){
			var name = $('#nm-'+str).val();
			var id = str;
			$.ajax({
				method:"POST",
				url: "categories_approve.php?p=edit",
				data: "name="+name+"&id="+id,
				success: function (data){
					$('#edit-'+str).modal('hide');                    
					viewData();
				}
			});
		}
		window.onload=viewData();
	</script>