<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in and the cart is not empty
if (!isset($_SESSION['user_id']) || !isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: shopper_dashboard.php");
    exit();
}

$item = $_SESSION['cart'];
$totalAmount = $item['price'] * $item['quantity'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .container {
            max-width: 700px;
            padding: 2rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
        }
        h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4e342e;
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

        .form-label {
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Complete Your Payment</h1>
        <p class="text-center mb-4">Total Amount: $<?php echo number_format($totalAmount, 2); ?></p>

        <form action="process_payment.php" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Name on Card:</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="col">
                    <label for="card_number" class="form-label">Card Number:</label>
                    <input type="text" class="form-control" id="card_number" name="card_number" required>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="expiry_date" class="form-label">Expiry Date:</label>
                    <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                </div>
                <div class="col">
                    <label for="cvv" class="form-label">CVV:</label>
                    <input type="password" class="form-control" id="cvv" name="cvv" required>
                </div>
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
</body>
</html>
