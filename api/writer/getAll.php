<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: GET");
    header("Content-Type: application/json; charset=UTF-8");

    include_once("../../services/writerService.php");
    $writerService = new WriterService();

    if ($_SERVER["REQUEST_METHOD"] != "GET"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    http_response_code(200);
    echo json_encode($writerService->getAll());
?>