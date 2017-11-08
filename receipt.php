<?php
	require_once "includes/headx.php";
	if (!isset($_SESSION['admin_session']) )
	{
		$commons->redirectTo(SITE_PATH.'login.php');
	}
	require_once "includes/classes/admin-class.php";
    $admins	= new Admins($dbh);
    $id = isset($_GET[ 'customer' ])?$_GET[ 'customer' ]:''; 
    ?>
<!doctype html>
<html lang="en" class="no-js">
<head>
	<meta charset=" utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="component/css/bootstrap.css"> <!-- CSS bootstrap -->
	<link rel="stylesheet" href="component/css/bootstrap-select.min.css"> <!-- CSS bootstrap -->
	<link rel="stylesheet" href="component/css/style.css"> <!-- Resource style -->
    <link rel="stylesheet" href="component/css/reset.css"> <!-- Resource style -->
	<link rel="stylesheet" href="component/css/invoice.css"> <!-- CSS bootstrap -->    
	<script src="component/js/modernizr.js"></script> <!-- Modernizr -->
	<title>Invoice | Netway</title>
</head>
<body>
<div class="container">
        <?php
            $info = $admins->getCustomerInfo($id); 
            if (isset($info) && sizeof($info) > 0) {
            $package_id = $info->package_id;
            $packageInfo = $admins->getPackageInfo($package_id);
        ?>
    <div class="row">
        <div class="brand"><img src="component/img/logo.png" alt=""></div>
        <div class="pull-right">Date: <?=date("jS F y")?></div><br>
        <div class="em"><b>Name   : </b> <em><?=$info->full_name?></em></div>
        <div class="em"><b>Address:</b> <em><?=$info->address ?></em></div>
        <div class="em"><b>Contact :</b> <em><?=$info->contact ?></em> </div>
        <div class="em"><b>Package:</b> <em><?=$packageInfo->name?></em> </div>
        <div class="em"><b>IP address:</b> <em><?=$info->ip_address?></em></div>
        <span class="message pull-right">Last payment date : <?=date("jS F y",strtotime("+7 day"))?></span>
    </div>
        <?php } ?>
        <div class="row">
        <table class="table table-striped table-bordered">
            <thead class="thead-inverse">
                <tr>
                    <th>Payment ID </th>
                    <th>Bills</th>
                    <th>Months</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $bills = $admins->fetchPaymentSlip($id);
                    if (isset($bills) && sizeof($bills) > 0){
                ?>
                <tr>
                    <td><?=$bills->id?></td>
                    <td><?=$bills->bill_id?></td>
                    <td><?=$bills->bill_month?></td>
                    <td><?=$bills->bill_amount?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>In Words</td>
                    <th colspan="3"><?=getToText($bills->bill_amount)?> Only.</th>
                </tr>
            </tfoot>
            <?php 
                } ?>
        </table>
    </div>
    <div class="printbutton hide-on-small-only pull-left"><a href="#" onClick="javascript:window.print()">Print</a></div>
    <div class="sign pull-right">Authorized Signature</div>
</div>
</body>
<?php include 'includes/footer.php'; ?>
<script src="component/js/bootstrap-select.min.js"></script>
<script>
    $('#months').on('changed.bs.select', function (e) {
        console.log(this.value);
      });
</script>