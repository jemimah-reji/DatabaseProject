<?php
include 'db_connect.php';
session_start();

$customerID = $_SESSION['user_id']; // Ensure the user is logged in

// Check if the product ID is provided
if (isset($_GET['product_id'])) {
    $productID = $_GET['product_id'];
    
    // Fetch product details, ensuring it belongs to the logged-in user
    $query = "SELECT ProductName, Details, Price, StockQuantity FROM Products 
              WHERE ProductID = '$productID' AND CustomerID = '$customerID'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Product not found or access denied."]);
    }
}

$conn->close();
?>
