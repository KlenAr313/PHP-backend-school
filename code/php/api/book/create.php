<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: POST");
    header("Content-Type: application/json; charset=UTF-8");

    include '../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    include_once("../../model/book.php");
    include_once("../../services/bookService.php");
    include_once("../../services/writerService.php");
    $book = new Book();
    $bookService = new BookService();
    $writerService = new WriterService();

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->title) || !isset($data->category) || 
        !isset($data->published) || !isset($data->writerId) || !isset($data->jwt)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

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

    if (!$writerService->idExists($data->writerId)){
        http_response_code(404);
        echo json_encode(array("message" => "Not found writer"));
        exit;
    }
    
    $bookService->create($book);
    http_response_code(200);
    echo json_encode(array("message" => "Successfully create."));
?>