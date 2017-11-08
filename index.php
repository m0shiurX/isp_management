<?php include 'includes/header.php'; ?>
<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
        Expance &amp; Cash Collection Chart: Last 7 days
        </div>
        <div class="panel-body">
            <canvas id="myChart">
					
				</canvas>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
        Monthly Bill Collection : 2017
        </div>
        <div class="panel-body">
            <canvas id="chart2">
					
				</canvas>
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="panel panel-default">
        <div class="panel-heading">
        Product Stock
        </div>
        <div class="panel-body">
            <canvas id="myChart2">
				
			</canvas>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Sat', 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
            datasets: [{
                label: 'Cash Collection',
                data: [12, 19, 3, 17, 6, 3, 7],
                backgroundColor: "rgba(153,255,51,0.6)"
            }, {
                label: 'Expance',
                data: [2, 29, 5, 5, 2, 3, 10],
                backgroundColor: "rgba(245,0,0,0.6)"
            }]
        }
    });
    var ctx = document.getElementById('chart2').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Monthly Bill Collection',
                data: [50000, 60000, 30000, 45000, 48000, 38000, 80000, 20000, 0],
                backgroundColor: "rgba(0,255,51,0.6)"
            }]
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            url: "chart.php",
            method: "GET",
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                var raw = [];
                var qty = [];

                for (var i in data) {
                    raw.push(data[i].name);
                    qty.push(data[i].quantity);
                }
                console.log(raw);
                console.log(qty);
                var chartdata = {
                    labels: raw,
                    datasets: [{
                        label: 'Product Stock',
                        backgroundColor: 'rgba(0,200,225,.5)',
                        borderColor: 'rgba(200, 200, 200, 0.75)',
                        hoverBackgroundColor: 'rgba(200, 200, 200, 1)',
                        hoverBorderColor: 'rgba(200, 200, 200, 1)',
                        data: qty
                    }]
                };

                var ctx = $('#myChart2');

                var barGraph = new Chart(ctx, {
                    type: 'bar',
                    data: chartdata
                    // options: {
                    //     scales: {
                    //         yAxes: [{
                    //             ticks: {
                    //                 // Create scientific notation labels
                    //                 callback: function(value, index, values) {
                    //                     return value.toExponential();
                    //                 }
                    //             }
                    //         }]
                    //     }
                    // }
                });
            },
            error: function(data) {
                console.log(data);
            }
        });
    });

</script>
