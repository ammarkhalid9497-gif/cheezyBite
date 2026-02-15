<?php
$con = mysqli_connect('localhost', 'root', '', 'cheezybite');
session_start();

if (!isset($_SESSION['login']) && $_SESSION['login'] !== true) {
  echo "<script>alert('Please login to view cart')</script>";
  header('location: login.php');
}

$userid = $_SESSION['user-id'];

function getCartProduct()
{
  global $con;
  global $userid;

  $sql = "SELECT cart.id, cart.product_id, products.name, products.price, products.image 
              FROM cart 
              INNER JOIN products ON cart.product_id = products.id where user_id = '$userid'";

  $res = mysqli_query($con, $sql);
  $num = mysqli_num_rows($res);

  if ($num == 0) {
    echo "No product found.";
  }

  while ($row = mysqli_fetch_assoc($res)) {

    $productId = $row['id'];
    $productName = $row['name'];
    $productImg = $row['image'];
    $productPrice = $row['price'];

    echo '
          
        <div class="cart-item">
          <img src="images/' . $productImg . '" alt="Chicken Fajita" />
          <div class="item-details">
            <p>' . $productName . ' (x1)</p>
            <small>Rs.' . $productPrice . '</small>
          </div>
          <button class="delete-btn"><i class="fas fa-trash-alt"></i></button>
        </div>
        
        ';
  }
}


function totalItem()
{
  global $con;
  global $userid;

  $query = "SELECT COUNT(*) AS total_items FROM cart where user_id = '$userid'";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['total_items'];
}

function totalPrice()
{
  global $con;
  $query = "SELECT SUM(products.price) AS total_price FROM cart JOIN products ON cart.product_id = products.id; ";
  $result = mysqli_query($con, $query);
  $row = mysqli_fetch_assoc($result);
  return $row['total_price'];
}

$totalItems = totalItem();
$totalPrice = totalPrice();



?>




<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cheezy Bite - Your Bucket</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .hero1 {
    width: 100%;
    height: 300px;
    background: url("./images/ban1.jpg") no-repeat center center/cover;
    display: flex;
    align-items: center;
    justify-content: center;

    div {
      background-color: rgba(255, 255, 255, 0.717);
      padding: 70px 150px;
    }

  }

  nav {
    width: 100%;
    height: 80px;
    padding: 8px;
    display: flex;
    justify-content: space-between;
    background-color: #ffcb04;
    align-items: center;

    img {
      width: 100px;
      height: 80px;
    }

    ul {
      display: flex;
      gap: 20px;
      list-style: none;

      a {
        text-decoration: none;
        color: black;
      }
    }

    .btn {
      margin: 0px 10px;
      padding: 10px 15px;
      font-size: large;
      border-radius: 8px;
      background-color: black;
      color: white;
    }
  }

  body {
    font-family: Arial, sans-serif;
    background-color: #f6f6f6;
  }


  .cart-user {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
  }

  .hero {
    background: url('https://images.unsplash.com/photo-1600891964599-f61ba0e24092') center/cover;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;
    color: #000;
    font-size: 3rem;
    font-weight: bold;
    position: relative;
  }

  .hero::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5);
  }

  .hero h1 {
    position: relative;
    z-index: 1;
  }

  .cart-section {
    display: flex;
    justify-content: space-around;
    padding: 2rem;
  }

  .cart-items {
    width: 50%;
    display: flex;
    flex-direction: column;
    gap: 15px;
  }

  .item{
    width: 100%;
     display: flex;
    flex-direction: column;
    gap: 6px;
  }

  .cart-items h2 {
    margin-bottom: 1rem;
    color: #b22222;
    border-bottom: 2px solid #b22222;
    padding-bottom: 0.5rem;
  }

  .cart-item {
    display: flex;
    align-items: center;
    background: white;
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
  }

  .cart-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 5px;
    margin-right: 1rem;
  }

  .item-details p {
    font-weight: bold;
  }

  .item-details small {
    color: gray;
  }

  .delete-btn {
    margin-left: auto;
    background-color: #ff4d4d;
    border: none;
    color: white;
    padding: 8px 12px;
    border-radius: 5px;
    cursor: pointer;
  }

  .order-summary {
    width: 30%;
    background: #fff200;
    padding: 1.5rem;
    border-radius: 10px;
    height: fit-content;
  }

  .order-summary h3 {
    color: #b22222;
    margin-bottom: 1rem;
  }

  .order-summary p {
    margin: 0.5rem 0;
    font-weight: 600;
  }

  .order-summary .total {
    font-size: 1.2rem;
    padding-bottom: 1rem;
  }

  .checkout-btn {
    width: 100%;
    background-color: #d60000;
    color: white;
    border: none;
    padding: 0.8rem;
    font-size: 1rem;
    font-weight: bold;
    margin-top: 1rem;
    cursor: pointer;
    border-radius: 5px;
    text-decoration: none;
  }

  .main3 {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    text-align: center;
    border-top: 1px solid black;
    padding: 15px;
    margin-top: 10px;

    img {
      width: 130px;
      height: 100px;
    }

    ul {
      display: flex;
      gap: 20px;
      list-style: none;
    }

    .img {

      padding: 15px;
      display: flex;
      gap: 10px;
      align-items: center;

      img {
        width: 20px;
        height: 20px;

      }
    }

  }

  .main4 {
    align-items: center;
    justify-content: center;
    text-align: center;
  }
</style>

<body>
  <header>
    <?php include('navbar.php'); ?>
  </header>
  <main>
    <div class="hero1">
      <div>
        <h1>Your Bucket</h1>
      </div>

    </div>
    <section class="cart-section">
      <div class="cart-items">
        <h2>Your Cart Items</h2>
        <!-- cart items -->
       <div class="item">
         <?php getCartProduct(); ?>
       </div>

      </div>

        <div class="order-summary">
          <h3>Order Summary</h3>
          <p>Items: <span> <?php echo $totalItems; ?></span></p>
          <p>Subtotal: <span> <?php echo $totalPrice; ?></span></p>
          <p class="total">Total: <strong> <?php echo $totalPrice; ?></strong></p>
          <a href="billingdtl.php" class="checkout-btn"><i class="fas fa-credit-card"></i> Checkout Now</a>
        </div>

    </section>
  </main>

  <div class="main3">
    <img src="./logo/logo1.png" alt="">
    <div>
      <ul>
        <li>
          HOME
        </li>
        <Li>
          ORDER
        </Li>
        <li>
          CART
        </li>
        <li>
          cell no.
        </li>
        <li>
          email
        </li>

      </ul>
    </div>

    <div class="img">
      <img src="./logo/youtube.png" alt="">
      <img src="./logo/twitter.png" alt="">
      <img src="./logo/fb.png" alt="">
    </div>
  </div>
  <div class="main4">
    <p>
      copyright # 2025 - all right reserved.
    </p>

  </div>
</body>

</html>