<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch product details based on the selected product ID
if (isset($_POST['product_id'])) {
    $productID = $_POST['product_id'];

    $query = "SELECT ProductID, ProductName, Details, Price, StockQuantity FROM Products WHERE ProductID = '$productID'";
    $result = $conn->query($query);

    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();

        // Store product details in session for later use
        $_SESSION['cart'] = [
            'product_id' => $product['ProductID'],
            'product_name' => $product['ProductName'],
            'price' => $product['Price'],
            'stock_quantity' => $product['StockQuantity'],
            'quantity' => 1 // Default quantity
        ];
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    echo "No product selected.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add to Cart</title>
    <!-- Load Nunito font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            padding: 2rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
.btn-custom {
    margin-top: 1rem;
    color: #4e342e; /* Dark brown text */
    background-color: #fffaf3; /* Cream background */
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    border: 2px solid #4e342e; /* Dark brown border */
    font-weight: 600;
}

.btn-custom:hover {
    background-color: #4e342e; /* Dark brown background on hover */
    color: #fffaf3; /* Cream text on hover */
}
        label {
            font-weight: 700;
            text-align: left;
            display: block;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($product['ProductName']); ?></h1>
        <p><?php echo htmlspecialchars($product['Details']); ?></p>
        <p>Price: $<?php echo number_format($product['Price'], 2); ?></p>
        <p>Available Stock: <?php echo htmlspecialchars($product['StockQuantity']); ?></p>

        <!-- Proceed to Checkout button with Quantity Selection -->
        <form action="checkout.php" method="POST">
            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" min="1" max="<?php echo $product['StockQuantity']; ?>" value="1" required class="form-control">

            <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
            <button type="submit" class="btn-custom">Proceed to Checkout</button>
        </form>
    </div>
<?php
// Check user role for determining the home page link
$homeLink = (isset($_SESSION['role']) && $_SESSION['role'] === 'seller') ? 'seller_dashboard.php' : 'shopper_dashboard.php';
?>

<div style="position: absolute; top: 20px; right: 20px;">
    <a href="<?php echo $homeLink; ?>" class="btn custom-home-btn">Home</a>
</div>

<style>
    .custom-home-btn {
        color: #4e342e; /* Dark brown text */
        background-color: #fffaf3; /* Light cream background */
        border: 2px solid #4e342e; /* Dark brown border */
        padding: 0.5rem 1rem;
        font-weight: 600;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }
    .custom-home-btn:hover {
        background-color: #4e342e;
        color: #fffaf3; /* Cream text on hover */
        box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
    }
</style>

</body>
</html>
<?php $conn->close(); ?>
