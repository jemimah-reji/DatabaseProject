<?php
include 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$customerID = $_SESSION['user_id']; // Retrieve the logged-in user's CustomerID

// Fetch all products added by this user
$query = "SELECT ProductID, ProductName, Details, Price, StockQuantity FROM Products WHERE CustomerID = '$customerID'";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Products</title>
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
            padding: 20px;
            margin: 0;
        }
        .table-container {
            max-width: 800px;
            width: 100%;
            background: #fffaf3;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border: 1px solid #d6cab8;
        }
        h1 {
            text-align: center;
            color: #4e342e;
            margin-bottom: 1.5rem;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }
        th, td {
            padding: 0.75rem;
            text-align: left;
            border-bottom: 1px solid #d6cab8;
        }
        th {
            background-color: #f8f4e3;
            color: #4e342e;
            font-weight: 700;
        }
        tr:hover {
            background-color: #f2e9de;
        }
        .no-products {
            text-align: center;
            font-weight: 600;
            color: #4e342e;
        }
    </style>
</head>
<body>
    <div class="table-container">
        <h1>Your Products</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Product ID</th>
                        <th>Product Name</th>
                        <th>Details</th>
                        <th>Price</th>
                        <th>Stock Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ProductID']); ?></td>
                            <td><?php echo htmlspecialchars($row['ProductName']); ?></td>
                            <td><?php echo htmlspecialchars($row['Details']); ?></td>
                            <td><?php echo htmlspecialchars(number_format($row['Price'], 2)); ?></td>
                            <td><?php echo htmlspecialchars($row['StockQuantity']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="no-products">You haven't added any products yet.</p>
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
