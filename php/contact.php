<?php

require "db.php"; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST["name"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    if (isset($name) && isset($email) && isset($message)) {
        echo "Name: " . $name . "<br>";
        echo "Email: " . $email . "<br>";
        echo "Message: " . $message . "<br>";

        $sql = "INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            echo "Message submitted successfully We'll get back to you!!";
            header("Location: ../pages/contact.php?success=1");
            exit();
        } else {
            echo "Error inserting data: " . $stmt->error;
            header("Location: ../pages/contact.php?error=insert_failed");
            exit();
        }
    } else {
        echo "All fields are required.";
        header("Location: ../pages/contact.php?error=missing_fields");
        exit();
    }
}
?>

