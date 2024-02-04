<?php require("partials/_dbconnect.php")?>
<?php include('partials/_nav.php');?>


<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use SendGrid\Mail\Mail;

// $message = null;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Function to send the reset token email using SendGrid SMTP
function sendResetTokenEmail($email, $token) {
global $message;

$mail = new Mail();
$mail->setFrom('mailsenderoffecial094@gmail.com', 'Sibraj Negi'); // Replace with your email and name
$mail->addTo($email); // Add a recipient

$mail->setSubject('Password Reset');
$resetLink = "http://localhost/loginsystem/reset_password.php?token=" . urlencode($token);
$htmlContent = "Hi $email,<br><br>You recently requested to reset the password for your account. Click the link below to proceed:<br><br><a href='$resetLink'>$resetLink</a><br><br>If you did not request a password reset, please ignore this email or reply to let us know.";
$mail->addContent("text/html", $htmlContent);

// Send the email using SendGrid
$sendgrid = new \SendGrid('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'); // Replace with your SendGrid API key
try {
    $response = $sendgrid->send($mail);
    if ($response->statusCode() == 202) {
        $message = "Password reset mail has been sent to account: $email";
    } else {
        $message = "Message could not be sent. SendGrid Error: {$response->body()}";
    }
} catch (Exception $e) {
    $message = "Message could not be sent. SendGrid Error: {$e->getMessage()}";
}
}
// Rest of your code remains unchanged...


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get user input from the form
    $email = $_POST['email'];

    // Check if the email exists in the database
    $query = "SELECT * FROM user_table  WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        $message = "Database query error: " . mysqli_error($conn);
    } elseif (mysqli_num_rows($result) > 0) {
        // Generate a random token for password reset
        $token = bin2hex(random_bytes(10));

        $resetTokenExpiration = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // Store the token in the database
        $query = "UPDATE user_table SET token = '$token' , expiration = '$resetTokenExpiration' WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            $message = "Database query error: " . mysqli_error($conn);
        } else {
            // Send the token to the user's email
            sendResetTokenEmail($email, $token);
            $message = "Password reset mail has been sent to account : $email";
            echo ' <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success!</strong> Password reset mail has been sent to account : '.$email.'
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
        </div> ';
        }
    } else {
        // Email does not exist in the database, handle error accordingly
        echo ' <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> Email not found in the database 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
    </div> ';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap');
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family: 'Poppins', sans-serif;
        }
        body{
            background-image:url("https://static.vecteezy.com/system/resources/thumbnails/021/438/780/original/light-blue-gradient-background-copy-space-graphic-animation-video.jpg")
        }
        .container{
            width:50%;
            position:absolute;
            top:50%;
            left:50%;
            transform:translate(-50%,-50%);
            background-color:white;
            padding:20px;
            border-radius:10px;
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
        }
        .text-center{
            font-size:30px;
            text-transform:uppercase;
            margin:20px 0;
        }
        button{
            margin-top:15px;
        }
        .text-center-small{
            text-align:center;
            margin:15px 0;
            font-size:20px;
            color:gray;
        }
    </style>
  </head>
  <body>
    <div class="container my-4">
     <h1 class="text-center">Forgot Password?</h1>
     <h4 class="text-center-small">Enter your email here to get a password reset link</h4>
     <form action="forgot_password.php" method="post">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        <button type="submit" class="btn btn-primary">Send</button>
     </form>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
</body>
</html>