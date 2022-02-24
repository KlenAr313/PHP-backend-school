<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: PUT");
    header("Content-Type: application/json; charset=UTF-8");

    include '../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    include_once("../../model/writer.php");
    include_once("../../services/writerService.php");
    $writer = new WriterModel();
    $writerService = new WriterService();

    if ($_SERVER["REQUEST_METHOD"] != "PUT"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id) || !isset($data->firstName) || !isset($data->lastName) || 
        !isset($data->bornIn) || !isset($data->bornAt) || !isset($data->bornAt) || !isset($data->jwt)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $writer->id = $data->id;
    $writer->firstName = $data->firstName;
    $writer->lastName = $data->lastName;
    $writer->bornIn = $data->bornIn;
    $writer->bornAt = $data->bornAt;
    $writer->died = $data->died;
    
    $config = parse_ini_file('../../config.ini');
    $key = $config['key'];
    try {
        $decoded = JWT::decode($data->jwt, new Key($key, 'HS256'));
    } catch (\Throwable $th) {
        http_response_code(401);
        echo json_encode(array("message" => $th->getMessage()));
        exit;
    }

    if (!$writerService->idExists($data->id)){
        http_response_code(404);
        echo json_encode(array("message" => "Not found"));
        exit;
    }
    
    $writerService->modify($writer);
    http_response_code(200);
    echo json_encode(array("message" => "Successfully modify."));
?>