<?php 
session_start();
require "db.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

    //get email from session variable
    $email = $_SESSION["email"];

    $date = date("Y-m-d");

    //get values from form
    $message = $_POST["message"];
    $number = $_POST["phone"];
    
    if(isset($message)){

        $sql = "INSERT INTO supportTickets(email, message ,messageDate) VALUES (?,?,?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email,$message,$date);
        
        if($stmt->execute()){
            echo "record inserted successfully";
        }else{
           echo $stmt->error;
        }

    }

    $conn->close();


}


// CREATE TABLE supportTickets (
//     ticketID INT AUTO_INCREMENT PRIMARY KEY,
//     email VARCHAR(255) NOT NULL,
//     message TEXT NOT NULL,
//     date DATE NOT NULL
// );

//Wamp 2/3 fix = run/ services.msc find mysql80 and stop it. Then find the 3 wamp ones. run the one that isnt running. The reason the sql one wamp doesnt run is cause
// another server is running on my pc.



?>