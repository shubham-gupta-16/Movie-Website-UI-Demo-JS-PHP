<?php
require_once __DIR__ . '/../includes/main_parser.php';
require_once __DIR__ . '/utils/api.php';

if (isset($_POST) && sizeof($_POST) > 0) {
    $info = getDownloadLink($_POST);
    printResponse($info);
}
else {
    printError(400, 'No Credentials provided');
}

