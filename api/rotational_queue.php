<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

include_once '../config/database.php';

$database = new Database();
$db = $database->getConnection();

$query = "SELECT q.queue_id, q.round_number, q.position_order, q.received_payout, u.full_name, u.phone_number 
          FROM rotational_queue q 
          JOIN users u ON q.user_id = u.user_id 
          ORDER BY q.round_number ASC, q.position_order ASC";

$stmt = $db->prepare($query);
$stmt->execute();

if($stmt->rowCount() > 0) {
    $queue_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        array_push($queue_arr, $row);
    }
    http_response_code(200);
    echo json_encode(array("queue" => $queue_arr));
} else {
    http_response_code(200);
    echo json_encode(array("queue" => array(), "message" => "Queue is currently empty."));
}
?>