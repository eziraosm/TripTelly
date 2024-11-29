// Function to update data on the page
function updateData() {
	// Fetch the total visitor count
	$.ajax({
		url: "fn_ajaxHandler.php",
		method: "GET",
		data: { action: "getTotalVisitors" },
		success: function (data) {
			$("#visitorCount").html(data + " Users");
		},
		error: function (xhr, status, error) {
			console.error("Error fetching visitor count:", error);
		},
	});

	// Fetch the total sales
	$.ajax({
		url: "fn_ajaxHandler.php",
		method: "GET",
		data: { action: "getTotalSales" },
		success: function (data) {
			$("#salesCount").html("RM" + data); // Assuming sales are in dollars
		},
		error: function (xhr, status, error) {
			console.error("Error fetching sales data:", error);
		},
	});

	// Fetch the most popular location
	$.ajax({
		url: "fn_ajaxHandler.php",
		method: "GET",
		data: { action: "getMostPopularLocation" },
		success: function (data) {
			$("#popularLocation").html(data);
		},
		error: function (xhr, status, error) {
			console.error("Error fetching location data:", error);
		},
	});

	// Fetch the total bookings
	$.ajax({
		url: "fn_ajaxHandler.php",
		method: "GET",
		data: { action: "getTotalBookings" },
		success: function (data) {
			$("#bookingCount").html(data + " Bookings");
		},
		error: function (xhr, status, error) {
			console.error("Error fetching booking data:", error);
		},
	});
}

// Update the data immediately when the page loads
updateData();

// Set interval to update the data every 30 seconds
setInterval(updateData, 500);
