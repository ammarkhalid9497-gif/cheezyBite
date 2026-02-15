<?php

session_start();
$con = mysqli_connect('localhost','root','','cheezybite');



function getcheezybiteproduct($cheezy){
    global $con;
    $sql = "SELECT * FROM products WHERE category = '$cheezy'";
     $res = mysqli_query($con,$sql);

     while($row = mysqli_fetch_assoc($res)){
      echo '
          <div class="mainA">
           <div>
                 <img src=./images/'.$row['image'].' alt="">
           </div>
           <div>  
                 <h2>'.$row['name'].'</h2>
                 <p>'.$row['description'].'</p>
                 <h4> Rs.'.$row['price'].'</h4>
           </div>
           <div>
                 <a href= "productdetail.php?id='.$row['id'].'">Add to cart</a>
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
    <link rel="stylesheet" href="./css/style.css">
    <title>Document</title>
</head>
<style>
    body{
        overflow-x:hidden ;
        margin: 0;
        padding: 0;
        background-color: #cfb139c0;
    }
nav{
    width: 100%;
    height: 80px;
    padding: 8px;
    display: flex;
    justify-content:space-between;
    background-color: #ffcb04;
    align-items: center;

    img{
        width: 100px;
        height: 80px;
    }
    ul{
        display: flex;
        gap: 20px;
        list-style: none;
        a{
          text-decoration: none;
          color: black;
        }
    }
    .btn{
        margin: 0px 10px ;
        padding: 10px 15px;
        font-size: large;
        border-radius: 8px;
        background-color:black;
        color: white;
    }
}    
.hero{
    margin: 45px auto;
    width: 90%;
    height: 300px;
    img{
        width: 100%;
        height: 100%;
        border-radius: 10px;
    }
}
.heading{
    width: 90%;
    margin: auto;
    color: brown;
    padding-left: 10px;
    border-bottom: 2px solid brown;
    
}
.main{
    display: flex;
    justify-content: start;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    padding:25px;
}
.mainA{
    background-color:antiquewhite;
    width:250px ;
    text-align: center;
    border-radius: 8px;
    padding: 20px 8px;
    img{
        width: 240px;
        height: 200px; 
        border-radius: 10px;
    }
   
    h2{
        border-bottom: 1px solid grey;
        padding: 8px;

    }
    p{
        font-size:12px;
        margin:0;
    }
    a{
        text-decoration : none;
        background-color: red;
        color: white;
        border-radius: 15px;
        font-size: 16px;
        border-style: none;
        padding: 10px;
    }
}

.main1{
    border-radius: 10px;
    background-color: antiquewhite;
    justify-content: space-between;
    padding: 25px;
    margin: 25px;
    width: 90%;
    height:40% ;
    align-items: center;
    

    display: flex;
    img{
        width:500px ;
        height:300px ;
    }
    h3{
        color: red;
    }
    button{
        font-size: 18px;
        border-style: none;
        border-radius: 15px;
        background-color: red;
        color: white;
          margin: 0px 8px ;
        padding: 10px;
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
   <div class="hero">
    <img src="./images/hero.png" alt="">
   </div>
   <div>
    <h2 class="heading">App Exclvsive</h2>
   </div>
<div class="main">
      
<?php
 getcheezybiteproduct('exclusive');
?>
</div>
<div class="main1">

                 
      <div>
            <h3>welcome</h3>
            <h1>We make the best fizza in <br> your town</h1>
            <p>This is so testy plz try again in one time and <br> best the areya off in town.<br> This is so testy tast try yours frnds  best the <br> areya off in town. </p>
            <button> privious rivew </button>
     </div>  
     <div>
            <img src="./images/pngwing.com.png" alt="">
     </div>
</div>
 
 
<div>
    <h2 class="heading">starters</h2>
   </div>
<div class="main">
      
<?php
 getcheezybiteproduct('starter');
?>
</div>

<div>
    <h2 class="heading">top deals</h2>
   </div>
<div class="main">
      
<?php
 getcheezybiteproduct('topdeal');
?>
</div>
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