<?php
include 'db_connect.php';
session_start();

// Check if the user is logged in as a shopper
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'shopper') {
    header("Location: login.php"); // Redirect to login if not logged in or if role is incorrect
    exit();
}

// Fetch all available products
$query = "SELECT ProductID, ProductName, Details, Price, StockQuantity FROM Products WHERE StockQuantity > 0";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopper Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Page-specific styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
            margin: 0;
        }
        .dashboard-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .product-card {
            background: #fffaf3;
            border: 1px solid #d6cab8;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .product-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #4e342e;
        }
        .product-price {
            color: #e26c4f;
            font-weight: 600;
            margin-top: 0.5rem;
        }
        .product-stock {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 0.5rem;
        }
.add-to-cart-btn {
    margin-top: 1rem;
    color: #4e342e; /* Dark brown text */
    background-color: #fffaf3; /* Cream background */
    border: 2px solid #4e342e; /* Dark brown border */
    padding: 0.5rem 1rem;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    background-color: #4e342e; /* Dark brown background on hover */
    color: #fffaf3; /* Cream text on hover */
}

    </style>
</head>
<body>
    <div class="dashboard-container">
        <h1>Welcome to the Shopper Dashboard</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="product-card">
                    <h2 class="product-title"><?php echo htmlspecialchars($row['ProductName']); ?></h2>
                    <p><?php echo htmlspecialchars($row['Details']); ?></p>
                    <div class="product-price">Price: $<?php echo htmlspecialchars(number_format($row['Price'], 2)); ?></div>
                    <div class="product-stock">Stock: <?php echo htmlspecialchars($row['StockQuantity']); ?> available</div>
                    
                    <form action="add_to_cart.php" method="POST" style="margin-top: 1rem;">
                        <input type="hidden" name="product_id" value="<?php echo $row['ProductID']; ?>">
                        <button type="submit" class="add-to-cart-btn">Add to Cart</button>
                    </form>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No products available at the moment. Please check back later!</p>
        <?php endif; ?>

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
