+<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
?>
<div class="dashboard">
	<div class="col-md-12 col-sm-12">
	<h2 class="col-md-3">Products Stock</h2>
	<br><br>
	<div class="col-md-3 pull-right">
		<form class="form-inline  pull-right">
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
	<hr>
	<div class="col-md-12 col-sm-12">
		<table class="table center table-striped table-bordered" id="grid-basic">
			<thead class="thead-inverse">
			  <tr class="info">
			    <th>Product ID</th>
			    <th>Product Name</th>
			    <th>Category</th>
			    <th>Details</th>
			    <th>Quantity</th>
			    <th>Action</th>
			  </tr>
			</thead>
		  <tbody>
		  	<?php 
		  	$products = $admins->fetchProductionStats();
		  	if (isset($products) && sizeof($products) > 0){ 
		  	foreach ($products as $product) {
		  		$proID = $product->product_id;
		  		$proName = $admins->getAProduct($proID);
		  		$product_name = $proName->pro_name;
		  		$product_details = $proName->pro_details;
		  		$product_category = $proName->pro_category;
		  	?>
		    <tr>
		    	<td><?=$product->product_id?></td>
		    	<td class="search"><?php echo $product_name; ?></td>
		    	<td class="search"><?php echo $product_category; ?></td>
		    	<td><?php echo $product_details; ?></td>
		    	<td><?=$product->quantity?></td>
		    	<td><button type="submit" class="btn btn-info">LEDGER</button></td>
		    </tr>
		  <?php }} ?>
		  </tbody>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
	document.getElementById('date').valueAsDate = new Date();
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