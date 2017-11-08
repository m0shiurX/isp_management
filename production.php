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
		if (!$admins->insertProductData($proselect, $quantity, $date, $provider, $recipient, $remarks, $type)) 
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
<!-- Recieve products -->
	<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h5>Recieve Products : <?php if (isset($msg)) {echo "$msg";} ?></h5>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form class="form-inline" action="production.php" method="POST">
					<input type="hidden" name="type" value="1">			
					<input type="hidden" name="recipient" value="">			
					  <div class="form-group">
				      <label for="proselect"></label>
				      <select class="form-control select-form-control" name="proselect" id="proselect" required>
				      	<option selected disabled value="" ="">Select a product</option>
								<?php $products = $admins->fetchProducts();
									if (isset($products) && sizeof($products) > 0){ 
									foreach ($products as $product) { ?>
									<option value='<?=$product->pro_id?>'><?=$product->pro_name?></option>
								<?php }} ?>
				      </select>
				      </div>
				      <div class="form-group">
				        <label class="sr-only" for="date">Date</label>
				        <input type="date" class="form-control" name="date" id="date" value="<?php echo date("Y-m-d"); ?>">
				      </div>
				      <div class="form-group">
				        <label class="sr-only" for="quantity">Quantity</label>
				        <input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" required="">
				      </div>
				      <div class="form-group">
				        <label class="sr-only" for="provider">Provider</label>
				        <input type="text" class="form-control" name="provider" id="provider" placeholder="prodiver" required="">
				      </div>
				      <div class="form-group">
				        <label class="sr-only" for="remarks">Remarks</label>
				        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks" >
				      </div>
					  <button type="submit" class="btn btn-primary">RECEIVE</button>
					</form>
					<br>
				<table id="grid-basic" class="table table-striped table-bordered">
						<thead class="thead-inverse">
							<tr class="info">
								<th data-column-id="id" data-type="numeric">ID </th>
								<th data-column-id="date" data-type="date">Date</th>
								<th data-column-id="name" data-type="text">Product Name</th>
								<th data-column-id="production" data-type="numeric">Quantity</th>
								<th data-column-id="finished" data-type="text">Provider</th>
								<th data-column-id="unfinished" data-type="text">Remarks</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$products = $admins->fetchProduction();
							if (isset($products) && sizeof($products) > 0){ 
							foreach($products as $product) {
								$proID = $product->product_id;
								$proName = $admins->getAProduct($proID);
								$product_name = $proName->pro_name;
							?>
							<tr>
								<td><?=$product->id?></td>
								<td><?=date("jS F y",strtotime($product->cdate))?></td>
								<td><?php echo $product_name; ?></td>
								<td><?=$product->quantity?></td>
								<td><?=$product->provider?></td>
								<td><?=$product->remarks?></td>
								<td><button type="button" data-id="<?=$product->id?>" class="btn btn-danger btn-sm delete">DELETE</button></td>
							</tr>
						<?php }} ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>



<!-- Send products -->
<div class="col-md-12 col-sm-12">
		<div class="panel panel-default">
			<div class="panel-heading">
			<h5>Send Products : <?php if (isset($msg)) {echo "$msg";} ?></h5>
			</div>
			<div class="panel-body">
				<div class="col-md-12">
					<form class="form-inline"  action="production.php" method="POST">
								<input type="hidden" name="type" value="0">
								<input type="hidden" name="provider" value="">											
					  <div class="form-group">
				      <label for="proselect"></label>
				      <select class="form-control select-form-control" name="proselect" id="proselect" required>
				      		<option selected disabled value="" ="">Select a product</option>
							<?php $products = $admins->fetchProducts();
								if (isset($products) && sizeof($products) > 0){ 
								foreach ($products as $product) { ?>
								<option value='<?=$product->pro_id?>'><?=$product->pro_name?></option>
							<?php }} ?>
				      </select>
				      </div>
				      <div class="form-group">
							<label class="sr-only" for="date">Date</label>
							<input type="date" class="form-control" name="date" id="date" value="<?php echo date("Y-m-d");?>">
						</div>
						<div class="form-group">
							<label class="sr-only" for="quantity">Quantity</label>
							<input type="number" class="form-control" name="quantity" id="quantity" placeholder="Quantity" required="">
						</div>
						<div class="form-group">
							<label class="sr-only" for="recipient">Recipient</label>
							<input type="text" class="form-control" name="recipient" id="recipient" placeholder="recipient" required="">
						</div>
						<div class="form-group">
							<label class="sr-only" for="remarks">Remarks</label>
							<input type="text" class="form-control" name="remarks" id="remarks" placeholder="Remarks" >
						</div>
					  <button type="submit" class="btn btn-primary">SEND</button>
					</form>
					<br>
				<table id="grid-basic" class="table table-striped table-bordered">
						<thead class="thead-inverse">
							<tr class="info">
								<th data-column-id="id" data-type="numeric">ID </th>
								<th data-column-id="date" data-type="date">Date</th>
								<th data-column-id="name" data-type="text">Product Name</th>
								<th data-column-id="production" data-type="numeric">Quantity</th>
								<th data-column-id="unfinished" data-type="text">Recipient</th>
								<th data-column-id="unfinished" data-type="text">Remarks</th>
								<th data-column-id="commands" data-formatter="commands" data-sortable="false">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$products = $admins->fetchProductionSend();
							if (isset($products) && sizeof($products) > 0){ 
							foreach($products as $product) {
								$proID = $product->product_id;
								$proName = $admins->getAProduct($proID);
								$product_name = $proName->pro_name;
							?>
							<tr>
								<td><?=$product->id?></td>
								<td><?=date("jS F y",strtotime($product->cdate))?></td>
								<td><?php echo $product_name; ?></td>
								<td><?=$product->quantity?></td>
								<td><?=$product->recipient?></td>
								<td><?=$product->remarks?></td>
								<td><button type="button" data-id="<?=$product->id?>" class="btn btn-danger btn-sm delete">DELETE</button></td>
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
				url: "production.php?p=del",
				data: "id="+id,
				success: function (data){
					//alert(id);
					//$tr.remove();
				}
			});
	    $(this).closest('tr').fadeOut(500);
	});
</script>