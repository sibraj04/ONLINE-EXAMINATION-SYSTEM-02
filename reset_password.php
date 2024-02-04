<?php 

ob_start(); // Start output buffering

require("partials/_dbconnect.php");

// $message = null;

if (isset($_POST['token']) && isset($_POST['password'])) {
    $token = $_POST['token'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password == $confirm_password) {

        $updateQuery = "UPDATE user_table SET password = ?, token = NULL, expiration = NULL WHERE token = ?";

        $stmt = $conn->prepare($updateQuery);
        if ($stmt) {
            $stmt->bind_param("ss", $password, $token);
            if ($stmt->execute()) {
                // Set a session variable with the success message
                session_start();
                $_SESSION['success_message'] = 'Password Reset Successfully!';
            
                // Redirect to login.php
                header('Location: login.php');
                exit();
            }            
             else {
                echo "Password reset unsuccessful. Please try again later.";
            }
            $stmt->close();
        } else {
            echo  "Database error. Please try again later.";
        }
    } else {
        echo "Passwords do not match!";
    }
}
ob_end_flush(); // Flush the output buffer and send its contents to the browser

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
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
        label{
            margin:10px 0;
        }
        .text-center{
            font-size:30px;
            text-transform:uppercase;
            margin:20px 0;
        }
        button{
            margin-top:15px;
        }
    </style>
</head>
<body>
<?php require 'partials/_nav.php' ?>

<div class="container my-4">
     <h1 class="text-center">Reset Your Password</h1>
     <form action="reset_password.php" method="post">
        <div class="form-group">
            <input type="hidden" name="token" value="<?php echo isset($_GET['token']) ? htmlspecialchars($_GET['token']) : '';?>">
            <label for="password">New Password</label>
            <input type="password" class="form-control" id="password" name="password">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        <button type="submit" class="btn btn-primary">Reset Password</button>
     </form>
    </div>
</body>
</html>