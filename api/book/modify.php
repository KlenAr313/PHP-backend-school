<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: PUT");
    header("Content-Type: application/json; charset=UTF-8");

    include '../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    include_once("../../model/book.php");
    include_once("../../services/bookService.php");
    $book = new Book();
    $bookService = new BookService();

    if ($_SERVER["REQUEST_METHOD"] != "PUT"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->id) || !isset($data->title) || !isset($data->category) || 
        !isset($data->published) || !isset($data->writerId) || !isset($data->jwt)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $book->id = $data->id;
    $book->title = $data->title;
    $book->category = $data->category;
    $book->published = $data->published;
    $book->writerId = $data->writerId;
    
    $config = parse_ini_file('../../config.ini');
    $key = $config['key'];
    try {
        $decoded = JWT::decode($data->jwt, new Key($key, 'HS256'));
    } catch (\Throwable $th) {
        http_response_code(401);
        echo json_encode(array("message" => $th->getMessage()));
        exit;
    }
    
    $bookService->modify($book);
    http_response_code(200);
    echo json_encode(array("message" => "Successfully modify."));
?>