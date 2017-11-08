<?php
	require_once 'includes/header.php';
	require_once "includes/classes/admin-class.php";
	$admins	= new Admins($dbh);
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
?>
	<div class="dashboard">
		<div class="col-md-12 col-sm-12">
		<div class="col-md-6"><h4><a href="bills.php" class="btn btn-sm btn-primary">  Back</a> Generated bills for Month of October</h4></div>
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
			<a href="bill_generation.php" class="btn btn-success pull-right">Generate Again</a> 
		</div>
		<br><br>
		</div>
		<div class="col-md-12 col-sm-12" id="bill_table">
			<table class="table table-striped table-bordered">
				<thead class="thead-inverse">
				  <tr>
				    <th>ID </th>
				    <th>Name</th>
				    <th>Months</th>
				    <th>Package</th>
				    <th>Amounts</th>
				    <th>Delete</th>
				  </tr>
				</thead>
			  <tbody>
			  <?php
			  $customers = $admins->fetchActiveCustomers();
			  if (isset($customers) && sizeof($customers) > 0){ 
			  	foreach ($customers as $customer) {
							$customer_id = $customer->id;
							$customer_name = $customer->full_name;
							$package_id = $customer->package_id;
							$packageInfo = $admins->getPackageInfo($package_id);
							$amount = $packageInfo->fee;
							$r_month = date('F');
							$payments = $admins->getLastMonth($customer_id);
							if(!empty($payments)){$last_month = $payments->r_month;}
								if(isset($last_month) && $last_month == $r_month){ ?>
									<tr>
										<td scope="row"><?=$customer_id?></td>
										<td colspan="5">Monthly bill of this month for <b><?=$customer_name?></b> was already generated !</td>
								</tr>
								<?php } else {
										if (!$admins->billGenerate($customer_id, $r_month, $amount)) 
										{    ?>
											<tr>
													<td scope="row"><?=$customer_id?></td>
													<td colspan="4">Bill genation for <?=$customer_name?> was not successful !</td>
													<td><button onClick=retry() type="button" class="btn btn-info">Retry</button></td>
											</tr>
											<?php
										}else { ?>
											<tr>
													<td scope="row"><?=$customer_id?></td>
													<td><?=$customer_name?></td>
													<td><?=$r_month?></td>
													<td><?=$packageInfo->name?></td>
													<td><?=$amount?></td>
													<td><button type="button" onClick=deleteBill() class="btn btn-info">Delete</button> <button onClick=editBill() type="button" class="btn btn-info">Edit</button></td>
											</tr>
									<?php }
								}
			  	 	?>
			  <?php
			  	}
			  } ?>
			  </tbody>
			</table>		
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