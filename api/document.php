<?php
require_once __DIR__ . '/../includes/main_parser.php';
require_once __DIR__ . '/utils/api.php';

$uri = null;
if (isset($_GET['uri']) && strlen($_GET['uri']) > 0){
    $uri = $_GET['uri'];
    $info = getDocumentInfo($uri);
    printResponse($info);
}
else {
    printError(400, 'No URI specified');
}

