<!-- Bar Chart -->
<?php
// Calculate the date range for the last 6 months including the current month
$start_date = date("Y-m-01", strtotime("-6 months")); // First day of 6 months ago
$end_date = date("Y-m-t"); // Last day of the current month

// Query to fetch totalPrice for each month within the calculated range
$sql_bar_chart = "SELECT DATE_FORMAT(paymentDate, '%Y-%m') AS month, SUM(totalPrice) AS total_revenue 
                  FROM payment 
                  WHERE paymentDate BETWEEN '$start_date' AND '$end_date'
                  GROUP BY month
                  ORDER BY month ASC";

$result_bar_chart = $conn->query($sql_bar_chart);

// Prepare data for the bar chart
$labels_bar = [];
$data_bar = [];

// Generate all months within the range to ensure gaps are filled with 0 revenue
$months = [];
for ($i = 6; $i >= 0; $i--) {
    $months[] = date("Y-m", strtotime("-$i months"));
}

$month_revenue = [];
if ($result_bar_chart->num_rows > 0) {
    while ($row = $result_bar_chart->fetch_assoc()) {
        $month_revenue[$row['month']] = $row['total_revenue'];
    }
}

// Populate labels and data arrays
foreach ($months as $month) {
    $labels_bar[] = date("M Y", strtotime($month . "-01"));
    $data_bar[] = $month_revenue[$month] ?? 0; // Default to 0 if no data for a month
}

// Convert the data to JSON for use in JavaScript
$labels_bar_json = json_encode($labels_bar);
$data_bar_json = json_encode($data_bar);
?>

<script>
    function renderBarChart() {
        var ctx = document.getElementById("myBarChart");
        var myBarChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: <?php echo $labels_bar_json; ?>,  // Labels for the last 6 months
                datasets: [{
                    label: "Revenue",
                    backgroundColor: [
                        "rgba(255, 99, 132, 0.8)",  // Red
                        "rgba(54, 162, 235, 0.8)", // Blue
                        "rgba(255, 206, 86, 0.8)",  // Yellow
                        "rgba(75, 192, 192, 0.8)",  // Green
                        "rgba(153, 102, 255, 0.8)", // Purple
                        "rgba(255, 159, 64, 0.8)",  // Orange
                        "rgba(201, 203, 207, 0.8)"  // Grey
                    ],
                    borderColor: [
                        "rgba(255, 99, 132, 1)",
                        "rgba(54, 162, 235, 1)",
                        "rgba(255, 206, 86, 1)",
                        "rgba(75, 192, 192, 1)",
                        "rgba(153, 102, 255, 1)",
                        "rgba(255, 159, 64, 1)",
                        "rgba(201, 203, 207, 1)"
                    ],
                    borderWidth: 1,
                    data: <?php echo $data_bar_json; ?>,  // Data for the last 6 months
                }],
            },
            options: {
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,  // Start y-axis from 0
                            max: Math.max(...<?php echo $data_bar_json; ?>) || 10,  // Dynamic y-axis max value
                            maxTicksLimit: 10
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
