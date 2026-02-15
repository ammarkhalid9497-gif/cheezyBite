<?php

session_start();

$con = mysqli_connect('localhost', 'root', '', 'cheezybite');
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = '$id'";
$res = mysqli_query($con, $sql);
$row = mysqli_fetch_assoc($res)

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

    .main1 {
        border-radius: 10px;
        background-color: antiquewhite;
        display: flex;
        justify-content: space-around;
        gap: 20px;
        padding: 25px;
        margin: 25px;
        width: 90%;
        height: 40%;

        img {
            width: 300px;
            height: 350px;
        }

        h3 {
            color: red;
            font-size: x-large;
            font-weight: bolder;
            border-bottom: 2px solid brown;
            padding-bottom: 6px;
            display: inline-block;
        }

        a {
            font-size: large;
            border-style: none;
            border-radius: 15px;
            background-color: red;
            color: white;
            margin: 0px 8px;
            padding: 10px;
            text-decoration: none;
        }
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
            display: flex;
            gap: 10px;
            align-items: center;

            img {
                width: 20px;
                height: 20px;
            }
        }

    }

    .main2 {
        width: 100%;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;

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


    <?php

        echo '
         <div class="main1">
                 
      <div>
            <img src="./images/' . $row['image'] . '" alt="">
     </div>  
     <div>
           
             <h3>' . $row['name'] . '</h3>
            <p>' . $row['description'] . '</p>
            <p><b>category:</b> ' . $row['category'] . '</p>
            
            <div class="main2">
            <p><b>Rs.</b>  ' . $row['price'] . '</p>
                <div>
                 <label for="">Choose Quantity</label>
                 <input type="number" value="1" id="quantity">
                 </div>

            </div>
            <a href= "addtocart.php?id=' . $row['id'] . '&quantity=" id="addtocart">Add to cart</a>

     </div>
</div>
      ';

    ?>



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

    <script>
        document.getElementById('addtocart').addEventListener('click', function(e) {
            e.preventDefault();
            let quantity = document.getElementById('quantity').value;
            console.log(quantity);
            let url = this.getAttribute('href') + quantity;
            window.location.href = url;
        });
    </script>
</body>

</html>