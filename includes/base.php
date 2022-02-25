<?php

function getBaseUrl():string
{
    return file_get_contents(__DIR__ . "/.env");
}

function setBaseUrl(string $url)
{
    file_put_contents(__DIR__ . "/.env", $url);
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
        die("Unknown Error Occured!");
    }

    return $response['data'];
}

function executeCurl(string $url, ?array $postArr)
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    if ($postArr != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
    }

    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $responseHeaders = [];
    curl_setopt(
        $ch,
        CURLOPT_HEADERFUNCTION,
        function ($curl, $header) use (&$responseHeaders) {
            $len = strlen($header);
            $header = explode(':', $header, 2);
            if (count($header) < 2) // ignore invalid responseHeaders
                return $len;

            $responseHeaders[strtolower(trim($header[0]))][] = trim($header[1]);
            return $len;
        }
    );
    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    return [
        'code' => $httpcode,
        'data' => $server_output,
        'headers' => $responseHeaders,
    ];
}
