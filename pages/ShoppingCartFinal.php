<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>My Shopping Bag</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="../css/shoppingCartFinal.css">
  <script src="../js/shoppingCart.js" defer></script>
</head>

<body>

  <!-- <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
  <div class="container">
    <a class="navbar-brand" href="#">ShopLogo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav mx-auto">
        <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Shop</a></li>
        <li class="nav-item"><a class="nav-link" href="#">About</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Donations</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="#"><i class="bi bi-cart3"></i></a></li>
        <li class="nav-item"><a class="btn btn-outline-light ms-3" href="#">Sign Up</a></li>
      </ul>
    </div>
  </div>
</nav> -->

  <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3">
    <div class="container d-flex align-items-center">
      <a class="navbar-brand" href="#">ShopLogo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="mainNav">
        <ul class="navbar-nav mx-auto d-flex align-items-center">
          <li class="nav-item"><a class="nav-link active" aria-current="page" href="../index.html">HomeTest</a></li>
          <li class="nav-item"><a class="nav-link" href="../home.html">Home</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/shop.html">Shop</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/AboutPage.html">About</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/DonationsPage.html">Donations</a></li>
          <li class="nav-item"><a class="nav-link" href="../pages/contact.html">Contact</a></li>
          <li class="nav-item d-flex align-items-center">
            <a class="nav-link" href="../pages/ShoppingCartFinal.php"><i class="bi bi-cart3"></i></a>
            <span id="cartCounter" class="ms-1"></span>
          </li>
          <li class="nav-item"><a class="btn btn-outline-light ms-3" href="../pages/signIn.html">Sign In</a></li>
          <li class="nav-item"><button id="logOutButton" class="btn btn-outline-light ms-3" onclick="logOut()">Log Out</button></li>
        </ul>
      </div>
    </div>
  </nav>


  <!-- MAIN CONTENT -->
  <div class="container my-5">
    <!-- FIXED: add d-flex flex-wrap to parent row -->
    <div class="row d-flex flex-wrap">

      <!-- LEFT: Shopping Bag -->
      <div class="col-12 col-lg-8" style="max-height: 80vh; overflow-y:auto;">
        <h3 class="bag-header">MY SHOPPING BAG</h3>
        <div class="divider"></div>

        <div class="row fw-bold mb-2">
          <div class="col-6">PRODUCT</div>
          <div class="col-2">PRICE</div>
          <div class="col-2">QUANTITY</div>
          <div class="col-2 text-end">TOTAL</div>
        </div>

        <span id="cartCounter"></span>

        <?php
        session_start();
        require "../php/db.php";

        if (isset($_SESSION["email"])) {

          $email = $_SESSION["email"];

          $sql = "SELECT price, src, id FROM cart WHERE email = ?";
          $stmt = $conn->prepare($sql);
          $stmt->bind_param("s", $email);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

              $id = $row['id'];
              $price = $row['price'];
              $src = $row['src'];

              echo "
                <div class='row align-items-center py-3 border-bottom'>
                    <div class='col-6 d-flex align-items-center'>
                        <img src='$src' class='me-3' alt='Product' style='width:60px; height:60px;'>
                        <div>Product #$id</div>
                    </div>
                    <div class='col-2'>R$price</div>
                    <div class='col-2 d-flex align-items-center'>
                        <button class='btn btn-sm btn-outline-secondary me-2 quantity-decrease' data-id='$id'>-</button>
                        <span class='quantity'>1</span>
                        <button class='btn btn-sm btn-outline-secondary ms-2 quantity-increase' data-id='$id'>+</button>
                    </div>
                    <div class='col-2 text-end'>
                        R$price
                        <button class='deleteButton btn btn-danger btn-sm ms-2' data-id='$id'>
                            <i class='fas fa-times-circle'></i>
                        </button>
                    </div>
                </div>
                ";
            }
          } else {
            echo "<div class='text-center py-3'>Your cart is empty</div>";
          }

          $stmt->close();
        } else {
          echo "<div class='text-center py-3'>Not logged in</div>";
        }
        ?>
      </div>

      <script>
        document.querySelectorAll('.quantity-increase').forEach(btn => {
          btn.addEventListener('click', () => {
            const qtyElem = btn.previousElementSibling;
            qtyElem.textContent = parseInt(qtyElem.textContent) + 1;
          });
        });

        document.querySelectorAll('.quantity-decrease').forEach(btn => {
          btn.addEventListener('click', () => {
            const qtyElem = btn.nextElementSibling;
            let qty = parseInt(qtyElem.textContent);
            if (qty > 1) qty--;
            qtyElem.textContent = qty;
          });
        });
      </script>


      <!-- RIGHT: Summary -->
      <div class="col-12 col-lg-4">
        <div class="summary-box">
          <h5>SUMMARY</h5>
          <div class="divider"></div>

          <!-- <label for="promo" class="form-label">Do you have a promo code?</label>
          <div class="input-group mb-4">
            <input id="promo" type="text" class="form-control promo-input" placeholder="Enter code">
            <button class="btn btn-dark" id="applyPromo" type="button">APPLY</button>
          </div> -->

          <div class="mb-2 d-flex justify-content-between">
            <span>Subtotal:</span><span>R2300.00</span>
          </div>
          <div class="mb-2 d-flex justify-content-between">
            <span>Shipping:</span><span>R55.00</span>
          </div>
          <div class="mb-4 d-flex justify-content-between">
            <span>Tax:</span><span>R15.00</span>
          </div>

          <div class="divider"></div>
          <div class="d-flex justify-content-between fs-5 fw-bold mb-4">
            <span>Estimated Total:</span><span>R2370.00</span>
          </div>

          <button class="btn btn-dark checkout-btn">CHECKOUT</button>
        </div>
      </div>

    </div>
  </div>

  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Your Custom JS -->
  <script src="script.js"></script>
</body>

</html>