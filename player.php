<?php
require_once('./includes/ui/RenderUI.php');

if (!isset($_POST['src'])) {
    header("Location: ./");
    exit;
}
$src = $_POST['src']
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php RenderUI::headComponents('Player', './', ['style.css', 'nav.css']); ?>
    <style>
        .video-container {
            background-color: black;
            display: block;
            overflow: hidden;
        }

        video {
            max-height: 480px;
        }
    </style>
</head>

<body>
    <?php RenderUI::navbar(); ?>

    <div class="container main-page">
        <div class="video-container">
            <video width="100%" height="100%" controls>
                <source src="<?= $src; ?>" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    </div>

        <?php RenderUI::footer(['nav.js']); ?>

</body>

</html>