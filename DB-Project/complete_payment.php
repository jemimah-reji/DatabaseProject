<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in and has an item in the cart
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    echo "<p>Your cart is empty. <a href='shopper_dashboard.php'>Continue shopping</a></p>";
    exit();
}

$userID = $_SESSION['user_id'];
$cartItem = $_SESSION['cart'];
$productID = $cartItem['product_id'];
$quantity = $cartItem['quantity'];
$totalAmount = $cartItem['price'] * $quantity;
$paymentDate = date("Y-m-d"); // Use the current date as payment date

// Process payment on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $cardNumber = $_POST['card_number'];
    $expiryDate = $_POST['expiry_date'];
    $cvv = $_POST['cvv'];
    $paymentMethod = $_POST['payment_method'];

    // Step 1: Insert a new order in the Orders table
    $orderInsertQuery = "INSERT INTO Orders (CustomerID, OrderDate, TotalAmount, OrderStatus) 
                         VALUES ('$userID', '$paymentDate', '$totalAmount', 'Pending')";

    if ($conn->query($orderInsertQuery) === TRUE) {
        $orderID = $conn->insert_id;

        // Step 2: Deduct stock quantity from the Products table
        $deductStockQuery = "UPDATE Products SET StockQuantity = StockQuantity - $quantity WHERE ProductID = '$productID'";

        if ($conn->query($deductStockQuery) === TRUE) {
            // Step 3: Record the payment in the Payments table
            $insertPaymentQuery = "INSERT INTO Payments (OrderID, CustomerID, PaymentDate, TotalAmount, PaymentMethod) 
                                   VALUES ('$orderID', '$userID', '$paymentDate', '$totalAmount', '$paymentMethod')";

            if ($conn->query($insertPaymentQuery) === TRUE) {
                unset($_SESSION['cart']); // Clear the cart after successful purchase
                echo "<p>Payment successful! Order ID: $orderID. Thank you for your purchase.</p>";
                echo "<a href='shopper_dashboard.php' class='btn btn-custom'>Continue Shopping</a>";
            } else {
                echo "<p>Error recording payment: " . $conn->error . "</p>";
            }
        } else {
            echo "<p>Error updating stock quantity: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Error creating order: " . $conn->error . "</p>";
    }

    $conn->close();
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
            margin: 0;
        }
        .container {
            max-width: 500px;
            padding: 2rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
        }
        .btn-custom {
            color: #fff;
            background-color: #4e342e;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #e26c4f;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complete Your Payment</h1>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="name" class="form-label">Name on Card:</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="card_number" class="form-label">Card Number:</label>
                <input type="text" class="form-control" id="card_number" name="card_number" required>
            </div>
            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date:</label>
                <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV:</label>
                <input type="password" class="form-control" id="cvv" name="cvv" required>
            </div>
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method:</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="Debit Card">Debit Card</option>
                </select>
            </div>
            <button type="submit" class="btn-custom">Submit Payment</button>
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
