<?php
$host = "localhost";
$user = "hernac7";
$pass = "FluffyPlushie2381";
$db   = "hernac7db";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    // Don't expose the actual error message to the browser
    http_response_code(500);
    echo json_encode(["error" => "Could not connect to database."]);
    exit;
}
?>
