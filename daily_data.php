<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (isset($_POST['quantity'])) {
		$proselect = $_POST['proselect'];
		$quantity = $_POST['quantity'];
		$date = $_POST['date'];
		$provider = $_POST['provider'];
		$recipient = $_POST['recipient'];
		$remarks = $_POST['remarks'];
		$type = $_POST['type'];
		if (!$admins->cashCollect($quantity, $date, $provider, $recipient, $remarks, $type)) 
		{
			$msg = "<i class=\"warning\">Sorry Data could not be inserted !</i>";
		}else {
			$msg =  "<i class=\"success\">Well! You've successfully inserted new data!</i>";
		}
	}
	$page = isset($_GET[ 'p' ])?$_GET[ 'p' ]:'';
	if($page == 'del'){
			$id = $_POST['id'];
			if (!$admins->deleteProduction($id)) 
			{
				$msg = "Sorry Data could not be deleted !";
			}else {
				$msg =  "Well! You've successfully deleted a product!";
			}
	}
?>
<!-- Income products -->
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h4>Cash Collection : <a href="collection.php" class="btn btn-default btn-sm "> Get all History </a><?php if (isset($msg)) {echo "$msg";} ?></h4>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form class="form-inline" action="collection.php" method="POST">
						<!-- <input type="hidden" name="recipient" value="">			 -->
						<!-- <div class="form-group">
							<label for="proselect"></label>
							<select class="form-control select-form-control" name="proselect" id="proselect" required disabled>
								<option selected disabled value="" ="">Select an option</option>
										<?php 
											//$collection = $admins->fetchCollection();
											//if (isset($collection) && sizeof($collection) > 0){ 
											//foreach ($collection as $collect) { 
											//}}
										?>
							</select>
						</div> -->
					<div class="form-group">
						<label class="sr-only" for="date">Date</label>
						<input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d"); ?>">
					</div>
					<div class="form-group">
						<label class="sr-only" for="amount">Amount</label>
						<input type="number" class="form-control" name="amount" placeholder="Amount" required="">
					</div>
					<div class="form-group">
						<label class="sr-only" for="from">From</label>
						<input type="text" class="form-control" name="from" placeholder="From" required="">
					</div>
					<div class="form-group">
						<label class="sr-only" for="remarks">Remarks</label>
						<input type="textarea" class="form-control" name="remarks" placeholder="Remarks" >
					</div>
					  <button type="submit" class="btn btn-primary">Collect</button>
					</form>
					<br>
				<table id="grid-basic" class="table table-striped table-bordered">
						<thead class="thead-inverse">
							<tr class="info">
								<th>ID </th>
								<th>Date</th>
								<th>Amount</th>
								<th>From</th>
								<th>Remarks</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$collection = $admins->fetchCollectin();
							if (isset($collection) && sizeof($collection) > 0){ 
							foreach($collection as $collect) {
							?>
							<tr>
								<td><?=$collect->id?></td>
								<td><?=date("jS F y",strtotime($collect->created_at))?></td>
								<td><?=$collect->amount?></td>
								<td><?=$collect->payee?></td>
								<td><?=$collect->remarks?></td>
								<td><button type="button" data-id="<?=$collect->id?>" class="btn btn-danger btn-sm delete disabled">DELETE</button></td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>



<!-- Expanse products -->
<div class="col-md-12 col-sm-12">
	<div class="panel panel-default">
		<div class="panel-heading">
		<h4>Expanse :  <a href="expanse.php" class="btn btn-default btn-sm "> Get all History </a><?php if (isset($msg)) {echo "$msg";} ?></h4>
		</div>
		<div class="panel-body">
			<div class="col-md-12">
				<form class="form-inline" action="expanse.php" method="POST">
						<!-- <input type="hidden" name="recipient" value="">			 -->
						<!-- <div class="form-group">
							<label for="proselect"></label>
							<select class="form-control select-form-control" name="proselect" id="proselect" required disabled>
								<option selected disabled value="" ="">Select an option</option>
								<?php 
									//$collection = $admins->fetchCollection();
									//if (isset($collection) && sizeof($collection) > 0){ 
									//foreach ($collection as $collect) { 
									//}}
								?>
							</select>
						</div> -->
						<div class="form-group">
							<label class="sr-only" for="date">Date</label>
							<input type="date" class="form-control" name="date" value="<?php echo date("Y-m-d"); ?>">
						</div>
						<div class="form-group">
							<label class="sr-only" for="amount">Amount</label>
							<input type="number" class="form-control" name="amount" placeholder="Amount" required="">
						</div>
						<div class="form-group">
							<label class="sr-only" for="for">For/To</label>
							<input type="text" class="form-control" name="for" placeholder="For/To" required="">
						</div>
						<div class="form-group">
							<label class="sr-only" for="remarks">Remarks</label>
							<input type="textarea" class="form-control" name="remarks" placeholder="Remarks" >
						</div>
					<button type="submit" class="btn btn-primary">Expanse</button>
				</form>
				<br>
			<table id="grid-basic" class="table table-striped table-bordered" id="grid-basic">
					<thead class="thead-inverse">
						<tr class="info">
							<th>ID </th>
							<th>Date</th>
							<th>Amount</th>
							<th>Purpose</th>
							<th>Remarks</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$expanse = $admins->fetchExpanse();
						if (isset($expanse) && sizeof($expanse) > 0){ 
							foreach($expanse as $exp) {
							?>
							<tr>
								<td><?=$exp->id?></td>
								<td><?=date("jS F y",strtotime($exp->created_at))?></td>
								<td><?=$exp->amount?></td>
								<td class="search"><?=$exp->purpose?></td>
								<td><?=$exp->remarks?></td>
								<td><button type="button" data-id="<?=$exp->id?>" class="btn btn-danger btn-sm delete disabled">DELETE</button></td>
							</tr>
						<?php }} ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
	$('table').on('click', '.delete', function(e){
		var id = $(this).attr("data-id");
		var tr = $(this).closest("tr");
			$.ajax({
				method:"POST",
				url: "collection.php?p=del",
				data: "id="+id,
				success: function (data){
					//alert(id);
					//$tr.remove();
				}
			});
	    $(this).closest('tr').fadeOut(500);
	});
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