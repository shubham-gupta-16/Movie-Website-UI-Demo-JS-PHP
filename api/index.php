<?php
require_once __DIR__ . '/../includes/main_parser.php';
require_once __DIR__ . '/utils/api.php';

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = (int)$_GET['page'];


$type = null;
$value = null;
if (isset($_GET['category']) && strlen($_GET['category']) > 0) {
    $value = $_GET['category'];
    $type = 'category';
} elseif (isset($_GET['year']) && strlen($_GET['year']) > 0) {
    $value = $_GET['year'];
    $type = 'year';
} elseif (isset($_GET['s']) && strlen($_GET['s']) > 0) {
    $value = $_GET['s'];
    $type = 'search';
}

$pageData = getDocumentsInPage($page, $type, $value);

printResponse($pageData);
