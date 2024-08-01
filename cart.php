<?php
include ('functions/userfunction.php');
include 'includes/header.php' ?>

<body>
<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white"><a class="text-white" href="index.php">Home/</a><a class="text-white" href="cart.php">Cart</a></h6>
    </div>
</div>
  <div class="container">
    <div class="row py-5">
      <div class="col-md-6 justify-content-center">
        <h1>Hello, world!</h1>
        <?php 
        $items = getCartItems(); 

        if ($items) {
            foreach ($items as $citem) {
                echo $citem['name'] . "<br>";
            }
        }
        ?>
      </div>
    </div>
  </div>


  <?php include 'includes/footer.php' ?>