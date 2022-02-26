<?php

require_once('./includes/main_parser.php');

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

// die(json_encode($pageData, JSON_PRETTY_PRINT));
/* header('Content-Type: application/json');
echo json_encode($documents);
die(); */
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Page</title>
    <style>
        * {
            box-sizing: border-box;
        }

        img {
            vertical-align: middle;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: #002233;
            font-family: 'Calibri', sans-serif;
        }

        footer {
            background-color: #001122;
            color: white;
            padding-top: 10px;
            margin-top: 35px;
        }

        a {
            text-decoration: none;
        }

        .container {
            display: block;
            margin-left: auto;
            margin-right: auto;
            padding: 0 15px;
            max-width: 1200px;
        }

        .center-div {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .article-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            grid-gap: 20px;
        }



        /* article card */

        .doc-card {
            display: block;
            background-color: #001122;
            overflow: hidden;
            position: relative;
            padding-top: 150%;
            transition: 0.3s;
            border: 1px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .doc-card>div {
            background-repeat: no-repeat;
            background-position: center;
            background-size: cover;
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            transform: scale(1.01);
            transition: transform 0.4s ease 0.1s;
            right: 0;
        }

        .doc-card:hover {
            box-shadow: 0 0 25px rgba(50, 180, 255, 0.4);
        }

        .doc-card:hover>div {
            transform: scale(1.1);
            /* filter: blur(2px); */
        }

        .doc-card:hover>header {
            opacity: 1;
        }

        .doc-card:hover>header>div {
            transform: translateY(0px);
        }

        .doc-card>header {
            position: absolute;
            bottom: 0;
            padding: 150px 10px 10px 10px;
            opacity: 0;
            color: white;
            transition: 0.3s;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0));

            left: 0;
            right: 0;
        }

        .doc-card>header>div {
            transform: translateY(8px);
            transition: transform 0.6s;
        }

        .doc-card>header>.d-name {
            font-size: 1.2em;
            font-weight: bold;
            transition: 0.4s;

        }

        /* .doc-card img {
            width: 100%;
            margin: 0;
            height: unset;
        } */

        img.aligncenter {
            width: 100%;
            max-width: 700px;
        }

        a.download-btn {
            text-decoration: none;
            color: white;
            padding: 8px 20px;
            border-radius: 8px;
            background-color: #a82711;
        }

        .search-div form {
            margin-bottom: 40px;
            display: grid;
            grid-template-columns: auto auto;
            gap: 5px;
        }

        /* search input */
        .search-div input {
            padding: 6px;
            font-size: 17px;
            outline: none;
            border-radius: 5px;
        }

        .search-div input[type=text] {
            border: 2px solid #557788;
            background-color: #001122;
            color: white;
            width: 100%;
        }

        .search-div input[type=submit] {
            background-color: #001122;
            border: none;
            border: 2px solid #557788;
            color: #0099ff;
            cursor: pointer;
        }

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

        @media screen and (max-width: 600px) {
            .article-grid {
                grid-gap: 10px;
                grid-template-columns: repeat(auto-fill, minmax(145px, 1fr));
            }
        }

        @media screen and (max-width: 505px) {
            .article-grid {
                grid-gap: 10px;
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            }

            .doc-card>header>.d-name {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <br><br>

        <!-- search input -->
        <div class="center-div search-div">
            <form action="" method="GET">
                <input type="text" name="s" placeholder="Search for a movie...">
                <input type="submit" value="Search">
            </form>
        </div>
        <div class="article-grid">

            <?php
            foreach ($pageData['documents'] as $document)
                createDocument($document);
            ?>
        </div>

        <?php
        if ($pageData['pages'] > 1) {
        ?>
            <div class="paginate-div">
                <?php
                if ($page > 1) {
                ?>
                    <a href="<?= getHref($page - 1, $type, $value) ?>">PREV</a>
                <?php
                }
                ?>
                <a href="<?= getHref(1, $type, $value) ?>" class="<?php if ($page == 1) echo 'active' ?>">1</a>
                <?php
                if ($page > 4) {
                ?>
                    <span>...</span>
                <?php
                }
                ?>
                <?php
                $row = $pageData['pages'] <= 4 ? $pageData['pages'] : ($page > 4 ? $page : 4);
                $startPoint = ($page > 4 ? $page - 2 : 2);
                for ($i = $startPoint; $i <= $row; $i++) {
                ?>
                    <a href="<?= getHref($i, $type, $value) ?>" class="<?php if ($page == $i) echo 'active' ?>">
                        <?= $i; ?>
                    </a>
                <?php
                }
                ?>
                <?php
                if ($pageData['pages'] > 5 && $page < $pageData['pages'] - 1) {
                ?>
                    <span>...</span>
                <?php
                }
                ?>
                <?php
                if ($pageData['pages'] > 4 && $page < $pageData['pages']) {
                ?>
                    <a href="<?= getHref($pageData['pages'], $type, $value) ?>" class="<?php if ($page == $pageData['pages']) echo 'active' ?>">
                        <?= $pageData['pages'] ?>
                    </a>
                <?php
                }
                ?>
                <?php
                if ($page < $pageData['pages']) {
                ?>
                    <a href="<?= getHref($page + 1, $type, $value) ?>">NEXT</a>
                <?php
                }
                ?>
            </div>
        <?php
        }
        ?>

    </div>
    <footer>
        <center>
            <h4>This website was created for educational purpose. It uses the data of 123MKV. We never promote piracy of copyright content.</h4><span>Developer: Shubham Gupta</span><br><br><br>
        </center>
    </footer>
</body>

</html>

<?php

function getHref(int $page, $type, $value)
{
    $href = "?page=" . $page;
    if ($type != null && $value != null) $href = "?$type=" . $value . appendPage("&", $page);
    else $href = appendPage("?", $page);
        return $href;
}
function appendPage(string $with, int $page)
{
    if ($page > 1)
        return $with . "page=" . $page;
    return "";
}

function createDocument(array $data)
{
?>
    <a href="./document?uri=<?= $data['uri'] ?>" class="">
        <div class="doc-card">
            <div style="background-image: url(<?= $data['image'] ?>);"></div>
            <header>
                <div class="d-name"><?= $data['name'] ?></div>
                <div><?= $data['year'] ?></div>
            </header>
        </div>
        <!-- <img src="{}" alt="{$data['name']}"> -->
        <!--  <header>
            <h2>{$data['name']}</h2>
            <p>{$data['description']}</p>
        </header> -->

    </a>
<?php
}
