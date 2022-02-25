<?php
require_once __DIR__ . '/../includes/main_parser.php';

header('Content-Type: application/json');

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = (int)$_GET['page'];


$s = null;
if (isset($_GET['s']) && strlen($_GET['s']) > 0)
    $s = $_GET['s'];

$pageData = getDocumentsInPage($page, $s);

if ($pageData != null) {
    echo json_encode($pageData, JSON_PRETTY_PRINT);
} else {
    // header error code
    http_response_code(404);
    echo json_encode(['error' => 'Page not found'], JSON_PRETTY_PRINT);
}