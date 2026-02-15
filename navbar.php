
<nav>
           <div>
            <img src="./logo/logo1.png" alt="img">
           </div>
           <div>
            <ul>
                <li>
                    <a href="home.php">Home</a>
                </li>
                <Li>
                   <a href="yourodr.php"> Order</a>
                </Li>
                <li>
                   <a href="cart.php"> Cart</a>
                </li>
            </ul>
           </div>
           <div>

           <?php if(isset($_SESSION['login']) && $_SESSION['login'] == true):  ?>

            <a href="logout.php" class="btn" type="button" style="text-decoration: none; background-color:#6c0505d3">logout </a>
              <?php else:  ?>
            <a href="login.php" class="btn btn-sm" type="button" style="text-decoration: none; background-color: #6c0505d3">login</a>
            <?php endif;  ?>

           </div>
  </nav
