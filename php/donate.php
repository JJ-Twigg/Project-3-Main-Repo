<?php
require "db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sub'])) {

    $email = trim($_POST['email']);
    $message = trim($_POST['message']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $itemType = trim($_POST['itemType']);

    if (!empty($email) && !empty($message) && !empty($address) && !empty($itemType)) {

        $sql = "INSERT INTO donations (email, message, phone, address, itemType) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssss", $email, $message, $phone, $address, $itemType);

        if ($stmt->execute()) {
           header("Location: ../pages/donation.html");
        } else {
            header("Location: ../pages/donate.php?error=insert_failed");
            exit();
        }
    } else {
        header("Location: ../pages/donate.php?error=missing_fields");
        exit();
    }
}
?>

