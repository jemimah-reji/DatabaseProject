<?php
include 'db_connect.php';  // Assuming db_connect.php handles $conn
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Fetch products for the logged-in user
$productQuery = "SELECT ProductID, ProductName FROM Products WHERE CustomerID = '$userID' ORDER BY ProductName ASC";
$products = $conn->query($productQuery);

// Determine the home page link based on user role
$homeLink = (isset($_SESSION['role']) && $_SESSION['role'] === 'seller') ? 'seller_dashboard.php' : 'shopper_dashboard.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product</title>
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
            width: 80%; /* Makes the form wider */
            max-width: 900px; /* Limits max width */
            padding: 2rem;
            background: #fffaf3;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
        }
        h1 {
            color: #4e342e;
            margin-bottom: 1.5rem;
            font-weight: 700;
            font-size: 1.5rem;
            text-align: center;
        }
        label {
            font-weight: 600;
            margin-top: 1rem;
            color: #4e342e;
        }
        .form-row {
            display: flex;
            gap: 20px; /* Space between columns */
            flex-wrap: wrap;
        }
        .form-group {
            flex: 1; /* Makes each input take half the width */
            display: flex;
            flex-direction: column;
        }
        select,
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
            text-align: center;
        }
        .custom-home-btn {
            color: #4e342e;
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            padding: 0.5rem 1rem;
            font-weight: 600;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease, color 0.3s ease;
            position: absolute;
            top: 20px;
            right: 20px;
        }
        .custom-home-btn:hover {
            background-color: #4e342e;
            color: #fffaf3;
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Update Product</h1>
        
        <?php
        if (isset($successMessage)) echo "<p class='message'>$successMessage</p>";
        if (isset($errorMessage)) echo "<p class='message' style='color: #e26c4f;'>$errorMessage</p>";
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <label>Select Product:</label>
            <select name="product_id" required onchange="fetchProductDetails(this.value)">
                <option value="">Select a product</option>
                <?php if ($products && $products->num_rows > 0): ?>
                    <?php while ($row = $products->fetch_assoc()): ?>
                        <option value="<?php echo $row['ProductID']; ?>"><?php echo $row['ProductName']; ?></option>
                    <?php endwhile; ?>
                <?php else: ?>
                    <option value="">No products available</option>
                <?php endif; ?>
            </select>

            <!-- Form Row for side-by-side fields -->
            <div class="form-row">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="product_name" required>
                </div>
                <div class="form-group">
                    <label>Price:</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Details:</label>
                    <textarea name="details" required rows="4"></textarea>
                </div>
                <div class="form-group">
                    <label>Stock Quantity:</label>
                    <input type="number" name="stock_quantity" required>
                </div>
            </div>
            
            <button type="submit" class="custom-btn">Update Product</button>
        </form>
    </div>

    <!-- JavaScript to fetch product details -->
    <script>
        function fetchProductDetails(productId) {
            if (productId === "") return;

            fetch(`get_product_details.php?product_id=${productId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.ProductName && data.Details && data.Price && data.StockQuantity) {
                        document.querySelector('input[name="product_name"]').value = data.ProductName;
                        document.querySelector('textarea[name="details"]').value = data.Details;
                        document.querySelector('input[name="price"]').value = data.Price;
                        document.querySelector('input[name="stock_quantity"]').value = data.StockQuantity;
                    } else {
                        console.error('Invalid product data received:', data);
                    }
                })
                .catch(error => console.error('Error fetching product details:', error));
        }
    </script>

    <a href="<?php echo $homeLink; ?>" class="custom-home-btn">Home</a>
</body>
</html>
