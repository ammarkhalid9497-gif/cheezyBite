<?php

$con = mysqli_connect('localhost','root','','cheezybite');


 
session_start();

 if (isset($_SESSION['login']) && $_SESSION['login']==true) {
   header('location: home.php');
   exit();
 }



 if (isset($_POST['submit'])) {

   $email = $_POST['email'];
   $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
  
    $result =  mysqli_query($con,$sql);



    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
      
       $_SESSION['login'] = true;
       $_SESSION['user-id'] = $row['id'];
       $_SESSION['user-name'] = $row['name'];
       $_SESSION['user-email'] = $row['email'];
       header("Location: home.php") ;
       exit();
    }
    else{
         echo '<script>alert("Invalid email or password")</script>';
    }

 }
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Page</title>
  <style>
    :root{
      --bg:#f4f7fb;
      --card:#ffffff;
      --accent:#5566ff;
      --muted:#6b7280;
      --radius:12px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    *{box-sizing:border-box}
    body{
      padding:0px;
      margin: 0;
    }
     .wrap{
      width:100%;
      margin-top:45px;
     display: flex;
     justify-content: center;
     align-items: center;

    }
    .card{
        width: 600px;;
      background:var(--card);padding:28px;border-radius:var(--radius);box-shadow:0 6px 18px rgba(34,60,80,0.08);
    }
    h2{margin:0 0 12px 0;font-size:20px;color:#0f172a}
    p.lead{margin:0 0 18px 0;color:var(--muted);font-size:14px}

    form{display:flex;flex-direction:column;gap:12px}
    label{font-size:13px;color:var(--muted);display:block}
    input[type="text"], input[type="email"], input[type="password"]{
      width:100%;padding:12px 14px;border-radius:10px;border:1px solid #e6e9f2;font-size:14px;
    }
    .btn{
      display:inline-block;padding:12px 16px;border-radius:10px;border:0;background:var(--accent);color:white;font-weight:600;cursor:pointer;text-align:center;
    }
    .btn.secondary{background:transparent;color:var(--accent);border:1px solid rgba(85,102,255,0.12)}

    .hint{font-size:13px;color:#374151}
    .small{font-size:12px;color:var(--muted)}

    @media (max-width:880px){
      .wrap{grid-template-columns:1fr}
    }
    .foot{margin-top:10px;font-size:12px;color:var(--muted);}
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
  </style>
</head>


<body>
<?php
include('navbar.php');

?>
  <div class="wrap">


    <!-- Login Card -->
    <div class="card">
      <h2>Login</h2>
      <p class="lead">Enter your email and password to log in.</p>
      <form action="#" method="post">
        <div>
          <label for="login-email">Email</label>
          <input id="login-email" name="email" type="email" placeholder="you@example.com" required>
        </div>

        <div>
          <label for="login-password">Password</label>
          <input id="login-password" name="password" type="password" placeholder="Your password" required>
        </div>

        <div style="display:flex;gap:10px;align-items:center;justify-content:space-between;margin-top:6px">
          <button class="btn"  name="submit" type="submit">Login</button>
          <a class="btn secondary" href="#">Forgot Password?</a>
        </div>

        <p class="foot">New user? <a href="singup.php">Sign Up</a></p>
      </form>
    </div>
  </div>
</body>
</html>
