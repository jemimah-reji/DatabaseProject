<?php
include 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

$customerID = $_SESSION['user_id']; // Retrieve the logged-in user's CustomerID

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productName = $_POST['product_name'];
    $details = $_POST['details'];
    $price = $_POST['price'];
    $stockQuantity = $_POST['stock_quantity'];

    // Insert the new product with the CustomerID into the Products table
    $query = "INSERT INTO Products (ProductName, Details, Price, StockQuantity, CustomerID) 
              VALUES ('$productName', '$details', '$price', '$stockQuantity', '$customerID')";
    
    if ($conn->query($query) === TRUE) {
        $productId = $conn->insert_id; // Get the auto-generated Product ID
        $successMessage = "Product added successfully! Product ID: $productId";
    } else {
        $errorMessage = "Error adding product: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    
    <!-- Page-specific styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f4e3;
            color: #4e342e;
            height: 100vh;
            margin: 0;
        }
        .form-container {
            max-width: 600px;
            padding: 2rem 3rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
            text-align: center;
        }
        h1 {
            color: #4e342e;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        label {
            display: block;
            text-align: left;
            margin-top: 1rem;
            font-weight: 600;
        }
        input[type="text"],
        input[type="number"],
        textarea {
            width: 100%;
            padding: 0.5rem;
            margin-top: 0.5rem;
            border: 1px solid #d6cab8;
            border-radius: 5px;
            font-size: 1rem;
        }
        .custom-btn {
            width: 100%;
            margin-top: 1.5rem;
            padding: 0.75rem;
            font-weight: 600;
            color: #4e342e;
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        .custom-btn:hover {
            background-color: #4e342e;
            color: #fffaf3;
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
        .message {
            margin-top: 1rem;
            font-weight: 600;
            color: #4e342e;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Add a New Product</h1>
        
        <?php if (isset($successMessage)) echo "<p class='message'>$successMessage</p>"; ?>
        <?php if (isset($errorMessage)) echo "<p class='message' style='color: #e26c4f;'>$errorMessage</p>"; ?>
        
        <form action="" method="POST">
            <label>Product Name:</label>
            <input type="text" name="product_name" required>
            
            <label>Details:</label>
            <textarea name="details" required rows="4"></textarea>
            
            <label>Price:</label>
            <input type="number" step="0.01" name="price" required>
            
            <label>Stock Quantity:</label>
            <input type="number" name="stock_quantity" required>
            
            <button type="submit" class="custom-btn">Add Product</button>
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
