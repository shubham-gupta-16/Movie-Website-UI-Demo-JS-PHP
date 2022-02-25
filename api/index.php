<?php
require_once __DIR__ . '/../includes/main_parser.php';
require_once __DIR__ . '/utils/api.php';

$page = 1;
if (isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0)
    $page = (int)$_GET['page'];


$s = null;
if (isset($_GET['s']) && strlen($_GET['s']) > 0)
    $s = $_GET['s'];

$pageData = getDocumentsInPage($page, $s);

printResponse($pageData);