<?php
session_start();
include 'includes/header.php' ?>

<body>
  <div class="container">
    <div class="row py-5">
      <div class="col-md-6 justify-content-center">
        <?php
        if (isset($_SESSION['message'])) {
          ?>
          <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Hey!</strong> <?= $_SESSION['message']; ?>.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php
          unset($_SESSION['message']);
        }
        ?>
        <h1>Hello, world!</h1>
        <button class="btn btn-primary">Testing</button>

      </div>
    </div>
  </div>


  <?php include 'includes/footer.php' ?>