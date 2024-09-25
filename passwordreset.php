



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>Basic PHP project</title>
</head>
<body>

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
    </style>
    <?php
    session_start();

    // Database credentials
    $servername = "nfutr.co.za";
    $username = "ndamu_ndamu";
    $password = "V,_F96f^2DmI";
    $dbname = "ndamu_basicphp";

    // Create a connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check the connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the reset link has the necessary parameters
    if (isset($_GET['reset']) && $_GET['reset'] == 'true' && isset($_GET['e']) && isset($_GET['p'])) {
        $email = mysqli_real_escape_string($conn, $_GET['e']);
        $token = mysqli_real_escape_string($conn, $_GET['p']); // Token is the old password, no hashing

        // Verify if the email exists in the database
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, validate the token (password match)
            $row = $result->fetch_assoc();

            $updateSql = "UPDATE users SET password='$token' WHERE email='$email'";

            if ($conn->query($updateSql) === TRUE) {
                echo "Password successfully reset. Redirecting to login...";
                echo "<script>
                                setTimeout(function() {
                                    window.location.href = '/Login';
                                }, 3000);
                              </script>";
                exit();
            } else {
                echo "Error updating password: " . $conn->error;
            }

        } else {
            echo "Invalid or expired reset link.";
        }}

    // Close the connection
    $conn->close();
    ?>



</body>
</html>
