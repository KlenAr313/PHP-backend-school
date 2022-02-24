<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Request-Method: POST");
    header("Content-Type: application/json; charset=UTF-8");

    include_once("../../user.php");
    $user = new User();

    if ($_SERVER["REQUEST_METHOD"] != "POST"){
        http_response_code(405);
        echo json_encode(array("message" => "Method not allowed."));
        exit;
    }

    $data = json_decode(file_get_contents("php://input"));
    if (!isset($data->firstName) || !isset($data->lastName) || 
        !isset($data->email) || !isset($data->password)) 
    {
        http_response_code(406);
        echo json_encode(array("message" => "Bad JSON format."));
        exit;
    }

    $user->firstName = $data->firstName;
    $user->lastName = $data->lastName;
    $user->email = $data->email;
    $user->password = $data->password;

    if ($user->emailExists() === true)
    {
        http_response_code(409);
        echo json_encode(array("message" => "Email already exists."));
        exit;
    }

    $result = $user->signUp($data);
    if ($result === false)
    {
        http_response_code(500);
        echo json_encode(array("message" => "Uknonwn error."));
        exit;
    }
    
    http_response_code(201);
    echo json_encode(array("message" => "Successfully signed up."));
?>