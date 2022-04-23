<?php
require_once(__DIR__ . '/simple_html_dom.php');
require_once(__DIR__ . '/base.php');

const ENCRYPT_KEY = "__^!@XQ@z#$&*^%%Y&$&*^__";
const ENCRYPT_METHOD = "AES-256-ECB";

function getDownloadLink(string $token, array &$result): bool
{
    $credentials = (array) json_decode(decrypt($token));
    $response = getCurlData('start-downloading/', $credentials);
    if ($response == null)
        return false;
    if ($response == '') {
        return false;
    }
    $BASE_URL = getBaseUrl();
    $downloadPage = str_get_html($response);
    if ($downloadPage == null) {
        return false;
    }
    $downloadAnchor = $downloadPage->find('a[onclick=open_win()]', 0);
    if ($downloadAnchor == null) {
        return false;
    }
    $result['url'] = $downloadAnchor->href;
    foreach ($downloadPage->find('img[src^=/screenshot]') as $screenshot) {
        $imageUrl = $BASE_URL . $screenshot->src;
        $result['screenshots'][] = $imageUrl;
    }
    return true;
}

function getDocumentInfo(string $uri): ?array
{
    $response = getCurlData($uri, null);
    if ($response == null)
        return null;
    if ($response == '') {
        return null;
    }

    $result = [
        'genres'=>null,
        'quality'=>null,
        'audio'=>null,
        'name'=>null,
        'year'=>null,
        'size'=>null,
        'country'=>null,
        'actors'=>null,
        'token'=>null,
        'url'=>null,
        'info'=>[],
    ];

    $mPage = str_get_html($response);
    if ($mPage == null) {
        return null;
    }

    $titleData = getTitleData($mPage->find('h1.entry-title', 0)->plaintext);
    $result['name'] = $titleData['name'];
    if (isset($titleData['year'])) {
        $result['year'] = $titleData['year'];
    }

    $theContent = $mPage->find('div.thecontent', 0);
    if ($theContent == null) return null;
    $infos = $theContent->find('p');
    $result['image'] = $theContent->find('img', 0)->src;
    if (!startsWith($result['image'], 'http')) {
        $result['image'] = getBaseUrl() . $result['image'];
    }
    $infoFetched = false;
    for ($i = 2; $i < sizeof($infos); $i++) {
        $info = html_entity_decode($infos[$i]->plaintext);

        if (strpos($info, 'Download Link') == true) {
            $infoFetched = true;
            continue;
        }

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
        if (sizeof($row) >= 2){
            $key = strtolower($row[0]);
            $result[$key == 'language' ? 'audio' : $key] = trim($row[1]);
        }

    }

    $relatedPosts = $mPage->find('div.related-posts', 0);
    $result['related'] = getDocuments($relatedPosts);

    /* $tokenParams = [];

    foreach ($mPage->find('input[type=hidden]') as $input) {
        if ($input->name == 'fname' && $input->value == '#') {
            $tokenParams = null;
            break;
        }
        $tokenParams[$input->name] = $input->value;
    } */
    /* $token = null;
    if ($tokenParams != null) {
        $token = encrypt(json_encode($tokenParams));
    }
    if ($token == null) {
        $directAnc = $mPage->find('a[onclick=open_win()]', 0);
        if ($directAnc != null) {
            $result['url'] = $directAnc->href;
        }
    } else {
        $result['token'] = $token;
    } */
    /**  
     * this will return either url or token or none of them.
     * In case of token, to get url and screenshots, call getDownlodLink(token, &result) function.
     * In case of none of them, movie isnt downloadable
    */
    return $result;
}

function getDocumentsInPage(int $page = 1, ?string $type, ?string $value = null): ?array
{
    $path = "";
    if ($type != null && $value != null) {
        if ($type == 'year'){
            $type = 'category';
            $value .= '-movies';
        } else if ($type == 's') {
            $type = 'search';
        }
            $path .= $type . '/' . $value . '/';

    }
    $path .= "page/" . $page . "/";

    $response = getCurlData($path, null);
    if ($response == null)
        return null;
    if ($response == '') {
        return null;
    }
    $document = str_get_html($response);
    if ($document == null) {
        return null;
    }
    $mPage = $document->find('body', 0);
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

function getDocuments($container): array
{
    $documents = [];
    foreach ($container->find('article') as $article) {
        $anc = $article->find('a', 1);
        $titleData = getTitleData($anc->innertext);
        $documents[] = [
            'uri' => substr(parse_url($anc->href, PHP_URL_PATH), 1),
            'name' => $titleData['name'],
            'year' => (isset($titleData['year'])) ? $result['year'] = $titleData['year'] : "",
            'image' => $article->find('img', 0)->src
        ];
    }
    return $documents;
}

function encrypt(string $data): string
{
    return openssl_encrypt($data, ENCRYPT_METHOD, ENCRYPT_KEY);
}
function decrypt(string $hash): string
{
    return openssl_decrypt($hash, ENCRYPT_METHOD, ENCRYPT_KEY);
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

function startsWith($haystack, $needle)
{
    return substr($haystack, 0, strlen($needle)) === $needle;
}
