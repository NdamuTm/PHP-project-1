<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("Location: /Login");
    exit();
}

if (isset($_GET['message'])) {
    $message = $_GET['message'];
    if ($message == 'Cancelled') {
        $messagevalue = $_GET['messagevalue'];
    }

}


?>

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
<?php
if ($message == 'success') {
    echo "Login Successful. Redirecting... ";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/';
            }, 3000); 
          </script>";
} elseif ($message == 'Cancelled') {
    echo "Login Unsuccessful. $messagevalue Try again. Redirecting...";
    echo "<script>
            setTimeout(function() {
                window.location.href = '/Login';
            }, 3000); 
          </script>";
} elseif ($message == 'reset') {
    echo "Login link has been sent to $messagevalue, Click the link on the email to verify.";

} else {
    echo 'Unknown message type.';
}
?>

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

</body>
</html>
