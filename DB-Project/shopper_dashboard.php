<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$firstName = isset($_SESSION['first_name']) ? $_SESSION['first_name'] : 'Shopper';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Shopper Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #fffaf3;
            color: #4e342e;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            position: relative;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 1rem;
        }
        .header img {
            width: 80px;
            height: auto;
        }
        .header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #4e342e;
            margin: 0;
        }
        .container {
            max-width: 700px;
            padding: 2rem;
            background: #f8f4e3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
            text-align: center;
        }
        .welcome-message {
            font-size: 1.25rem;
            color: #4e342e;
            margin-bottom: 1.5rem;
        }
        .action-box h2 {
            color: #4e342e;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        .btn-custom {
            margin-top: 0.75rem;
            color: #4e342e;
            background-color: #fffaf3;
            padding: 0.75rem;
            border-radius: 5px;
            font-weight: 600;
            width: 100%;
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }
        .btn-custom:hover {
            background-color: #4e342e;
            color: #fffaf3;
        }
        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        /* Logout button styling at the top-right of the webpage */
        .logout-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #fffaf3;
            background-color: #4e342e;
            border: none;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <!-- Logout Button -->
    <a href="logout.php" class="logout-btn">Logout</a>

    <!-- Header with Logo and Site Title centered above the main container -->
    <div class="header">
        <img src="images/shopsmart_logo.png" alt="ShopSmart Logo">
        <h1>ShopSmart</h1>
    </div>

    <!-- Main container with action options -->
    <div class="container">
        <div class="welcome-message">
            Welcome, <?php echo htmlspecialchars($firstName); ?>!
        </div>

        <div class="action-box">
            <h2>What would you like to do today?</h2>
            <div class="button-grid">
                <a href="products.php" class="btn-custom">Browse Products</a>
                <a href="account_info.php" class="btn-custom">View Account Info</a>
                <a href="view_orders.php" class="btn-custom">View Your Orders</a>
                <a href="view_reviews.php" class="btn-custom">View Your Reviews</a>
            </div>
        </div>
    </div>
</body>
</html>
