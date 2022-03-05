<?php

require_once('./includes/decoder/main_parser.php');
require_once('./includes/ui/RenderUI.php');

$type = null;
$value = null;
if (isset($_GET['category']) && strlen($_GET['category']) > 0) {
    $value = $_GET['category'];
    $type = 'category';
} elseif (isset($_GET['year']) && strlen($_GET['year']) > 0) {
    $value = $_GET['year'];
    $type = 'year';
} elseif (isset($_GET['s']) && strlen($_GET['s']) > 0) {
    $value = $_GET['s'];
    $type = 's';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php RenderUI::headComponents('Home Page', './', ['style.css', 'article.css', 'nav.css', 'loader.css']); ?>
    <style>
        #more-loader {
            display: flex;
            display: none;
            width: 100%;
            margin-top: 40px;
            height: 20px;
            justify-content: center;
            align-items: center;
        }
        #more-loader p{
            text-align: center;
        }
        #main-loader{
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .loader-shift{
            padding-left: 17px;
        }
    </style>
    <script>
        const PARAM_TYPE = <?= $type == null ? 'null' : "'$type'" ?>;
        const PARAM_VALUE = <?= $value == null ? 'null' : "'$value'" ?>;
    </script>
</head>

<body>
    <div id="doc-wrapper" style="height: calc(100vh - 55px); overflow:auto; margin-top:55px">

        <?php RenderUI::navbar($type, $value); ?>
        <div class="container main-page" style="margin-top: 45px;">

            <!-- search input -->
            <div id="document-container" class="article-grid">
            </div>

            <div id="more-loader">
                <div class="cssload-contain loader-shift">
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                </div>
            </div>
            <div id="main-loader">
                <div class="cssload-contain loader-shift">
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                    <div class="cssload-dot"></div>
                </div>
                <p class="center-div">Loading</p>
            </div>
        </div>
        <?php RenderUI::footer(['nav.js', 'api.js', 'index.js']); ?>
    </div>


</body>

</html>