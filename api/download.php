<?php
require_once __DIR__ . '/../includes/decoder/main_parser.php';
require_once __DIR__ . '/utils/api.php';

if (isset($_GET['token']) && strlen($_GET['token']) > 0) {
    $info = getDownloadLink($_GET['token']);
    printResponse($info);
}
else {
    printError(400, 'No Credentials provided');
}

