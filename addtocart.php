<?php
$con = mysqli_connect ('localhost', 'root', '', 'cheezybite');
session_start();

 if (!isset($_SESSION['login']) && $_SESSION['login']!==true) {
     echo "<script>alert('Please login to add items to cart')</script>";
     header('location: login.php');
 }

$userid=$_SESSION['user-id'];
$proId = $_GET['id'];
$quantity = $_GET['quantity'];

// Cast to integer to prevent SQL injection and invalid data
    $proId = (int)$proId;

    // Check if product exists before inserting
    $checkProduct = mysqli_query($con, "SELECT id FROM products WHERE id = $proId");
    if (mysqli_num_rows($checkProduct) > 0) {
        $sql = mysqli_query($con, "INSERT INTO cart(user_id,product_id,quantity) VALUES ('$userid','$proId','$quantity')");
        if ($sql) {
            echo "<script>alert('Product is added to cart')</script>";
            header("location: cart.php");
        } else {
            echo "Product is not added";
        }
    } else {
        echo "Invalid product ID: Product not found";
    }
?>