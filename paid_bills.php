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
		<div class="col-md-6"><h4><a href="bills.php" class="btn btn-sm btn-primary">  Back</a> Paid bills for Month of November</h4></div>
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
			<!-- <a href="bill_generation.php" class="btn btn-success pull-right">Generate Again</a>  -->
		</div>
		<br><br>
		</div>
		<div class="col-md-12 col-sm-12" id="bill_table">
			<table class="table table-striped table-bordered">
				<thead class="thead-inverse">
				  <tr class="info">
				    <th>ID </th>
				    <th>Name</th>
				    <th>Package</th>
				    <th>Months</th>
				    <th>Amounts</th>
				    <th>Reciept</th>
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
                            $package_name = $packageInfo->name;
                            
                            $bills = $admins->fetchPaymentSlip($customer_id);
                            if (isset($bills) && sizeof($bills) > 0 && !empty($bills)){
                            ?>
                            <tr>
                                <td><?=$customer_id?></td>
                                <td><?=$customer_name?></td>
                                <td><?=$package_name?></td>
                                <td><?=$bills->bill_month?></td>
                                <td><?=$bills->bill_amount?></td>
                                <td><button onclick="getReceipt(<?=$customer_id?>)" class="btn btn-primary">Receipt</button></td>
                            </tr>
					<?php	}else{
                        //echo "No Bills yet paid !";
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
    <script>
    function getReceipt(id) {
		let left = (screen.width/2)-(600/2);
  	    let top = (screen.height/2)-(800/2);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,width=600,height=800,left=${left},top=${top}`;
		open('receipt.php?customer='+id, 'Payment Receipt !', params)
		}
    </script>