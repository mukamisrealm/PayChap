<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"));

if(!empty($data->user_id) && !empty($data->amount) && !empty($data->phone_number)) {
    $query = "INSERT INTO contributions (user_id, amount, phone_number, status) VALUES (:user_id, :amount, :phone_number, 'pending')";
    $stmt = $db->prepare($query);

    $stmt->bindParam(":user_id", $data->user_id);
    $stmt->bindParam(":amount", $data->amount);
    $stmt->bindParam(":phone_number", $data->phone_number);

    if($stmt->execute()) {
        http_response_code(200);
        echo json_encode(array(
            "message" => "STK Push initiated successfully.",
            "contribution_id" => $db->lastInsertId(),
            "status" => "pending"
        ));
    } else {
        http_response_code(500);
        echo json_encode(array("message" => "Failed to initiate transaction."));
    }
} else {
    http_response_code(400);
    echo json_encode(array("message" => "Incomplete contribution data."));
}
?>