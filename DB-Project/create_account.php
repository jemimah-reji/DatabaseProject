<?php
include 'db_connect.php';
$role = isset($_GET['role']) ? $_GET['role'] : 'shopper';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

    // Insert new customer
    $query = "INSERT INTO Customers (CustName, Email, Address, PhoneNumber, cust_password) 
              VALUES ('$name', '$email', '$address', '$phone', '$password')";

    if ($conn->query($query) === TRUE) {
        header("Location: login.php?role=$role"); // Redirect to login after registration
        exit();
    } else {
        $error = "Error creating account: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create <?php echo ucfirst($role); ?> Account</title>
    
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
            background-color: #f8f4e3; /* Light cream background */
            font-family: 'Nunito', sans-serif;
            color: #4e342e;
            height: 100vh;
        }
        .form-container {
            max-width: 700px;
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
        .error-message {
            color: #e26c4f;
            margin-bottom: 1rem;
        }
        .custom-btn {
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            font-weight: 600;
            color: #4e342e;
            background-color: #fffaf3;
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #4e342e;
            color: #fffaf3;
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h1>Creating Account</h1>
        
        <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
        
        <form action="" method="POST">
            <div class="row mb-3">
                <div class="col">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" required class="form-control">
                </div>
                <div class="col">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email" required class="form-control">
                </div>
            </div>
            
            <div class="row mb-3">
                <div class="col">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address" required class="form-control">
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Phone Number:</label>
                    <input type="text" name="phone" required class="form-control">
                </div>
            </div>
            
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" name="password" required class="form-control">
            </div>

            <button type="submit" class="btn custom-btn">Create Account</button>
        </form>
    </div>
</body>
</html>
