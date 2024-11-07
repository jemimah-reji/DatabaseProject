<?php
include 'db_connect.php';
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userID = $_SESSION['user_id'];

// Fetch user information
$query = "SELECT CustName, Email, Address, PhoneNumber FROM Customers WHERE CustomerID = '$userID'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $userInfo = $result->fetch_assoc();
} else {
    $errorMessage = "Error retrieving account information.";
}

// Update user information if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];

    $updateQuery = "UPDATE Customers SET CustName='$name', Email='$email', Address='$address', PhoneNumber='$phone' WHERE CustomerID='$userID'";
    
    if ($conn->query($updateQuery) === TRUE) {
        $successMessage = "Account information updated successfully!";
        // Refresh user info
        $userInfo = ['CustName' => $name, 'Email' => $email, 'Address' => $address, 'PhoneNumber' => $phone];
    } else {
        $errorMessage = "Error updating account information: " . $conn->error;
    }
    if ($conn->query($updateQuery) === TRUE) {
    // Update all relevant session variables
    $_SESSION['first_name'] = $name;
    $_SESSION['email'] = $email;
    $_SESSION['address'] = $address;
    $_SESSION['phone'] = $phone;

    $successMessage = "Account information updated successfully!";
    
    // Update $userInfo array to reflect changes immediately in the form
    $userInfo = [
        'CustName' => $name,
        'Email' => $email,
        'Address' => $address,
        'PhoneNumber' => $phone
    ];
}

}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Information</title>
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
        input[type="email"] {
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
        <h1>Account Information</h1>
        
        <?php if (isset($successMessage)) echo "<p class='message'>$successMessage</p>"; ?>
        <?php if (isset($errorMessage)) echo "<p class='message' style='color: #e26c4f;'>$errorMessage</p>"; ?>
        
        <form action="" method="POST">
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($userInfo['CustName']); ?>" required>
            
            <label>Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($userInfo['Email']); ?>" required>
            
            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($userInfo['Address']); ?>" required>
            
            <label>Phone Number:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($userInfo['PhoneNumber']); ?>" required>
            
            <button type="submit" class="custom-btn">Update Information</button>
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
