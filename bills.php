<?php
	// Start from getting the hader which contains some settings we need
	require_once 'includes/header.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	// Redirect visitor to the login page if he is trying to access
	// this page without being logged in
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>
			<!-- <button disabled="disabled" class="btn btn-success">Generate Now</button> -->
	<div class="dashboard">
		<div class="col-md-12 col-sm-12">
		<div class="col-md-6">
			<!-- <h4>Customer Billing: Month of October</h4> -->
			<a href='paid_bills.php' class="btn btn-primary">Paid Bills</a> 
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
			</form>
			<a href='bill_generation.php' class="btn btn-success pull-right">Generate Now</a> 
			
		</div>
		<br><br>
		
		</div>
		<div class="col-md-12 col-sm-12" id="bill_table">
			<?php
			  $billing = $admins->fetchBilling();
			  if (isset($billing) && sizeof($billing) > 0){ ?>
				<table class="table table-striped table-bordered">
				<thead class="thead-inverse">
				  <tr class="info">
				    <th>ID </th>
				    <th>Name</th>
				    <th>Generated on</th>
				    <th>Package</th>
				    <th>Months</th>
				    <th>Amounts</th>
				    <th>Payment / Receipt</th>
				  </tr>
				</thead>
			  <tbody>
				<?php
			  	foreach ($billing as $bill) {
			  		$client_id = $bill->customer_id;
			  		$customer_info = $admins->getCustomerInfo($client_id);
			  		$customer_name = $customer_info->full_name;
						$package_id = $customer_info->package_id;
						$packageInfo = $admins->getPackageInfo($package_id);
						$package_name = $packageInfo->name;
			  	 	?>
			  <tr>
			  	<td scope="row"><?=$bill->id?></td>
			  	<td><?=$customer_name?></td>
			  	<td><?=$bill->g_date?></td>
			  	<td><?=$package_name?></td>
			  	<td><?=$bill->months?></td>
			  	<td><?=$bill->total?></td>
			  	<td><button type="button" onClick=pay(<?=$client_id?>) class="btn btn-info">Pay</button> <button onClick=bill(<?=$client_id?>) type="button" class="btn btn-info">Bill</button></td>
			  </tr>
			  <?php
			  	}
				}else{
					?>
						<h1>Congratulations ! No due is left to be paid !</h1>
					<?php
				}
			?>
			  </tbody>
			</table>
			<div>
			</div>
			
		</div>
	</div>

	<?php include 'includes/footer.php'; ?>
	<script type="text/javascript">
		document.getElementById('date').valueAsDate = new Date();
		function pay(id) {
		let left = (screen.width/2)-(600/2);
  	let top = (screen.height/2)-(800/2);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=800,left=${left},top=${top}`;
		open('pay.php?customer='+id, 'Hello World !', params)
		}
		function bill(id) {
		let left = (screen.width/2)-(600/2);
  	let top = (screen.height/2)-(800/2);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=800,left=${left},top=${top}`;
		open('bill.php?customer='+id, 'Hello World !', params)
		}
	</script>