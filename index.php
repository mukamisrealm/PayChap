<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

echo json_encode(array(
    "status" => "online",
    "project" => "ChapChapPay API",
    "version" => "1.0.0",
    "progress" => "30%",
    "message" => "ChapChapPay backend core is operational.",
    "documentation" => array(
        "register" => "/api/register.php",
        "login" => "/api/login.php",
        "contribute" => "/api/contribute.php",
        "queue" => "/api/rotational_queue.php"
    )
));
?>