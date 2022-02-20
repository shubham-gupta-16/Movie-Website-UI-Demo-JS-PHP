<?php
include('./includes/simple_html_dom.php');
include('./includes/base.php');
if (!isset($_GET['uri'])) {
    die("Unknown Error Occured!");
}
$uri = $_GET['uri'];
$response = getCurlData(BASE_URL . $uri, null);

if ($response == '') {
    die("Unknown Error Occured!");
}
$mPage = str_get_html($response);

$params = [];
foreach ($mPage->find('input[type=hidden]') as $input)
    $params[$input->name] = $input->value;
$response = getCurlData(BASE_URL . 'start-downloading/', $params);
$downloadPage = str_get_html($response);

$downloadAnchor = $downloadPage->find('a[onclick=open_win()]', 0);
$downloadAnchor->class = 'download-btn';
$downloadAnchor->innertext = 'Download Now';
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
            color: white;
            padding: 8px 20px;
            outline: none;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            display: inline-block;
            background-color: #a82711;
        }
    </style>
</head>

<body>

    <div class="center-div">
        <?= $downloadAnchor->outertext ?>
    </div>

    <!-- form to send src -->
    <form class="center-div" action="player.php" method="post">
        <input type="hidden" name="src" value="<?= $downloadAnchor->href ?>">
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
    foreach ($downloadPage->find('img[src^=/screenshot]') as $screenshot) {
        $screenshot->src = BASE_URL . $screenshot->src;
        echo '<div class="center-div">' . $screenshot->outertext . '</div>';
    }

    ?>
</body>

</html>