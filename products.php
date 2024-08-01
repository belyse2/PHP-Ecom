<?php

include ('functions/userfunction.php');
include('includes/header.php');

if(isset($_GET['category'])){

$category_slug = $_GET['category'];
$category_data = getByslugActive("categories" ,$category_slug);
$category = mysqli_fetch_array($category_data);

if($category){

$cid = $category['id'];
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
        <h6 class="text-white">
            <a class="text-white" href="index.php">
                Home/
            </a>
            <a class="text-white" href="categories.php">
                Collections/
            </a>
            <?= $category['name']; ?>
        </h6>
    </div>
</div>
<div class="py-3">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?= $category['name']; ?> <i class="fa fa-user"></i>
                </h2>
                <hr>
                <div class="row">
                    <?php 
                
        $products = getproductByCategory($cid);
        if(mysqli_num_rows($products) >0){
            foreach($products as $item){
                ?>
                    <div class="col-md-3 mb-2">
                        <a href="product_view.php?product=<?= $item['slug']?>">
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

<?php
}
}
else{
    echo"Something went wrong";
}
include 'includes/footer.php' ?>