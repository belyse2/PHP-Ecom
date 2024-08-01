<?php

include ('functions/userfunction.php');
include('includes/header.php');

?>
<style>
.category-image {
    height: 200px;
    /* Set the desired height */
    object-fit: cover;
    /* Ensures the image covers the area without distortion */
}
</style>
<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">Home/Collections</h6>
    </div>
</div>
<div class="py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Our Collections <i class="fa fa-user"></i>
                </h1>
                <hr>
                <div class="row">
                    <?php 
                
        $categories = getAllActive("categories");
        if(mysqli_num_rows($categories) >0){
            foreach($categories as $item){
                ?>
                    <div class="col-md-3 mb-2">
                        <a href="products.php?category=<?= $item['slug']?>">
                            <div class="card shadow">
                                <div class="card-body">
                                    <img src="uploads/<?= $item['image']?>" alt="category image"
                                        class="card-img-top img-fluid category-image">
                                    <h4 class="text-center mt-2"><?= $item['name']?></h4>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
            }
        }
        else{
            echo"No data Available Categories";
        }
        ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php' ?>