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

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id)) {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $result = $writerService->getById($data->id);
    if ($result == null){
        http_response_code(404);
        echo json_encode(array("message" => "Not found."));    
        exit;
    }

    http_response_code(200);
    echo json_encode($result);
?>