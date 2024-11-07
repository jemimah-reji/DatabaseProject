<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];
$orderID = isset($_GET['order_id']) ? $_GET['order_id'] : null;

// Check if order ID is valid
if (!$orderID) {
    echo "<p>Error: Order not found or invalid.</p>";
    exit();
}

// Fetch the ProductID directly from the Orders table
$orderQuery = "SELECT ProductID FROM Orders WHERE OrderID = '$orderID'";
$orderResult = $conn->query($orderQuery);
$order = $orderResult->fetch_assoc();

if (!$order) {
    echo "<p>Error: Order not found or invalid.</p>";
    exit();
}

$productID = $order['ProductID'];

// Fetch product name for display
$productQuery = "SELECT ProductName FROM Products WHERE ProductID = '$productID'";
$productResult = $conn->query($productQuery);
$product = $productResult->fetch_assoc();

if (!$product) {
    echo "<p>Error: Product not found or invalid.</p>";
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productID = $_POST['product_id']; // Retrieve ProductID from form
    $stars = $_POST['stars'];
    $review = $_POST['review'];

    // Insert the review into the Reviews table
    $reviewQuery = "INSERT INTO Reviews (ProductID, CustomerID, Stars, Review) 
                    VALUES ('$productID', '$userID', '$stars', '$review')";

    if ($conn->query($reviewQuery) === TRUE) {
        echo "<p>Thank you! Your review has been submitted.</p>";
    } else {
        echo "<p>Error submitting review: " . $conn->error . "</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leave a Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
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

        .home-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #4e342e;
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            padding: 0.5rem 1rem;
            font-weight: 600;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .home-btn:hover {
            background-color: #4e342e;
            color: #fffaf3;
        }
    </style>
</head>
<body>
    <!-- Home Button at the Top-Right -->
    <a href="shopper_dashboard.php" class="home-btn">Home</a>

    <div class="container">
        <h1>Leave a Review for <?php echo htmlspecialchars($product['ProductName']); ?></h1>
        
        <form action="" method="POST">
            <!-- Hidden input for Product ID -->
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($productID); ?>">

            <label for="stars">Rating:</label>
            <select name="stars" class="form-control mb-3" required>
                <option value="1">1 - Poor</option>
                <option value="2">2 - Fair</option>
                <option value="3">3 - Good</option>
                <option value="4">4 - Very Good</option>
                <option value="5">5 - Excellent</option>
            </select>
            
            <label for="review">Review:</label>
            <textarea name="review" class="form-control mb-3" rows="4" required></textarea>
            
            <button type="submit" class="btn-custom">Submit Review</button>
        </form>
    </div>
</body>
</html>
