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
                    <th>SL </th>
                    <th>Month</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $bills = $admins->fetchindIvidualBill($id);
                $total = 0;
                if (isset($bills) && sizeof($bills) > 0){
                    foreach ($bills as $bill){
                        $total += $bill->amount;
                        $monthArray[]=$bill->r_month;
                        $bill_ids[]=$bill->id;
                        ?>
                    <tr>
                        <td><?=$bill->id?></td>
                        <td><?=$bill->r_month?></td>
                        <td><?=$bill->amount?></td>
                    </tr>
                <?php   } ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="2"> Net Total</th>
                    <th><?=$total?></th>
                </tr>
                <tr>
                    <th>In Words</td>
                    <th colspan="2"><?=getToText($total)?> Only.</th>
                </tr>
            </tfoot>
            <?php 
                } ?>
        </table>
    </div>
    <div class="row">
        <form class="form-inline" action="post_approve.php" method="POST">
            <input type="hidden" name="customer" value="<?=$info->id?>">			
            <input type="hidden" name="bills" value="<?=implode($bill_ids,',')?>">			
            <div class="form-group">
            <label for="months"></label>
            <select class="selectpicker" name="months[]" id="months" multiple required title="Select months">
                    <?php 
                        if (isset($monthArray) && sizeof($monthArray) > 0){ 
                        foreach ($monthArray as $month) { 
                            echo '<option value="'.$month.'">'.$month.'</option>';
                        }}
                    ?>
            </select>
            </div>
            <div class="form-group">
            <label class="sr-only" for="discount">Discount</label>
            <input type="number" class="form-control" name="discount" id="discount" placeholder="Discount" >
            </div>
            <div class="form-group">
            <label class="sr-only" for="total">Payment</label>
            <input type="number" class="form-control disabled" name="total" id="total" placeholder="total" required="" value="<?=$total?>">
            </div>
            <button type="submit" class="btn btn-primary">Paid</button>
        </form>
    </div>
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