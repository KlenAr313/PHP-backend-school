<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: PUT");
    header("Content-Type: application/json; charset=UTF-8");

    include '../../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    include_once("../../user.php");
    $user = new User();

    if ($_SERVER["REQUEST_METHOD"] != "PUT"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->firstName) || !isset($data->lastName) || 
        !isset($data->email) || !isset($data->password) || !isset($data->jwt)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->email = $data->email;
    $user->password = $data->password;

    $result = $user->modify($data);
    if ($result === false)
    {
        http_response_code(404);
        echo json_encode(array("message" => "Wrong e-mail or password"));
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

    if ($decoded->data->email != $data->email)
    {
        http_response_code(403);
        echo json_encode(array("message" => "Email address and token data does not match."));
        exit;
    }

    http_response_code(200);
    echo json_encode(array("message" => "Successfully updated."));
?>