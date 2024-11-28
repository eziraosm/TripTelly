<!-- Bar Chart -->
<?php
// Query to fetch totalPrice for each month for the last 6 months
$sql_bar_chart = "SELECT DATE_FORMAT(paymentDate, '%Y-%m') AS month, SUM(totalPrice) AS total_revenue 
                  FROM payment 
                  WHERE paymentDate >= CURDATE() - INTERVAL 6 MONTH
                  GROUP BY month
                  ORDER BY month ASC";

$result_bar_chart = $conn->query($sql_bar_chart);

// Prepare data for the bar chart
$labels_bar = [];
$data_bar = [];
if ($result_bar_chart->num_rows > 0) {
    while ($row = $result_bar_chart->fetch_assoc()) {
        $labels_bar[] = date("M Y", strtotime($row['month'] . "-01"));
        $data_bar[] = $row['total_revenue'];
    }
} else {
    // Default values if no results are returned
    $labels_bar = ["Nov 2024", "Oct 2024", "Sep 2024", "Aug 2024", "Jul 2024", "Jun 2024"];
    $data_bar = [0, 0, 0, 0, 0, 0];
}

// Convert the data to JSON for use in the JavaScript
$labels_bar_json = json_encode($labels_bar);
$data_bar_json = json_encode($data_bar);
?>
<script>
    // Bar Chart Example (JavaScript code for rendering)
    function renderBarChart() {
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $labels_bar_json; ?>,  // Using PHP data for labels (last 6 months)
                datasets: [{
                    label: "Revenue",
                    backgroundColor: "rgba(2,117,216,1)",
                    borderColor: "rgba(2,117,216,1)",
                    data: <?php echo $data_bar_json; ?>,  // Using PHP data for the chart data (totalPrice sum)
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 6
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,  // Start the y-axis from 0
                            max: Math.max(...<?php echo $data_bar_json; ?>),  // Dynamic y-axis max value based on data
                            maxTicksLimit: 5
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                },
                legend: {
                    display: false
                }
            }
        });
    }

    renderBarChart();
</script>