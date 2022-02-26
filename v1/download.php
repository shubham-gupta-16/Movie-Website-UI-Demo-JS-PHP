<?php
include('../includes/main_parser.php');

if (!isset($_GET['uri'])) {
    die("Unknown Error Occured!");
}
$uri = $_GET['uri'];
$info = getDocumentInfo($uri, null);

if ($info == null) {
    die("Unknown Error Occured!");
}
$downloadData = getDownloadLink($info['credentials']);

// die(json_encode($downloadData, JSON_PRETTY_PRINT));


$BASE_URL = getBaseUrl();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Page</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            color: white;
            background-color: #002233;
            font-family: 'Calibri', sans-serif;
        }

        .center-div {
            display: flex;
            justify-content: center;
            margin-left: auto;
            margin-right: auto;
            margin-top: 20px;
            padding: 0 15px;
            border: none;
        }

        img.aligncenter {
            width: 100%;
            max-width: 700px;
        }

        .download-btn {
            text-decoration: none;
            color: #0099ff;
            padding: 8px 20px;
            outline: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-block;
            background-color: #001122;
        }
    </style>
</head>

<body>

    <div class="center-div">
        <a class="download-btn" href="<?= $downloadData['url'] ?>">Download</a>
    </div>

    <!-- form to send src -->
    <form class="center-div" action="player.php" method="post">
        <input type="hidden" name="src" value="<?= $downloadData['url'] ?>">
        <button type="submit" class="download-btn">Play Online</button>
    </form>
    <!-- <video width="320" height="240" controls>
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
    </video> -->
    <div class="center-div">
        <center>In case of error, come back and re-click on download button.</center>
    </div>

    <div class="center-div">
        <h2>Screenshots:</h2>
    </div>

    <?php
    foreach ($downloadData['screenshots'] as $screenshot) {
        echo '<div class="center-div"><img src="' . $screenshot . '" width="700"></div>';
    }

    ?>
    <br>
    <br>
</body>

</html>