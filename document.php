<?php
require_once('./includes/decoder/main_parser.php');
require_once('./includes/ui/RenderUI.php');

if (!isset($_GET['uri'])) {
    header('Location: ' . './error/400');
}
$uri = $_GET['uri'];
$info = getDocumentInfo($uri, null);

if ($info == null) {
    header('Location: ' . './error/500');
}
$downloadData = null;

if (isset($info['token'])) {
    $downloadData = getDownloadLink($info['token']);
    if ($downloadData == null) {
        header('Location: ' . './error/500');
    }
}


$BASE_URL = getBaseUrl();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php RenderUI::headComponents('Document', './', ['main.css', 'articles.css', 'nav.css']); ?>
    <style>
        img.screenshot {
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

    <?php RenderUI::navbar(); ?>
    <div class="container main-page">
        <?php
        if ($downloadData != null) {
        ?>
            <div class="center-div auto">
                <a class="download-btn" href="<?= $downloadData['url'] ?>">Download</a>
            </div>

            <!-- form to send src -->
            <form class="center-div auto" action="./player" method="post">
                <input type="hidden" name="src" value="<?= $downloadData['url'] ?>">
                <button type="submit" class="download-btn">Play Online</button>
            </form>
            <!-- <video width="320" height="240" controls>
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
    </video> -->
            <div class="center-div auto">
                <center>In case of error, come back and re-click on download button.</center>
            </div>

            <div class="center-div auto">
                <h2>Screenshots:</h2>
            </div>

            <?php
            foreach ($downloadData['screenshots'] as $screenshot) {
                echo '<div class="center-div"><img src="' . $screenshot . '" class="screenshot"></div>';
            }

            ?>
            <br>
            <br>
        <?php
        } else {
        ?>
            <div class="center-div">
                <h2>Movie Coming Soon</h2>
            </div>
        <?php
        }
        ?>
    </div>
    <?php RenderUI::footer(['nav.js']); ?>

</body>

</html>