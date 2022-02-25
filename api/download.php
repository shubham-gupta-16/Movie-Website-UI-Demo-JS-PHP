<?php
require_once __DIR__ . '/../includes/main_parser.php';
require_once __DIR__ . '/utils/api.php';

if (isset($_GET) && sizeof($_GET) > 0) {
    $info = getDownloadLink($_GET);
    printResponse($info);
}
else {
    printError(400, 'No Credentials provided');
}

