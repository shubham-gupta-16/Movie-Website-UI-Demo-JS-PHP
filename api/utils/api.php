<?php
header('Content-Type: application/json');

function printResponse(?array $data):void{
    if ($data != null) {
        echo json_encode($data, JSON_PRETTY_PRINT);
    } else {
        printError(404, "Not Found");
    }
}

function printError(int $code, string $message){
    http_response_code($code);
    echo json_encode(['error' => $message], JSON_PRETTY_PRINT);
}