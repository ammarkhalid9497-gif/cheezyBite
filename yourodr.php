<?php

$con = mysqli_connect('localhost', 'root', '', 'cheezybite');
session_start();

if (!isset($_SESSION['login']) && $_SESSION['login'] !== true) {
    echo "<script>alert('Please login to view cart')</script>";
    header('location: login.php');
}



function getorders(){
    global $con;
    $userid = $_SESSION['user-id'];
    $result = mysqli_query($con, "SELECT * FROM orders WHERE user_id = '$userid'");
    while($row = mysqli_fetch_assoc($result))
{
    $order_id = $row['id'];
    $sql = mysqli_query($con,"SELECT COUNT(*) AS total_items FROM order_items WHERE order_id = '$order_id' ");
    $data = mysqli_fetch_assoc($sql);
    $order_items = $data['total_items'] ?? 0;
    echo '
    

    <div class="main">
        <div>
            <h2>
                Order
            </h2>
        </div>
        <div>
            <div class="order">
                <p>Order id</p>
                <p>'.$order_id.'</p>
            </div>
            <div class="order">
                <p>Food items</p>
                <p>'.$order_items.'</p>
            </div>
            <div class="order">
                <p>Totle price</p>
                <P>'.$row['total_price'].'</p>
            </div>
            <div class="order">
                <p>Order status</p>
                <p>'.$row['status'].'</p>
            </div>
            <div class="order">
                <p>Order date</p>
                <p>'.$row['order_date'].'</p>
            </div>

        </div>
        <div class="button">
            <a href="orderdetail.php?order_id='.$order_id.'">
                See Detail
            </a>
        </div>
    </div>
    ';
}

}



?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    body {
        overflow-x: hidden;
        margin: 0;
        padding: 0;
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

    .main {
        width: 300px;
        padding: 15px;
        border-radius: 10px;
        background-color: rgb(31, 27, 27);
        color: white;

        & .button {
            width: 90%;
            background-color: darkred;
            border-radius: 5px;
            padding: 13px;
            border: none;
            text-decoration: none;
            margin-top: 10px;
            text-align: center;

            & a{
                text-decoration: none;
                color: white;
            }
        }

        & h2 {
            text-align: center;
            border-bottom: 2px solid rgb(95, 94, 94);
            padding-bottom: 5px;
            color: rgb(196, 2, 2);
        }

    }

    .order {
        display: flex;
        justify-content: space-between;
        align-items: center;

        p {
            margin: 0;
            padding: 8px 0px;
        }
    }
    .show{
        display: flex;
        justify-content: start;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
        padding: 10px;
        margin-top: 10px;
    }
</style>

<body>

    <header>
        <?php include('navbar.php'); ?>
    </header>

    <div>
        <h1>
            Your Orders
        </h1>
<div class="show">
    
        <?php
          getorders();
        ?>
</div>
    </div>


    
</body>

</html>