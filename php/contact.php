<?php
require "db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $message = $_POST["message"];
    $date = date('Y-m-d'); 

    if (!empty($email) && !empty($message)) {

     
        $sql = "INSERT INTO supportTickets (email, message, messageDate) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $message, $date);

        if ($stmt->execute()) {
            header("Location: ../pages/contact.html");
            exit();
        } else {
            header("Location: ../pages/contact.php?error=insert_failed");
            exit();
        }
    }
}
?>
