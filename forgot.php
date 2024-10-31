<?php
session_start();
require 'vendor/autoload.php'; // Include Composer's autoloader
require 'connect.php'; // Include your database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to generate a random password
function generateRandomPassword($length = 12) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
    $charactersLength = strlen($characters);
    $randomPassword = '';
    for ($i = 0; $i < $length; $i++) {
        $randomPassword .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomPassword;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a random password
    $newPassword = generateRandomPassword();

    // Insert the new password into the account table (no hashing)
    $stmt = $con->prepare("UPDATE accounts SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);

    if ($stmt->execute()) {
        // Create a new PHPMailer instance
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true;
            $mail->Username = 'kennetics1@gmail.com'; 
            $mail->Password = 'bcvn mqgw jxlf gmin'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
            $mail->Port = 587; 

            // Recipients
            $mail->setFrom('adambautista1@gmail.com', 'PICK 2 PUFF');
            $mail->addAddress($email);

            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'New Password';
            $mail->Body = "Your new password is: <strong>$newPassword</strong>";
            $mail->AltBody = "Your new password is: $newPassword";

            // Send the email
            $mail->send();
            echo "<script>alert('Message has been sent with the new password.')</script>";
        } catch (Exception $e) {
            echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>";
        }
    } else {
        echo "<script>alert('Error updating password. Please try again.')</script>";
    }

    // Close the database connection
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="style1.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2; 
        }
        .card {
            background-color: white; 
            border-radius: 8px; 
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
            padding: 20px; 
            width: 100%;
            max-width: 400px;
            text-align: center; 
        }
        h2 {
            margin-bottom: 20px; 
        }
        input[type="email"] {
            width: 90%; 
            padding: 10px; 
            border: 1px solid #ccc;
            border-radius: 5px;
            margin: 0 10px 20px 0;
        }
        button {
            background-color: #007bff; 
            color: white; 
            border: none; 
            padding: 10px; 
            border-radius: 5px; 
            cursor: pointer; 
            width: 100%; 
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="card">
        <h2>Forgot Password</h2>
        <form method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit" name="submit">Submit</button>
        </form>
    </div>
</body>
</html>
