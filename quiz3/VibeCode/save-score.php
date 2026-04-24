<?php
header("Content-Type: application/json");
require_once "db.php";

// Only accept POST requests
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["error" => "Method not allowed."]);
    exit;
}

$player_name = isset($_POST["name"]) ? trim($_POST["name"]) : "Anonymous";
$score       = isset($_POST["score"]) ? intval($_POST["score"]) : 0;
$total       = isset($_POST["total"]) ? intval($_POST["total"]) : 0;

// Prepared statement — user input goes through bind_param, never raw into the SQL string
$stmt = $conn->prepare(
    "INSERT INTO quiz_scores (player_name, score, total, played_at)
     VALUES (?, ?, ?, NOW())"
);

if (!$stmt) {
    echo json_encode(["error" => "Query preparation failed."]);
    exit;
}

$stmt->bind_param("sii", $player_name, $score, $total);
$stmt->execute();

echo json_encode(["success" => true, "message" => "Score saved!"]);

$stmt->close();
$conn->close();
?>
