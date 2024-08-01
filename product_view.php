<?php

include ('functions/userfunction.php');
include('includes/header.php');

if(isset($_GET['product'])){

$product_slug = $_GET['product'];
$product_data = getByslugActive("products" ,$product_slug);
$product = mysqli_fetch_array($product_data);

if($product){

?>
<div class="py-3 bg-primary">
    <div class="container">
        <h6 class="text-white">
            <a class="text-white" href="index.php">
                Home/
            </a>
            <a class="text-white" href="categories.php">
                Collections/
            </a>
            <?= $product['name']; ?>
        </h6>
    </div>
</div>
<div class="bg-light py-4">
    <div class="container product-data mt-3">
        <div class="row">
            <div class="col-md-4">
                <div class="shadow">
                    <img src="uploads/<?= $product['image']; ?>" alt="product image"
                        class="card-img-top img-fluid category-image w-100">
                </div>
            </div>
            <div class="col-md-8">
                <h4 class="fw-bold"><?=$product['name']; ?>
                    <span class="float-end text-danger"><?php if($product['trending']){echo"Trending";}?></span>
                </h4>
                <hr>
                <p><?=$product['small_description']; ?></p>
                <div class="row">
                    <div class="col-md-6">
                        <h5>$<s class="text-danger"><?=$product['original_price']; ?></s></h5>
                    </div>
                    <div class="col-md-6">
                        <h5>$<span class="text-success fw-bold"><?=$product['original_price']; ?></span></h5>
                    </div>
                </div>
                <div class="row product-data">
                    <div class="col-md-4">
                        <div class="input-group mb-3" style="width:130px;">
                            <button class="input-group-text decrement-btn">-</button>
                            <input type="text" class="form-control input-qty text-center bg-white" value="1"disabled>
                            <button class="input-group-text increment-btn">+</button>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <button class="btn-primary px-4 addToCartBtn" value="<?= $product['id']?>"><i class="fa fa-shopping-cart me-2"></i>Add to cart</button>
                    </div>
                    <div class="col-md-6">
                        <button class="btn-danger px-4"><i class="fa fa-heart me-2"></i>Add to wishList</button>
                    </div>
                </div>
                <hr>
                <h6>Product Description</h6>
                <p><?=$product['description']; ?></p>
            </div>
        </div>
    </div>
</div>
<?php
}
else{
    echo"Product Not Found";
}
}
else{
    echo"Something went wrong";
}
include 'includes/footer.php' ?>