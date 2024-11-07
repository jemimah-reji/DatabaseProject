<?php
include 'db_connect.php';
session_start(); // Start session to store role

$role = isset($_GET['role']) ? $_GET['role'] : 'shopper';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if user exists
    $query = "SELECT * FROM Customers WHERE Email = '$email' AND cust_password = '$password'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // Success, store role and user details in the session
        $_SESSION['user_id'] = $result->fetch_assoc()['CustomerID'];
        $_SESSION['role'] = $role; // Store the role in the session for future access

        // Redirect based on role
        if ($role === 'shopper') {
            header("Location: shopper_dashboard.php");
        } else {
            header("Location: seller_dashboard.php");
        }
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo ucfirst($role); ?> Login</title>
    
    <!-- Link to styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">

    <!-- Page-specific styles -->
    <style>
        body {
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #f8f4e3; /* Light cream */
            font-family: 'Nunito', sans-serif;
            color: #4e342e;
            height: 100vh;
        }
        .login-container {
            max-width: 400px;
            padding: 2rem;
            background: #fffaf3; /* Slightly off-white cream */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid #d6cab8; /* Matching border */
        }
        h1 {
            color: #4e342e;
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        .error-message {
            color: #e26c4f; /* Subtle red for error */
            margin-bottom: 1rem;
        }
        .custom-btn {
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            font-weight: 600;
            color: #4e342e; /* Dark brown text */
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #4e342e;
            color: #fffaf3; /* Cream text on hover */
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1>Logging in as a <?php echo ucfirst($role); ?></h1>
        
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        
        <form action="" method="POST">
            <label>Email:</label>
            <input type="email" name="email" required class="form-control mb-3"><br>
            <label>Password:</label>
            <input type="password" name="password" required class="form-control mb-3"><br>
            <button type="submit" class="btn custom-btn">Log In</button>
        </form>
    </div>
</body>
</html>
