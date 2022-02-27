<?php

require_once('./includes/decoder/main_parser.php');
require_once('./includes/ui/RenderUI.php');

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = (int)$_GET['page'];

$BASE_URL = getBaseUrl();

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
$pageData = getDocumentsInPage($page, $type, $value);
if ($pageData == null) {
    header('Location: ' . './error/500');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php RenderUI::headComponents('Home Page', './', ['main.css', 'articles.css', 'nav.css']); ?>
    <style>
        .paginate-div {
            display: flex;
            justify-content: center;
            margin-top: 60px;
            color: white;
            gap: 10px;
        }

        .paginate-div>* {
            display: inline-block;
            padding: 5px 10px;
        }

        .paginate-div>a {
            background-color: #001122;
            color: #0088ff;
            border-radius: 5px;
            transition: 0.2s;
        }

        .paginate-div>a:hover {
            background-color: #000715;
        }

        .paginate-div>a.active {
            background-color: #000511;
        }
    </style>
</head>

<body>
    <?php RenderUI::navbar($type, $value); ?>
    <div class="container main-page">

        <!-- search input -->
        <div class="article-grid">

            <?php
            foreach ($pageData['documents'] as $document)
                RenderUI::article($document);
            ?>
        </div>

        <?php RenderUI::pagination($pageData['pages'], $page, $type, $value); ?>
    </div>
    <?php RenderUI::footer(['nav.js']); ?>
</body>

</html>
