<?php
header("Content-Type: application/json");
require_once "db.php";

// Pull 8 random questions — no user input here so no binding needed,
// but we still use prepare() for consistency and future-proofing
$stmt = $conn->prepare(
    "SELECT id, question, option_a, option_b, option_c, option_d, correct_answer
     FROM soccer_quiz
     ORDER BY RAND()
     LIMIT 8"
);

if (!$stmt) {
    echo json_encode(["error" => "Query preparation failed."]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
}

echo json_encode($questions);

$stmt->close();
$conn->close();
?>
