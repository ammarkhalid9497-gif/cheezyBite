<?php 
$con = mysqli_connect('localhost', 'root', '', 'cheezybite');
session_start();

if (!isset($_SESSION['login']) || $_SESSION['login'] !== true) {
    echo "<script>alert('Please login.')</script>";
    header('location: login.php');
    exit();
}

$order_id = $_GET['order_id'];
$userid   = $_SESSION['user-id'];

// Get order details (from orders table)
$result = mysqli_query($con, "SELECT * FROM orders WHERE id='$order_id' AND user_id='$userid'");
$order_data = mysqli_fetch_assoc($result);

if (!$order_data) {
    echo "<h2>Order not found!</h2>";
    exit();
}

// Get order items
$sql = mysqli_query($con,"SELECT order_items.* , p.name, p.image, p.price 
                          FROM order_items 
                          JOIN products AS p ON order_items.product_id = p.id 
                          WHERE order_items.order_id = '$order_id'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Detail</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      background: #f5f5f5;
      padding: 0;
      overflow-x: hidden;
    }
    nav {
      width: 100%;
      height: 80px;
      padding: 8px;
      display: flex;
      justify-content: space-between;
      background-color: #ffcb04;
      align-items: center;
    }
    nav img {
      width: 100px;
      height: 80px;
    }
    nav ul {
      display: flex;
      gap: 20px;
      list-style: none;
    }
    nav ul a {
      text-decoration: none;
      color: black;
    }
    nav .btn {
      margin: 0px 10px;
      padding: 10px 15px;
      font-size: large;
      border-radius: 8px;
      background-color: black;
      color: white;
    }
    .container {
      padding: 30px;
      background: #fff;
      margin: 20px;
      border-radius: 8px;
    }
    h1 {
      margin-bottom: 20px;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
    }
    .order-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }
    .order-table th, .order-table td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }
    .order-table th {
      background-color: #d32f2f;
      color: white;
    }
    .total-row td {
      font-weight: bold;
      background-color: #fdd835;
    }
    .billing-section h2 {
      background-color: #d32f2f;
      color: white;
      padding: 10px;
      margin-bottom: 0;
    }
    .billing-table {
      width: 100%;
      border: 1px solid #ccc;
      border-top: none;
    }
    .billing-table td {
      padding: 10px;
      border: 1px solid #ddd;
    }
    .social-icons span {
      margin: 0 5px;
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
    }
    .main3 img {
      width: 130px;
      height: 100px;
    }
    .main3 ul {
      text-align: center;
      display: flex;
      gap: 20px;
      list-style: none;
    }
    .main3 .img {
      padding: 15px;
      display: flex;
      gap: 10px;
      align-items: center;
    }
    .main3 .img img {
      width: 20px;
      height: 20px;
    }
    .main4 {
      align-items: center;
      justify-content: center;
      text-align: center;
    }
    /* extra styling for status badge */
    .status-badge {
      padding: 5px 10px;
      border-radius: 5px;
      font-weight: bold;
      color: #fff;
    }
    .status-pending { background-color: #d32f2f; }
    .status-delivered { background-color: #388e3c; }
    .status-processing { background-color: #1976d2; }
  </style>
</head>
<body>
<header>
   <?php include('navbar.php'); ?>
</header>

<main class="container">
  <h1>Order Detail</h1>

  <table class="order-table">
    <thead>
      <tr>
        <th>Food Items</th>
        <th>Quantity</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $grand_total = 0;
      while($row = mysqli_fetch_assoc($sql)) {
          $total_price = $row['price'] * $row['quantity'];
          $grand_total += $total_price;
           echo "<tr>
                <td style='display:flex; align-items:center; gap:10px;'>
                  <img src='images/{$row['image']}' alt='{$row['name']}' style='width:40px; height:30px; border-radius:5px; object-fit:cover;'>
                  {$row['name']}
                </td>
                <td>{$row['quantity']}</td>
                <td>Rs. {$total_price}</td>
              </tr>";
      }
      ?>
      <tr class="total-row">
        <td colspan="2"><strong>Total Price</strong></td>
        <td><strong>Rs. <?php echo $grand_total; ?></strong></td>
      </tr>
    </tbody>
  </table>

  <div class="billing-section">
    <h2>Billing Details</h2>
    <table class="billing-table">
      <tr><td><strong>Name</strong></td><td><?php echo $order_data['name']; ?></td></tr>
      <tr><td><strong>Email</strong></td><td><?php echo $order_data['email']; ?></td></tr>
      <tr><td><strong>Contact No</strong></td><td><?php echo $order_data['contact']; ?></td></tr>
      <tr><td><strong>City</strong></td><td><?php echo $order_data['city']; ?></td></tr>
      <tr><td><strong>Address</strong></td><td><?php echo $order_data['address']; ?></td></tr>
      <tr><td><strong>Payment</strong></td><td><?php echo $order_data['payment']; ?></td></tr>
      <tr><td><strong>Payment Status</strong></td><td><?php echo $order_data['payment_status']; ?></td></tr>
      <tr><td><strong>Order Date</strong></td><td><?php echo $order_data['order_date']; ?></td></tr>
      <tr>
        <td><strong>Status</strong></td>
        <td>
          <?php 
            $status = strtolower($order_data['status']);
            $class = "status-badge status-" . $status;
            echo "<span class='$class'>{$order_data['status']}</span>";
          ?>
        </td>
      </tr>
    </table>
  </div>
</main>

<div class="main3">
   <img src="./logo/logo1.png" alt="">
   <div>
        <ul>
            <li>HOME</li>
            <li>ORDER</li>
            <li>CART</li>
            <li>Cell No.</li>
            <li>Email</li>
        </ul>
   </div>
   <div class="img">
      <img src="./logo/youtube.png" alt="">
      <img src="./logo/twitter.png" alt="">
      <img src="./logo/fb.png" alt="">
   </div>
</div>
<div class="main4">
    <p>copyright # 2025 - all right reserved.</p>
</div>

</body>
</html>
