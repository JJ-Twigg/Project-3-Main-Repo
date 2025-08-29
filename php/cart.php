<?php
session_start(); 

require "db.php"; 

header("Content-Type: application/json"); 

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit();
}

// Convert JSON to PHP array
$item = json_decode(file_get_contents("php://input"), true);

if (!$item || !isset($item["src"]) || !isset($item["price"])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing data']);
    exit();
}

// Retrieve email from session
$email = $_SESSION["email"] ?? null;

if (!$email) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}

$src = $item["src"];
$price = $item["price"];

//this block checks if the image src is already there
$checkSql = "SELECT id FROM cart WHERE email = ? AND src = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->bind_param("ss", $email, $src);
$checkStmt->execute();
$checkResult = $checkStmt->get_result();

if ($checkResult->num_rows > 0) {
    // Item already in cart
    echo json_encode([
        'status' => 'error',
        'message' => 'Item already in cart'
    ]);
    exit();
}

//end block

// Insert into database
$sql = "INSERT INTO cart(email, src, price) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
    exit();
}

$stmt->bind_param("sss", $email, $src, $price);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Product added to cart!',
        'data' => ['src' => $src, 'price' => $price]
    ]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $stmt->error]);
}

exit();
?>




