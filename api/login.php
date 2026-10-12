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

if(!empty($data->phone_number) && !empty($data->password)) {
    $user->phone_number = $data->phone_number;
    $stmt = $user->login();
    $num = $stmt->rowCount();

    if($num > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify BCrypt password hash
        if(password_verify($data->password, $row['password_hash'])) {
            http_response_code(200);
            echo json_encode(array(
                "message" => "Login successful.",
                "user" => array(
                    "user_id" => $row['user_id'],
                    "full_name" => $row['full_name'],
                    "role" => $row['role'],
                    "language_preference" => $row['language_preference']
                )
            ));
        } else {
            http_response_code(401);
            echo json_encode(array("message" => "Invalid credentials. Password incorrect."));
        }
    } else {
        http_response_code(404);
        echo json_encode(array("message" => "User phone number not found."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete login details."));
}
?>