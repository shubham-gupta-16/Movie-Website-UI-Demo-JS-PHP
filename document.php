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

if (isset($info['token'])) {
    if (getDownloadLink($info['token'], $info) == false) {
        header('Location: ' . './error/500');
    }
}


$BASE_URL = getBaseUrl();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php RenderUI::headComponents(
        'Document',
        './',
        ['style.css', 'article.css', 'nav.css'],
        null,
        '<link href="https://vjs.zencdn.net/7.18.1/video-js.css" rel="stylesheet" />'
    ); ?>
    <style>
        img.screenshot {
            width: 100%;
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
            background-color: #003344;
            border: 1px solid transparent;
            transition: 0.2s;
        }

        .download-btn:hover {
            background-color: #004455;
            border: 1px solid #006677;
        }

        .small-container {
            max-width: 720px;
            margin-left: auto;
            margin-right: auto;
        }

        .info-container {
            display: grid;
            gap: 20px;
            grid-template-columns: 30% auto;
        }

        .download-btn-row {
            display: flex;
            padding-top: 18px;
            gap: 12px;
        }

        .info-note {
            color: #99aabb;
            font-style: italic;
            margin-top: 5px;
            display: inline-block;
            font-size: 12px;
        }

        p {
            color: #bbccdd;
        }

        h1.info,
        h2.info,
        h3.info,
        h4.info {
            margin: 0;
        }

        h1.info.title {
            font-size: 34px;
        }

        .info.meta {
            color: #bbccdd;
        }

        .info.genres {
            margin-top: 18px;
            color: #ddeeff;
            font-size: 16px;
        }

        .info.actors {
            margin-top: 6px;
            color: #aabbcc;
            font-style: normal;
        }

        .info.actors b {
            color: #ddeeff;
        }

        @media screen and (max-width: 600px) {
            .info-container {
                grid-template-columns: auto;
            }

            .info-img {
                max-width: 200px;
                /* display: none; */
            }
        }

        .tooltip {
            position: relative;
            display: inline-block;
        }

        .tooltip .tooltiptext {
            visibility: hidden;
            width: 140px;
            background-color: #567;
            color: #fff;
            text-align: center;
            border-radius: 6px;
            padding: 5px;
            position: absolute;
            z-index: 1;
            bottom: 150%;
            left: 50%;
            margin-left: -75px;
            opacity: 0;
            transition: opacity 0.3s;
        }

        .tooltip .tooltiptext::after {
            content: "";
            position: absolute;
            top: 100%;
            left: 50%;
            margin-left: -5px;
            border-width: 5px;
            border-style: solid;
            border-color: #567 transparent transparent transparent;
        }

        .tooltip:hover .tooltiptext {
            visibility: visible;
            opacity: 1;
        }

        .video-container {
            background-color: black;
            display: block;
            overflow: hidden;
            width: 100%;
        }

        .vjs-big-play-button {
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
        <div class="small-container">
            <div class="info-container">
                <div class="info-img">
                    <div class="doc-card">
                        <div style="background-image: url(<?= $info['image'] ?>); opacity:1"></div>
                    </div>
                </div>
                <div>
                    <h1 class="info title"><?= $info['name'] ?></h1>
                    <h3 class="info meta"><?= $info['year'] . ' • ' . $info['audio'] . ' • ' . $info['quality'] . ' • ' . $info['size'] ?></h3>
                    <h3 class="info genres"><?= $info['genres'] ?></h3>
                    <div class="info actors"><b>Actors:</b> <?= $info['actors'] ?></div>
                    <!-- rm b -->
                </div>

            </div>
            <!-- rm p -->
        </div>
        <br>
        <div class="small-container">
            <h2>Movie Description:</h4>
                <?php
                foreach ($info['info'] as $p) {
                    echo '<p>' . $p . '</p>';
                }
                ?>
                <br>

                <?php
                if (isset($info['screenshots'])) {
                ?>

                    <h2>Screenshots:</h2>

                    <?php
                    foreach ($info['screenshots'] as $screenshot) {
                        echo '<div class="center-div"><img src="' . $screenshot . '" class="screenshot"></div>';
                    }

                    ?>
                    <br>
                    <br>
                <?php
                }
                ?>
        </div>

    </div>
    <script src="https://vjs.zencdn.net/7.18.1/video.min.js"></script>
    <script>
        function outFunc() {
            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Copy to clipboard";
        }

        function copyLink(copyText) {
            navigator.clipboard.writeText(copyText);

            var tooltip = document.getElementById("myTooltip");
            tooltip.innerHTML = "Link Copied!";
        }
        let player = videojs('my-video', {
            fluid: true
        });
    </script>
    <?php RenderUI::footer(['nav.js']); ?>

</body>

</html>