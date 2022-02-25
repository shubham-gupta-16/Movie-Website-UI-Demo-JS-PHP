<?php
require_once(__DIR__ . '/simple_html_dom.php');
require_once(__DIR__ . '/base.php');


function getDownloadLink(array $credentials)
{
    $response = getCurlData('start-downloading/', $credentials);
    if ($response == null)
        return null;
    if ($response == '') {
        return null;
    }
    $BASE_URL = getBaseUrl();
    $downloadPage = str_get_html($response);
    $result = [];
    $downloadAnchor = $downloadPage->find('a[onclick=open_win()]', 0);
    $result['url'] = $downloadAnchor->href;
    foreach ($downloadPage->find('img[src^=/screenshot]') as $screenshot) {
        $imageUrl = $BASE_URL . $screenshot->src;
        $result['screenshots'][] = $imageUrl;
        
    }
    return $result;
}
function checkRemoteFile($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    // don't download content
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    curl_setopt($ch, CURLOPT_FAILONERROR, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($ch);
    curl_close($ch);
    if ($result !== FALSE) {
        return true;
    } else {
        return false;
    }
}


function getDocumentInfo(string $uri): ?array
{
    $response = getCurlData($uri, null);
    if ($response == null)
        return null;
    if ($response == '') {
        return null;
    }

    $result = array();

    $mPage = str_get_html($response);

    $titleData = getTitleData($mPage->find('h1.entry-title', 0)->plaintext);
    $result['name'] = $titleData['name'];
    if (isset($titleData['year'])) {
        $result['year'] = $titleData['year'];
    }

    $infos = $mPage->find('div.thecontent', 0)->find('p');
    $infoFetched = false;
    for ($i = 2; $i < sizeof($infos); $i++) {
        $info = html_entity_decode($infos[$i]->plaintext);

        if ($infoFetched) {
            $result['info'][] = $info;
            continue;
        }

        if (endsWith($info, ':') !== false) {
            $infoFetched = true;
            continue;
        }
        if (strpos($info, ':') == false) {
            continue;
        }
        $row = explode(':', $info, 2);
        if (sizeof($row) >= 2)
            $result[strtolower($row[0])] = trim($row[1]);
    }

    $relatedPosts = $mPage->find('div.related-posts', 0);
    $result['related'] = getDocuments($relatedPosts);

    foreach ($mPage->find('input[type=hidden]') as $input)
        $result['credentials'][$input->name] = $input->value;
    return $result;
}

function getDocumentsInPage(int $page = 1, ?string $s = null): ?array
{
    $path = "";
    if ($s != null)
        $path .= 'search/' . $s . '/';
    $path .= "page/" . $page . "/";

    $response = getCurlData($path, null);
    if ($response == null)
        return null;
    if ($response == '') {
        return null;
    }
    $mPage = str_get_html($response)->find('body', 0);
    $pages = 1;
    $links = $mPage->find('div[class=nav-links]', 0);
    if ($links != null) {
        $paginations = $links->find('a');
        $pages = (int) $paginations[sizeof($links->find('a')) - 2]->innertext;
        // var_dump($links->children());
    }
    if ($pages < $page) {
        $pages = $page;
    } 
    return [
        'pages' => $pages,
        'documents' => getDocuments($mPage)
    ];
}

function getDocuments($container) : array{
    $documents = [];
    foreach ($container->find('article') as $article) {
        $anc = $article->find('a', 1);
        $titleData = getTitleData($anc->innertext);
        $documents[] = [
            'uri' => substr(parse_url($anc->href, PHP_URL_PATH), 1),
            'name' => $titleData['name'],
            'year' => (isset($titleData['year'])) ?$result['year'] = $titleData['year']: "",
            'image' => $article->find('img', 0)->src
        ];
    }
    return $documents;
}

function getTitleData(string $title)
{
    $titleData = explode(' (', $title, 2);
    $result = [
        'name' => $titleData[0]
    ];
    if (sizeof($titleData) > 1) {
        $result['year'] = explode(')', $titleData[1])[0];
    }

    return $result;
}

function endsWith($haystack, $needle)
{
    return substr_compare($haystack, $needle, -strlen($needle)) === 0;
}
