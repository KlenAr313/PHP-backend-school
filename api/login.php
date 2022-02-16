<?php

    include '../vendor/autoload.php';
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: POST");
    header("Content-Type: application/json; charset=UTF-8");

    include_once("../user.php");
    $user = new User();

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->email) || !isset($data->password)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $user->email = $data->email;
    $user->password = $data->password;

    $result = $user->login($data);
    if ($result === false)
    {
        http_response_code(403);
        echo json_encode(array("message" => "Access denied."));
        exit;
    }
    
    $config = parse_ini_file('../config.ini');
    $key = $config['key'];
    $payload = array(
        "iss" => "SLO",
        "iat" => time(),
        "exp" => time()+60*60,
        "data" => array(
            "email" => $user->email,
            "firstName" => $user->firstName,
            "lastName" => $user->lastName
        )
    );
    
    $token = JWT::encode($payload, $key, 'HS256');

    http_response_code(200);
    echo json_encode(array(
                        "message" => "Successfully logged in.",
                        "jwt" => $token
                    ));
?>