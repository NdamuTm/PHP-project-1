<?php
session_start();

// Check if session variables are set
if (!isset($_SESSION['name']) || !isset($_SESSION['email']) || !isset($_SESSION['password'])) {
    echo "No session data available. Please log in first.";
    header("Location: /Login");
    exit();

}

// Retrieve session variables
$username = $_SESSION['name'];
$email = $_SESSION['email'];
$password = $_SESSION['password'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Basic PHP Project</title>
</head>
<body>

<div>
    <p><strong>Name:</strong> <?php echo htmlspecialchars($username); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
    <p><strong>Password:</strong> <?php echo htmlspecialchars($password); ?></p>
</div>

<style>
    body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100vh;
        padding: 0;
        margin: 0;
        font-size: 2rem;
        font-family: 'Poppins', sans-serif;
    }
    div {
        text-align: center;
        background-color: #f4f4f4;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
</style>

</body>
</html>



