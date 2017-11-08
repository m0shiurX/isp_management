+<?php include 'includes/header.php'; ?>
<?php
	require_once "includes/classes/admin-class.php";
    $admins	= new Admins($dbh);
    if(isset($_POST['for'])){
        //$date = $_POST['date'];
        $amount = $_POST['amount'];
        $for = $_POST['for'];
        $remarks = $_POST['remarks'];
        if(!$admins->expanse($amount, $for, $remarks)){
            echo "Something went wrong ! Try again later.";
        }else{
            echo "Expanse added !";
        }
    }
?>
<div class="dashboard">
	<div class="col-md-12">
    <div class="col-md-9">
       <h3><a href="daily_data.php" class="btn btn-sm btn-primary"> Back</a> Expanse History</h3>
    </div>
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
                        <td class="search"><?=date("jS F y",strtotime($exp->created_at))?></td>
                        <td class="search"><?=$exp->amount?></td>
                        <td class="search"><?=$exp->purpose?></td>
                        <td class="search"><?=$exp->remarks?></td>
                        <td><button type="button" data-id="<?=$exp->id?>" class="btn btn-danger btn-sm delete disabled">DELETE</button></td>
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