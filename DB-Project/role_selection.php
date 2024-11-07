<?php
$role = isset($_GET['role']) ? $_GET['role'] : null;
$heading = "Welcome!";

if ($role === 'shopper') {
    $heading = "Welcome, Shopper!";
    $loginLink = "login.php?role=shopper";
    $createAccountLink = "create_account.php?role=shopper";
} elseif ($role === 'seller') {
    $heading = "Welcome, Seller!";
    $loginLink = "login.php?role=seller";
    $createAccountLink = "create_account.php?role=seller";
} else {
    $loginLink = "#";
    $createAccountLink = "#";
}
?>

<!DOCTYPE html>
<html lang="en" style="height: 100%;">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Choose an Option</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/styles.css">
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
        .container {
            max-width: 400px;
            padding: 2rem;
            background: #fffaf3; /* Slightly off-white cream */
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            border: 1px solid #d6cab8; /* Matching border */
        }
        h1 {
            color: #4e342e; /* Dark brown */
            margin-bottom: 1.5rem;
            font-weight: 700;
        }
        .custom-btn {
            width: 100%;
            margin-top: 1rem;
            padding: 0.75rem;
            font-weight: 600;
            color: #4e342e; /* Dark brown text */
            background-color: #fffaf3; /* Matching container cream */
            border: 2px solid #4e342e;
            transition: all 0.3s ease;
        }
        .custom-btn:hover {
            background-color: #4e342e; /* Dark brown on hover */
            color: #fffaf3; /* Cream text on hover */
            box-shadow: 0 4px 8px rgba(78, 52, 46, 0.4);
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo $heading; ?></h1>
        <p>Please log in if you already have an account or create an account</p>
        
        <!-- Login and Create Account buttons with role-specific links -->
        <?php if ($role): ?>
            <a href="<?php echo $loginLink; ?>" class="btn custom-btn">Log In</a>
            <a href="<?php echo $createAccountLink; ?>" class="btn custom-btn">Create Account</a>
        <?php else: ?>
            <p style="color: #e26c4f;">Role not specified!</p>
        <?php endif; ?>
    </div>
</body>
</html>
