<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';

	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>
		<?php
			require_once "includes/classes/admin-class.php";
			$admins = new Admins($dbh);
		?>

	<div class="dashboard">		

	<div class="col-md-12 col-sm-12" id="employee_table">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h4>Employeer</h4>
			</div>
			<div class="panel-body">
				<div class="col-md-6">
				<button type="button" name="add" id="add" class="btn btn-info" data-toggle="modal" data-target="#add_data_Modal">ADD</button>
				</div>
				<div class="col-md-6">
					<form class="form-inline pull-right">
					  <div class="form-group">
					    <label class="sr-only" for="search">Search for</label>
					    <div class="input-group">
					      <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
					      <input type="text" class="form-control" id="search" placeholder="Type a name">
					      <div class="input-group-addon"></div>
					    </div>
					  </div>
					  <!-- <button type="submit" class="btn btn-info">Search</button> -->
					</form>
				</div>
				<?php if ( isset($_SESSION['errors']) ) {?>
				<div class="pannel panel-warning">
					<?php foreach ($_SESSION['errors'] as $error):?>
						<li><?= $error ?></li>
					<?php endforeach ?>
				</div>
				<?php session::destroy('errors');
				} ?>
			</div>
		<table class="table table-striped" id="grid-basic">
			<thead class="thead-inverse">
			  <tr class="info">
			    <th>ID </th>
			    <th>Action</th>
			    <th>Username</th>
			    <th>Name</th>
			    <th>Email</th>
			    <th>Cellphone</th>
			    <th>Address</th>
			  </tr>
			</thead>
		  <tbody>
		  </tbody>
		</table>
	</div>
	</div>
	<!-- invisible content -->
	<!-- Insert modal for users -->
	<div id="add_data_Modal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4>Insert Data</h4>
				</div>
					<form action="" method="POST" id="insert_form">
				<div class="modal-body">
					    <!-- form content -->
					      <div class="form-group">
					        <label for="username">Username</label>
					        <input type="username" class="form-control" id="username" name="username" aria-describedby="emailHelp" placeholder="Username" required>
					      </div>
					      <div class="form-group">
					        <label for="password">Password</label>
					        <input type="password" class="form-control" id="password" name="password" placeholder="Password"  required>
					      </div>
					      <div class="form-group">
					        <label for="repassword">Re enter Password</label>
					        <input type="password" class="form-control" id="repassword" name="repassword" placeholder="Re enter password"  required>
					      </div>
					      <div class="form-group">
					        <label for="email">Email</label>
					        <input type="text" class="form-control" id="email" name="email" placeholder="Email Address"  required>
					      </div>
					      <div class="form-group">
					        <label for="fullname">Full Name</label>
					        <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Full Name"  required>
					      </div>

					      <div class="form-group">
					        <label for="address">Address</label>
					        <input type="textarea" class="form-control" id="address" name="address" placeholder="Address">
					      </div>

					      <div class="form-group">
					        <label for="contact">Contact</label>
					        <input type="tel" class="form-control" id="contact" name="contact" placeholder="Contact">
					      </div>
				</div>
				<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
					<a href="#" class="btn btn-warning" data-dismiss="modal">Cancel</a>
				</div>
					</form>
			</div>
		</div>		
	</div>

	<?php
	include 'includes/footer.php';
	?>
	<script type="text/javascript">
	$('#insert_form').on('submit',function(event){
		event.preventDefault();
		$.ajax({
			url: "user_approve.php?p=add",
			method:"POST",
			data:$('#insert_form').serialize(),
			success: function (data) {
				$('#insert_form')[0].reset();
				$('#add_data_Modal').modal('hide');
				viewData();
			}
		});
	});
	function viewData() {
		$.ajax({
			method: "GET",
			url:"user_approve.php",
			success: function(data){
				$('tbody').html(data);
			}
		});
	}
	function delData(del_id){
		var id = del_id;
		$.ajax({
			method:"POST",
			url: "user_approve.php?p=delta",
			data: "id="+id,
			success: function (data){
				viewData();
			}
		});
	}
	function updateData(str){
		var user_id = str;
		var username = $('#usr-'+str).val();
		var full_name = $('#fnm-'+str).val();
		var email = $('#em-'+str).val();
		var contact = $('#con-'+str).val();
		var address = $('#ad-'+str).val();
		$.ajax({
			method:"POST",
			url: "user_approve.php?p=edit",
			data: "username="+username+"&full_name="+full_name+"&email="+email+"&contact="+contact+"&address="+address+"&user_id="+user_id,
			//console.log(data);
			success: function (data){
				viewData();
			}
		});
	}
	window.onload = viewData();
	</script>
	<script type="text/javascript">
	  $(function() {
	    grid = $('#grid-basic');

	    // handle search fields of members key up event
	    $('#search').keyup(function(e) { 
	      text = $(this).val(); // grab search term

	      if(text.length > 1) {
	        grid.find('tr:has(td)').hide(); // hide data rows, leave header row showing

	        // iterate through all grid rows
	        grid.find('tr').each(function(i) {
	          // check to see if search term matches Name column
	          if($(this).find('.search').text().toUpperCase().match(text.toUpperCase()))
	            $(this).show(); // show matching row
	        });
	      }
	      else 
	        grid.find('tr').show(); // if no matching name is found, show all rows
	    });
	    
	  }); 
	</script>