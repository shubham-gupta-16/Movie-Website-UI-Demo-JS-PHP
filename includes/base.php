<?php

require_once __DIR__ . '/curl.php';

function getBaseUrl():string
{
    return file_get_contents(__DIR__ . "/SOURCE_URL");
}

function setBaseUrl(string $url)
{
    file_put_contents(__DIR__ . "/SOURCE_URL", $url);
}

function getCurlData(string $path, ?array $postArr): ?string
{
    $response = executeCurl(getBaseUrl() . $path, $postArr);
    if (isset($response['headers']['location'])) {
        $location = 'https://' . parse_url($response['headers']['location'][0], PHP_URL_HOST) . '/';
        setBaseUrl($location);
        return getCurlData($path, $postArr);
    }
    if ($response['code'] != 200) {
        return null;
    }

    return $response['data'];
}
