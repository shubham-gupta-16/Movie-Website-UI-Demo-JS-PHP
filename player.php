<?php
if (!isset($_POST['src'])) {
    header("Location: ./");
    exit;
}
$src = $_POST['src']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #000000;
            font-family: 'Calibri', sans-serif;
        }

        a {
            text-decoration: none;
        }

        .container {
            background-color: black;
            display: block;
            overflow: hidden;
        }
        video {
            max-height: 480px;
        }

        .center-div {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>

    <div class="container">


        <!-- video mp4 -->
        <video width="100%" height="100%" controls>
            <source src="<?= $src; ?>" type="video/mp4">
            Your browser does not support HTML5 video.
        </video>
    </div>

</body>

</html>
