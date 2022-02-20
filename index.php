<?php
include('./includes/simple_html_dom.php');
include('./includes/base.php');

$url = BASE_URL;

if (isset($_GET)) {
    if (isset($_GET['page']))
        $url = BASE_URL . "page/" . $_GET['page'] . "/?" . http_build_query($_GET);
    else
        $url = BASE_URL . "?" . http_build_query($_GET);
} else {
    $url = BASE_URL;
}

$response = getCurlData($url, null);

if ($response == '') {
    die("Unknown Error Occured!");
}
$mPage = str_get_html($response);
$documents = [];
foreach ($mPage->find('article') as $article) {
    $anc = $article->find('a', 1);
    $titleData = explode(' (', $anc->innertext, 2);
    $documents[] = [
        'uri' => str_replace(BASE_URL, '', $anc->href),
        'name' => $titleData[0],
        'description' => '(' . $titleData[1],
        'image' => $article->find('img', 0)->src
    ];
}
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
    <title>Download Page</title>
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
            font-family: 'Calibri', sans-serif;
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
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        @media screen and (max-width: 456px) {
            .article-grid {
                grid-gap: 10px;
                grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
            }
        }

        /* article card */

        .doc-card {
            display: block;
            background-color: white;
            overflow: hidden;
            position: relative;
            border: 1px;
            box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .doc-card header {
            position: absolute;
            display: none;
            bottom: 0;
        }

        .doc-card img {
            width: 100%;
            margin: 0;
            height: unset;
        }

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
            border: 2px solid #ccc;
            width: 100%;
        }

        .search-div input[type=submit] {
            background-color: #0088ee;
            border: 2px solid #0088ee;
            color: white;
            cursor: pointer;
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
            foreach ($documents as $document)
                createDocument($document);
            ?>
        </div>
        <center>
            <h4>This website was created for educational purpose. It uses the data of 123MKV. We never promote piracy of copyright content.</h4><span>Developer: Shubham Gupta</span><br><br><br>
        </center>
    </div>

</body>

</html>

<?php

function createDocument(array $data)
{
    echo <<<HTML
    <a href="./download.php?uri={$data['uri']}" class="doc-card">
        <img src="{$data['image']}" alt="{$data['name']}">
       <!--  <header>
            <h2>{$data['name']}</h2>
            <p>{$data['description']}</p>
        </header> -->
        
    </a>
    HTML;
}
