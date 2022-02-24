<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: DELETE");
    header("Content-Type: application/json; charset=UTF-8");

    include '../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    include_once("../../services/bookService.php");
    $bookService = new BookService();

    if ($_SERVER["REQUEST_METHOD"] != "DELETE"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id) || !isset($data->jwt)) {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $config = parse_ini_file('../../config.ini');
    $key = $config['key'];
    try {
        $decoded = JWT::decode($data->jwt, new Key($key, 'HS256'));
    } catch (\Throwable $th) {
        http_response_code(401);
        echo json_encode(array("message" => $th->getMessage()));
        exit;
    }

    if (!$bookService->idExists($data->id)){
        http_response_code(404);
        echo json_encode(array("message" => "Not found"));
        exit;
    }

    $result = $bookService->delete($data->id);
    http_response_code(200);
    echo json_encode(array("message" => "Deleted"));
?>