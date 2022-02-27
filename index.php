<?php

require_once('./includes/decoder/main_parser.php');

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

// $pageData = ['pages' => 1, 'documents' => []];
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
    <link href="./assets/css/main.css" rel="stylesheet">
    <link href="./assets/css/articles.css" rel="stylesheet">
    <link href="./assets/css/nav.css" rel="stylesheet">

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
    <nav id="toolbar">
        <div class="container">
            <div>LOGO</div>
            <div class="navigation">
                <div>
                    <form class="search" action="" method="GET">
                        <span id="mobile-search-close" class="image-icon back-icon"></span>
                        <input type="text" name="s" placeholder="Search for a movie..." value="<?= $type == 's' ? $value : '' ?>">
                        <button type="submit" class="image-icon search-icon"></button>
                    </form>
                    <button type="submit" id="mobile-search-open" class="image-icon search-icon"></button>
                </div>
                <div class="nav-dropdown">
                    <span class="nav-item image-icon selector"></span>
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
            <h4>This website was created for educational purpose. It uses the data of 123MKV. We never promote piracy of copyright content.</h4><span>Developer: Shubham Gupta</span>
        </center>
    </footer>
    <script>
        let searchOpen = document.getElementById('mobile-search-open');
        let searchClose = document.getElementById('mobile-search-close');
        let searchForm = document.querySelector('form.search');
        searchOpen.addEventListener('click', () => {
            searchForm.style.display = 'grid';
        });
        searchClose.addEventListener('click', () => {
            searchForm.style.display = 'none';
        });
    </script>
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
