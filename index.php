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
$categories = [
    [
        'name' => 'Recommanded',
        'href' => './',
        'active' => $value == null
    ],
    [
        'name' => 'Bollywood',
        'href' => './?category=hindi-movies',
        'active' => $value == 'hindi-movies'
    ],
    [
        'name' => 'Hollywood',
        'href' => './?category=hollywood-movies',
        'active' => $value == 'hollywood-movies'
    ],
    [
        'name' => 'South Indian',
        'href' => './?category=south-movies',
        'active' => $value == 'south-movies'
    ],
];
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
        @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&display=swap');
        /* @import url('https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600&family=Rubik:wght@300;400;600&display=swap'); */
        /* @import url('https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;600&family=Nunito:wght@300;400;600&family=Rubik:wght@300;400;600&display=swap'); */

        * {
            box-sizing: border-box;
            font-family: 'Nunito', 'Calibri', sans-serif;
            /* font-family: 'Rubik', sans-serif; */
            /* font-family: 'Comfortaa', cursive; */
        }

        img {
            vertical-align: middle;
        }

        body {
            font-size: 14px;
            color: white;
            margin: 0;
            padding: 0;
            background-color: #002233;
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

        .main-page {
            margin-top: 100px;
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

        form.search {
            display: grid;
            grid-template-columns: auto auto;
            background-color: #002233;
            border-radius: 50px;
            align-items: center;
            gap: 5px;
        }

        ::placeholder {
            color: #99aabb;
            opacity: 1;
        }

        /* search input */
        form.search input {
            padding: 6px;
            font-size: 17px;
            height: 32px;
            outline: none;
        }

        form.search input[type=text] {
            border: none;
            padding-left: 15px;
            font-size: 14px;
            background-color: transparent;
            color: white;
            width: 100%;
        }

        form.search button[type=submit] {
            background-color: transparent;
            border: none;
            width: 42px;
            height: 32px;
            border-radius: 50px;
            background-repeat: no-repeat;
            background-position: center;
            background-size: 20px;
            background-image: url('./assets/search_icon.svg');
            cursor: pointer;
            transition: 0.2s;
        }

        form.search button[type=submit]:hover {
            background-color: #003344;
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

        #toolbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 999;
            background-color: #001122;
        }

        #toolbar>div {
            height: 55px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        #toolbar>div>div.navigation {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .nav-dropdown {
            position: relative;
            display: inline-block;
        }

        ul.nav-dropdown-content {
            display: flex;
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            text-decoration: none;
            height: 55px;
            color: #bbccdd;
            display: inline-flex;
            align-items: center;
            padding: 12px;
            transition: 0.2s;
        }

        .nav-item.selector {
            background-image: url('./assets/menu_icon.svg');
            background-repeat: no-repeat;
            background-position: center;
            background-size: 20px;
            display: none;
            width: 45px;
            border-radius: 6px;
            height: 45px;
        }

        .nav-item:hover,
        .nav-item.active {
            background-color: #000715;
            color: white;
        }

        @media screen and (max-width: 800px) {

            .nav-dropdown:hover ul.nav-dropdown-content {
                display: block;
            }

            ul.nav-dropdown-content {
                display: none;
                overflow: hidden;
                position: absolute;
                right: 0;
                background-color: #003344;
                min-width: 160px;
                border-radius: 4px;
                box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
                z-index: 999;
            }

            ul .nav-item {
                width: 100%;
            }

            ul .nav-item.active {
                background-color: #003f4f;
            }

            ul .nav-item:hover {
                background-color: #004455;
            }



            .nav-item.selector {
                display: inline-block;
            }
        }

        @media screen and (max-width: 500px) {
            form.search {
                border-radius: 0;
                position: fixed;
                left: 0;
                right: 0;
                display: none;
                top: 0;
                background-color: #001122;
                z-index: 1000;
                height: 50px;
                grid-template-columns: auto 50px;
            }

        }
    </style>
</head>

<body>
    <nav id="toolbar">
        <div class="container">
            <div>LOGO</div>
            <div class="navigation">
                <div>
                    <form class="search" action="" method="GET">
                        <input type="text" name="s" placeholder="Search for a movie...">
                        <button type="submit"></button>
                    </form>
                </div>
                <div class="nav-dropdown">
                    <span class="nav-item selector"></span>
                    <ul class="nav-dropdown-content">
                        <?php
                        foreach ($categories as $nav) {
                        ?>
                            <li>
                                <a class="nav-item <?= $nav['active'] == true ? 'active' : '' ?>" href="<?= $nav['href'] ?>"><?= $nav['name'] ?></a>
                            </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container main-page">

        <!-- search input -->
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
    else if ($with == "?")
        return "./";

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
