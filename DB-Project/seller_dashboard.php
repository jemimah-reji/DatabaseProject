<?php
// Start session to access session variables
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

// Include database connection
include 'db_connect.php';

// Retrieve the user's first name from the session, or refresh from the database if not set
if (isset($_SESSION['first_name'])) {
    $firstName = $_SESSION['first_name'];
} else {
    // If not in session, fetch from the database
    $userID = $_SESSION['user_id'];
    $query = "SELECT CustName FROM Customers WHERE CustomerID = '$userID'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $firstName = $user['CustName'];

        // Store in session for subsequent requests
        $_SESSION['first_name'] = $firstName;
    } else {
        $firstName = "User"; // Default if not found
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css"> <!-- Link to existing styles.css -->

    <!-- Page-specific styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: #fffaf3;
            color: #4e342e;
            padding-top: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            width: 100%;
            max-width: 900px;
            padding: 0 20px;
        }
        .header img {
            width: 160px; /* Increased logo size */
            height: auto;
            margin-right: 15px;
        }
        .header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            display: inline;
            color: #4e342e;
        }
        .welcome-message {
            font-size: 1.25rem;
            margin: 0.8rem 0;
            color: #4e342e;
            text-align: center;
        }
        .action-box {
            max-width: 700px;
            width: 100%;
            padding: 2rem;
            background: #f8f4e5;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
            text-align: center;
            margin-top: -15px;
        }
        .action-box h2 {
            color: #4e342e;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        .button-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .custom-btn {
            padding: 0.75rem;
            font-weight: 600;
            color: #4e342e;
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
            text-align: center;
            border-radius: 5px;
        }
        .custom-btn:hover {
            background-color: #4e342e;
            color: #fffaf3;
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
        .custom-logout-btn {
            color: #4e342e; /* Dark brown text */
            background-color: #fffaf3; /* Light cream background */
            border: 2px solid #4e342e; /* Dark brown border */
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 10px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }
        .custom-logout-btn:hover {
            background-color: #4e342e;
            color: #fffaf3; /* Cream text on hover */
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
    </style>
</head>
<body>
    <!-- Header with ShopSmart logo and heading -->
    <div class="header">
        <img src="images/shopsmart_logo.png" alt="ShopSmart Logo">
        <h1>ShopSmart</h1>
    </div>

    <!-- Welcome Message -->
    <div class="welcome-message">
        Welcome, <?php echo htmlspecialchars($firstName); ?>!
    </div>

    <!-- Action Box -->
    <div class="action-box">
        <h2>What would you like to do today?</h2>
        <div class="button-grid">
            <a href="add_product.php" class="custom-btn">Add New Product</a>
            <a href="update_product.php" class="custom-btn">Update Product</a>
            <a href="delete_product.php" class="custom-btn">Delete Product</a>
            <a href="view_products.php" class="custom-btn">View Your Products</a>
            <a href="shopper_dashboard.php" class="custom-btn">Go to Shopper Dashboard</a>
            <a href="account_info.php" class="custom-btn">Account Info</a>
        </div>
    </div>

    <!-- Logout Button -->
    <div style="position: absolute; top: 20px; right: 20px;">
        <a href="logout.php" class="btn custom-logout-btn">Logout</a>
    </div>
</body>
</html>
