<!-- Area Chart -->
<?php
// Query to fetch payment data for the last 13 days, even for days with no payments
$sql_area_chart = "
    SELECT DATE(paymentDate) AS payment_date, COUNT(*) AS total_amount 
    FROM payment 
    WHERE paymentDate >= CURDATE() - INTERVAL 13 DAY
    GROUP BY DATE(paymentDate)
    ORDER BY payment_date ASC
";

// Get the results from the database
$result_area_chart = $conn->query($sql_area_chart);

// Prepare data for the area chart
$labels_area = [];
$data_area = [];
for ($i = 13; $i >= 0; $i--) {
    $date = date("Y-m-d", strtotime("-$i days"));  // Calculate the date for the last 13 days
    $labels_area[] = date("M j", strtotime($date));  // Format as "Nov 28"
    $data_area[$date] = 0;  // Initialize data array with zero for each day
}

// Fetch the actual payment data
if ($result_area_chart->num_rows > 0) {
    while ($row = $result_area_chart->fetch_assoc()) {
        $paymentDate = $row['payment_date'];
        $totalAmount = $row['total_amount'];
        $data_area[$paymentDate] = $totalAmount;  // Update the data with actual payment count for the day
    }
} else {
    echo "0 results for area chart";
}

// Convert the data to JSON for use in the JavaScript
$labels_area_json = json_encode($labels_area);
$data_area_json = json_encode(array_values($data_area));

?>
<script>
    // Area Chart Example (JavaScript code for rendering)
    function renderAreaChart() {
        var ctx = document.getElementById("myAreaChart");
        var myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo $labels_area_json; ?>,  // Using PHP data for labels
                datasets: [{
                    label: "Total Payments",
                    lineTension: 0.3,
                    backgroundColor: "rgba(2,117,216,0.2)",
                    borderColor: "rgba(2,117,216,1)",
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(2,117,216,1)",
                    pointBorderColor: "rgba(255,255,255,0.8)",
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(2,117,216,1)",
                    pointHitRadius: 50,
                    pointBorderWidth: 2,
                    data: <?php echo $data_area_json; ?>,  // Using PHP data for the chart data
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            min: 0,
                            max: Math.max(...<?php echo $data_area_json; ?>),  // Dynamic y-axis max value based on data
                            maxTicksLimit: 5,
                            callback: function (value, index, values) {
                                return Math.round(value);
                            }
                        },
                        gridLines: {
                            color: "rgba(0, 0, 0, .125)",
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    renderAreaChart();
</script>