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

$cartaccount = totalItem();
$totalPrice = totalPrice();
$user_name = $_SESSION['user-name'];
$email = $_SESSION['user-email'];

if(isset($_POST['submit_order'])) {
  global $con;
  $contact_no = $_POST['contact'];
  $city = $_POST['city'];
  $address = $_POST['address'];
  $payment = $_POST['payment'];
  $payment_status = '';

  if ($payment == 'cod'){
    $payment_status = 'pending';
  } else {
    $payment_status = 'paid';
  }

  $cart_query = mysqli_query($con, "SELECT * FROM cart WHERE user_id ='$userid' ");

  $order_query = mysqli_query($con, "INSERT INTO orders(user_id,total_price,name,email,contact,city,address,payment,payment_status) 
                             VALUES ('$userid','$totalPrice','$user_name','$email','$contact_no','$city','$address','$payment','$payment_status')");
  if ($order_query) {
    $order_id = mysqli_insert_id($con);
    while ($cart_items = mysqli_fetch_assoc($cart_query)) {
      $product_id = $cart_items['product_id'];
      $quantity = $cart_items['quantity'];
      mysqli_query($con, "INSERT INTO order_items(order_id,product_id,quantity,total_price) VALUE ('$order_id','$product_id','$quantity','$totalPrice')");
    }
    mysqli_query($con, "DELETE FROM cart WHERE user_id = '$userid'");
    echo "<script>alert('order placed successfully.')</script>;";
  } else {
    echo "<script>alert('order failed.plase try again.')</script> ";
  }
}
?>






<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cart Checkout - Cheezy Bite</title>
  <link rel="stylesheet" href="style.css" />
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
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
    background: #f6f6f6;
    color: #333;
  }
a{
  text-decoration: none;
}

  .profile {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .banner {
    background: orange;
    background: url("./images/out.png") no-repeat center center/cover;
    text-align: center;
    padding: 50px 0;
    color: black;
    font-size: 2em;
    font-weight: bold;
    height: 300px;
    display: flex;
    justify-content: center;
    align-items: center;

    div {
      background-color: rgba(255, 255, 255, 0.582);
      padding: 80px 150px;
    }

  }


  .banner h1 {
    font-size: 30px;
    background: rgba(255, 255, 255, 0.7);
    display: inline-block;
    padding: 10px 30px;
    border-radius: 10px;
  }

  .container {
    display: flex;
    justify-content: space-between;
    padding: 40px;
    flex-wrap: wrap;
  }

  .billing {
    background: white;
    padding: 30px;
    width: 60%;
    border-radius: 10px;
  }

  .billing h2 {
    margin-bottom: 20px;
    color: darkred;
  }

  .billing .row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 15px;
  }

  .billing label {
    display: block;
    margin: 5px 0 2px;
  }

  .billing input,
  .billing textarea {
    width: 48%;
    padding: 8px;
    margin-bottom: 10px;
  }

  .billing textarea {
    width: 100%;
    height: 60px;
  }

  .billing button {
    width: 100%;
    background: darkred;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 15px;
  }

  .bucket {
    background: #222;
    color: #eee;
    padding: 30px;
    width: 35%;
    height: 300px;
    border-radius: 10px;
    gap: 30px;


  }

  .spam {
    color: darkred;
  }

  .bucket h3 {
    margin-bottom: 40px;
    border-bottom: 2px solid gold;
    padding-bottom: 5px;
  }

  .bucket ul {
    list-style: none;
  }

  .bucket li {
    display: flex;
    justify-content: space-between;
    padding: 15px 0;
  }

  .bucket .total {
    border-top: 1px solid #eee;
    margin-top: 10px;
    color: darkred;
    font-weight: bold;
  }



  .social a {
    margin: 0 5px;
    font-size: 20px;
  }

  footer {
    background: #eee;
    padding: 20px;
    text-align: center;
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
      text-align: center;
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

  <!-- Navbar -->
  <header>

    <?php include('navbar.php'); ?>

  </header>
  <!-- Banner -->
  <section class="banner">
    <h1>Cart Checkout</h1>
  </section>

  <!-- Main Content -->
  <main class="container">
    <!-- Billing Details -->
    <div class="billing">
      <h2>Billing Details</h2>
      <form action="billingdtl.php" method="post">
        <div class="row">
          <div style="flex:1;">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="Ali" required>
          </div>
          <div style="flex:1;">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="ali@gmail.com" required>
          </div>
        </div>

        <div class="row">
          <div style="flex:1;">
            <label for="contact">Contact No:</label>
            <input type="text" id="contact" name="contact" placeholder="e.g. 03001234567" required>
          </div>
          <div style="flex:1;">
            <label for="city">City:</label>
            <input type="text" id="city" name="city" placeholder="E.g. Lahore, Karachi" required>
          </div>
        </div>

        <label for="address">Complete Address:</label>
        <textarea id="address" name="address" placeholder="Street name, house no, nearby landmark, etc." required></textarea>

        <p><strong>Select Payment Method:</strong></p>
        <div class="payment-options">
          <label><input type="radio" name="payment" value="cod" checked> Cash on Delivery</label><br>
          <label><input type="radio" name="payment" value="card"> Credit Card</label>
        </div>

        <button type="submit" name='submit_order'>Place Your Order</button>
      </form>
    </div>

    <!-- Order Summary -->
    <div class="bucket">
      <h3>Your Bucket List</h3>
      <ul>
        <li><span><span class="spam">1</span>. Chicken Fajita (x1)</span><span>1050.00</span></li>
        <li><span><span class="spam">2</span>. Chicken Spice Burger (x1)</span><span>420.00</span></li>
        <li><span><span class="spam">3</span>. Pizza Stacker (x1)</span><span>790.00</span></li>
        <li class="total"><span>Total</span><span>2260.00</span></li>
      </ul>
    </div>
  </main>

  <!-- Footer -->

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

</body>

</html>