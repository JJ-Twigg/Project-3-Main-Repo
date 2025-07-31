<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/index.css">
    <script src="../js/shoppingCart.js?v=123" defer></script>
    <title>StyleForLess</title>

</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark" style="background: #141414;">
  <div class="container-fluid">
      <a class="navbar-brand" href="#"><img src="../resources/alphas-black.png" style="width: 7.5vw; aspect-ratio: 1/1;"></a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 mx-auto">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="../index.html">Home</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="../pages/signUp.html">Shop</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./pages/signUp.html">About</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./pages/donation.html">Donations</a>
              </li>
              <li class="nav-item">

                  <a class="nav-link" href="./pages/signIn.html">Contact</a>
              </li>
              <li class="nav-item">
                  <a class="nav-link" href="./pages/shoppingCart.php">
                      <i class="fas fa-shopping-cart"></i>
                  </a>
              </li>
              <li>
                <a class="nav-link" href="./pages/signIn.html">SignIn</a>
            </li> 
            
                <button id="logOutButton" onclick="logOut()">logOut</button>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="./pages/shoppingCart.php">Checkout</a>
                <span id="cartCounter">0</span>
            </li>  
          </ul>
          <form class="d-flex">
              <button class="btn-sign-up">Sign Up</button>
          </form>
      </div>
  </div>
</nav>

<?php 
// TODO 1. need a way of checking for duplicates, so only prints one idk. or stop it happening on another page like index js idk
session_start();

require "../php/db.php";

if(isset($_SESSION["email"])){

    $email = $_SESSION["email"];

    $sql = "SELECT price,src,id FROM cart WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
    
        while ($row = $result->fetch_assoc()) {
            
            $id = $row['id'];   
            $price = $row['price'];
            $src = $row['src'];
            
            // concatenate . because now resources is one folder above
            // $src = ".." . $src;
        
            // echo "Price: " . $price . "<br>";
            // echo "Image Source: " . $src . "<br><br>";

            echo "<div>";
            echo "<img src='" . $src . "' style='width: 350px; height: 320px;' alt='Item Image'>";
            echo "<p>Price: " . $price . "</p>";
            echo "uid: " . $id;
            echo "<button class='deleteButton' data-id='$id'><i class='fas fa-times-circle'></i></button>";
            echo "</div>";
           
        }
    } else {
        
        echo "your cart is empty";
    }

    $stmt->close();

}else{
    echo "not logged in";
}







?>

<body>

    <!-- <ul>
        <li><?php if(isset($price)){echo $price;} ?></li>
        <li></li>
    </ul>

    <div class="container">
        <div class="row">
          <div class="col">
            <img src="<?php if(isset($src)){echo $src;} ?>" style="width:350px; height:320px" >
            <h2><?php if(isset($price)){echo $price;}?></h2>
            <button type="button" name="button" class="btn btn-primary cartButton" data-price="10.56" data-src="./resources/5026662.jpg" >shoppingCartPlaceholder</button>
          </div>
        </div>
      </div> -->

    

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</html>