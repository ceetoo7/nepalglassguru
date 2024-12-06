
<?php 
$conn = mysqli_connect('localhost','root','','GlassGuruDB');

if(!$conn){
    die('Database connection failed: ' .mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/admin-style.css">
    <link rel="stylesheet" href="assets/css/order-page.css">
    <title>Order Receive</title>

</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div id="wrapper">
  

    <div class="container">
        <h1>Order Received</h1>

        <!-- Order Summary Table -->
        <table class="order-receive">
            <thead>
                <tr>
                    <th>SN</th>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Total Square Footage</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="order-summary">
                <!-- Rows will be added dynamically -->
            </tbody>
        </table>

        <!-- Glass Order Details -->
        <div id="details-container" class="details-container">
            <h2>Glass Order Details</h2>
            <table class="order-details">
                <thead>
                    <tr>
                        <th>SN</th>
                        <th>Thickness</th>
                        <th>Color</th>
                        <th>Length (inches)</th>
                        <th>Breadth (inches)</th>
                        <th>Square Footage</th>
                    </tr>
                </thead>
                <tbody id="glass-details">
                    <!-- Rows will be added dynamically -->
                </tbody>
            </table>
        </div>
    </div>



</div>
<?php include 'includes/footer.php'; ?>

<script>
    // Sample data for orders
    const orders = [
        {
            id: 1,
            name: "John Doe",
            address: "Kathmandu",
            phone: "+977-9876543210",
            email: "john.doe@example.com",
            glassOrders: [
                { thickness: "12mm", color: "Clear", length: 48, breadth: 36 },
                { thickness: "10mm", color: "Green", length: 60, breadth: 24 }
            ]
        },
        {
            id: 2,
            name: "Jane Smith",
            address: "Pokhara",
            phone: "+977-9812345678",
            email: "jane.smith@example.com",
            glassOrders: [
                { thickness: "8mm", color: "Blue", length: 72, breadth: 30 },
                { thickness: "6mm", color: "Clear", length: 36, breadth: 36 }
            ]
        }
    ];

    // Function to calculate square footage
    function calculateSquareFootage(length, breadth) {
        return ((length * breadth) / 144).toFixed(2); // Result in sq. ft.
    }

    // Populate the Order Summary table
    function populateOrderSummary() {
        const orderSummary = document.getElementById("order-summary");
        orders.forEach((order, index) => {
            const totalSquareFootage = order.glassOrders.reduce((total, item) => {
                return total + parseFloat(calculateSquareFootage(item.length, item.breadth));
            }, 0);

            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${order.name}</td>
                <td>${order.address}</td>
                <td>${order.phone}</td>
                <td>${order.email}</td>
                <td>${totalSquareFootage} sq. ft.</td>
                <td class="order-actions">
                    <button class="btn btn-accept" onclick="acceptOrder(${order.id})">Accept</button>
                    <button class="btn btn-decline" onclick="declineOrder(${order.id})">Decline</button>
                    <span class="show-details" onclick="showDetails(${order.id})">View Details</span>
                </td>
            `;
            orderSummary.appendChild(row);
        });
    }

    // Show glass order details
    function showDetails(orderId) {
        const detailsContainer = document.getElementById("details-container");
        const glassDetails = document.getElementById("glass-details");

        // Clear previous details
        glassDetails.innerHTML = "";

        const order = orders.find(o => o.id === orderId);
        if (order) {
            order.glassOrders.forEach((item, index) => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${item.thickness}</td>
                    <td>${item.color}</td>
                    <td>${item.length}</td>
                    <td>${item.breadth}</td>
                    <td>${calculateSquareFootage(item.length, item.breadth)} sq. ft.</td>
                `;
                glassDetails.appendChild(row);
            });

            detailsContainer.style.display = "block";
        }
    }

    // Handle Accept Order
    function acceptOrder(orderId) {
        alert(`Order ${orderId} has been accepted!`);
    }

    // Handle Decline Order
    function declineOrder(orderId) {
        alert(`Order ${orderId} has been declined.`);
    }

    // Populate data on load
    window.onload = populateOrderSummary;
</script>

</body>
</html>
