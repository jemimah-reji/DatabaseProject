<?php
include 'db_connect.php';
session_start();

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Fetch reviews from the database for the logged-in user
$query = "SELECT Reviews.ReviewNum, Products.ProductName, Reviews.Stars, Reviews.Review 
          FROM Reviews
          JOIN Products ON Reviews.ProductID = Products.ProductID
          WHERE Reviews.CustomerID = '$userID' ORDER BY Reviews.ReviewNum DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Reviews</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f4e3;
            color: #4e342e;
            padding: 20px;
        }
        .container {
            max-width: 800px;
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
        }
        .table th, .table td {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Your Reviews</h1>
        <?php if ($result->num_rows > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Rating</th>
                        <th>Review</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($review = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($review['ProductName']); ?></td>
                            <td><?php echo htmlspecialchars($review['Stars']); ?>/5</td>
                            <td><?php echo htmlspecialchars($review['Review']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>You have not reviewed any products yet.</p>
        <?php endif; ?>
    </div>

    <!-- Home Button -->
    <?php
    $homeLink = isset($_SESSION['role']) && $_SESSION['role'] === 'seller' ? 'seller_dashboard.php' : 'shopper_dashboard.php';
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
