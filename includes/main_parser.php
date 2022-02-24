<?php
require_once(__DIR__ . '/simple_html_dom.php');
require_once(__DIR__ . '/base.php');

function getDocumentsInPage(int $page = 1, ?string $s = null): array
{
    $path = "";
    if ($s != null)
        $path .= 'search/' . $s . '/';
    $path .= "page/" . $page . "/";
    

        echo $path;
    $response = getCurlData($path, null);
    if ($response == '') {
        die("Unknown Error Occured!");
    }
    $mPage = str_get_html($response)->find('body', 0);
    $pages = 1;
    $links = $mPage->find('div[class=nav-links]', 0);
    if ($links != null) {
        $paginations = $links->find('a');
        $pages = (int) $paginations[sizeof($links->find('a')) - 2]->innertext;
        // var_dump($links->children());
    }

    $documents = [];
    foreach ($mPage->find('article') as $article) {
        $anc = $article->find('a', 1);
        $titleData = explode(' (', $anc->innertext, 2);
        $documents[] = [
            'uri' => substr(parse_url($anc->href, PHP_URL_PATH), 1),
            'name' => $titleData[0],
            'description' => '(' . $titleData[1],
            'image' => $article->find('img', 0)->src
        ];
    }
    return [
        'pages' => $pages,
        'documents' => $documents
    ];
}
