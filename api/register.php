<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';
include_once '../models/User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->full_name) && !empty($data->phone_number) && !empty($data->password)) {
    $user->full_name = $data->full_name;
    $user->phone_number = $data->phone_number;
    $user->language_preference = $data->language_preference ?? 'eng';
    $user->password_hash = password_hash($data->password, PASSWORD_BCRYPT);

    if($user->register()) {
        http_response_code(201);
        echo json_encode(array("message" => "User registered successfully."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to register user."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete data provided."));
}
?>