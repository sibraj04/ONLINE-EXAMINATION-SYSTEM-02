<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        h3{
            text-align:center;
        }
    </style>
</head>
<body>
<?php include('partials/_nav.php');?>
<div class="container my-4">
    <h3>Your Password has been changed Successfully!</h3>
    </div>
</body>
</html>