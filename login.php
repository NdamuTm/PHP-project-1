<?php
require 'includes/PHPMailer.php';
require 'includes/SMTP.php';
require 'includes/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Determine action: login, signup, or forgot password
    $action = $_POST['action'];

    // Handle Signup
    if ($action == "signup") {
        // Sanitize inputs
        $name =  $_POST['name'];
        $email =  $_POST['email'];
        $password =  $_POST['password'];


        // Insert new user into the database
        $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";

        if ($conn->query($sql) === TRUE) {
            // Redirect to success page
                    $_SESSION['name'] = $name;
                    $_SESSION['email'] = $email;
                    $_SESSION['password'] = $password;
            header("Location: /success.php?message=success");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }

        // Handle Login
    }
    elseif ($action == "login") {
        // Sanitize inputs
        $email =  $_POST['email'];
        $password =  $_POST['password'];

        // Query the database to find the user
        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // User found, verify the password
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['name'] = $row['name'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['password'] = $row['password'];
                header("Location: /success.php?message=success");
                exit();
            } else {
                // Invalid password
                header("Location: /success.php?message=Cancelled&messagevalue=Invalid password");
                exit();
            }
        } else {
            // User not found
            header("Location: /success.php?message=Cancelled&messagevalue=User not found");
            exit();
        }

        // Handle Forgot Password
    }
    elseif ($action == "forgotPassword") {
        // Sanitize inputs
        $email =  $_POST['email'];
        $password =  $_POST['password'];

        $sql = "SELECT * FROM users WHERE email='$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

            $mail = new PHPMailer(true);
            try {
                // Set up the email
                $mail->isSMTP();
                $mail->Host = "mail.nfutr.co.za";
                $mail->SMTPAuth = true;
                $mail->SMTPSecure = "ssl";
                $mail->Port = 465;
                $mail->Username = "email@nfutr.co.za";
                $mail->Password = "Ndamu@23";
                $mail->setFrom('email@nfutr.co.za', 'Basic PHP Project 1');
                $mail->addAddress($email);
                $mail->Subject = 'Basic PHP Project 1 - Password Reset Request';
                $mail->isHTML(true);

                // Password reset link
                $resetLink = "http://localhost:80/passwordreset.php?reset=true&e=$email&p=$password";

                $mail->Body = "
                    <p>Hi there,</p>
                    <p>We received a request to reset your password on Basic PHP Project 1.</p>
                    <p>If you didn't request a password reset, you can safely ignore this email.</p>
                    <p>To reset your password, please click on the following link:</p>
                    <p><a href='$resetLink'>Reset Password</a></p>
                    <p>This link will expire in 24 hours for security reasons. If you don't reset your password within 24 hours, you'll need to request a new reset link.</p>
                    <p>Thanks,</p>
                    <p>The Basic PHP Project 1 Team</p>
                ";

                // Send the email
                if ($mail->send()) {
                    header("Location: /success.php?message=reset&messagevalue=$email");
                    exit();
                } else {
                    header("Location: /success.php?message=Cancelled");
                    exit();
                }
            } catch (Exception $e) {
                echo "Mailer Error: " . $mail->ErrorInfo;
            }
        } else {
            echo "Error updating password: " . $conn->error;
            header("Location: /success.php?message=Cancelled&messagevalue=Error updating password");
            exit();
        }
    }
}

// Close the connection
$conn->close();
?>
