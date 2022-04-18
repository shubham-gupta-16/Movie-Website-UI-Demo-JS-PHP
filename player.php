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
    <?php RenderUI::headComponents(
        'Player',
        './',
        ['style.css', 'nav.css'],
        null,
        '<link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />'
    ); ?>
    <style>
        .video-container {
            background-color: black;
            display: block;
            overflow: hidden;
            width: 100%;
        }

        .vjs-big-play-button{
            position: absolute !important;
            top: 50% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            border-radius: 1.6em !important;
            height: 1.6em !important;
            width: 1.6em !important;
        }
    </style>
</head>

<body>
    <?php RenderUI::navbar(); ?>

    <div class="container main-page">
        <div class="video-container">
            <video id="my-video" class="video-js vjs-fluid" controls preload="auto" width="100%" height="100%" data-setup="{}">
                <source src="<?= $src; ?>" type="video/mp4">
                Your browser does not support HTML5 video.
            </video>
        </div>
    </div>

    <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>
    <script>
        let player = videojs('my-video', {
            fluid: true
        });
    </script>
    <?php RenderUI::footer(['nav.js']); ?>

</body>

</html>