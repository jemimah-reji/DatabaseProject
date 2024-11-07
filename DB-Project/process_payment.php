<?php
include 'db_connect.php';
session_start();

// Ensure required session data
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart'])) {
    header("Location: shopper_dashboard.php");
    exit();
}

$userID = $_SESSION['user_id'];
$cartItem = $_SESSION['cart'];
$productID = $cartItem['product_id'];
$quantity = $cartItem['quantity'];
$totalAmount = $cartItem['price'] * $quantity;
$paymentDate = date("Y-m-d");

// Process payment if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $paymentMethod = $_POST['payment_method'];

    // Start transaction
    $conn->begin_transaction();

    try {
        // Insert a new order in the Orders table
        $orderInsertQuery = "INSERT INTO Orders (CustomerID, OrderDate, TotalAmount, OrderStatus, ProductID) 
                     VALUES ('$userID', '$paymentDate', '$totalAmount', 'Pending', '$productID')";
        if (!$conn->query($orderInsertQuery)) {
            throw new Exception("Error creating order: " . $conn->error);
        }
        $orderID = $conn->insert_id;


        // Deduct stock quantity
        $deductStockQuery = "UPDATE Products SET StockQuantity = StockQuantity - $quantity WHERE ProductID = '$productID'";
        if (!$conn->query($deductStockQuery)) {
            throw new Exception("Error updating stock for product ID: $productID");
        }

        // Record the payment
        $insertPaymentQuery = "INSERT INTO Payments (OrderID, CustomerID, PaymentDate, TotalAmount, PaymentMethod) 
                               VALUES ('$orderID', '$userID', '$paymentDate', '$totalAmount', '$paymentMethod')";
        if (!$conn->query($insertPaymentQuery)) {
            throw new Exception("Error recording payment: " . $conn->error);
        }

        // Commit transaction
        $conn->commit();

        // Clear the cart
        unset($_SESSION['cart']);

        // Success message
        $successMessage = "<p>Payment successful! Order ID: $orderID. Thank you for your purchase.</p>";

    } catch (Exception $e) {
        $conn->rollback();
        $errorMessage = "<p>" . $e->getMessage() . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Confirmation</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
            padding: 2rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
            text-align: center;
        }
        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4e342e;
            margin-bottom: 1rem;
        }
        .message {
            font-size: 1.1rem;
            margin-bottom: 1.5rem;
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
    text-decoration: none; /* Removes underline */
}

.btn-custom:hover {
    background-color: #4e342e; /* Dark brown background on hover */
    color: #fffaf3; /* Cream text on hover */
    text-decoration: none; /* Ensures underline doesn't appear on hover */
}
    </style>
</head>
<body>
    <div class="container">
        <h1>Payment Confirmation</h1>
        
        <?php if (isset($successMessage)) echo "<div class='message'>$successMessage</div>"; ?>
        <?php if (isset($errorMessage)) echo "<div class='message text-danger'>$errorMessage</div>"; ?>
        
        <!-- Continue Shopping Button -->
        <a href="shopper_dashboard.php" class="btn-custom">Continue Shopping</a>
        
        <!-- Review Prompt Button -->
        <a href="leave_review.php?order_id=<?php echo $orderID; ?>" class="btn-custom" style="margin-top: 10px;">Leave a Review</a>
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
