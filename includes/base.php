<?php
const BASE_URL = 'https://123mkv.onl/';



function getCurlData(string $url, ?array $postArr): ?string
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    if ($postArr != null) {
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postArr));
    }

    curl_setopt($ch, CURLOPT_HEADER, true);    // we want headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpcode != 200) {
        die("Unknown Error Occured!");
    }

    return $server_output;
}