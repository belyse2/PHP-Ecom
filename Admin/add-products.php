<?php
session_start();
include ('../middleware/adminMiddleware.php');
include ('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4> Add Products</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Select Category</label>
                                <select name="category_id" class="form-select mb-2">
                                    <option selected>Select Category</option>
                                <?php 
                                $categories = getAll("categories");
                                if(mysqli_num_rows($categories) >0)
                                {
                                    foreach($categories as $item){
                                        ?>
                                        <option value="<?= $item['id'];?>"><?= $item['name'];?></option>
                                        <?php
                                    }
                                }
                                else
                                {
                                    echo"Not Category Availables";
                                }
                                ?>
                                </select>
                            </div><br>
                            <div class="col-md-6">
                                <label for="">Name</label>
                                <input type="text" name="name" placeholder="Enter Category Name" class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Slug</label>
                                <input type="text" name="slug" placeholder="Enter Category Slug" class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Decsription</label>
                                <textarea rows="3" name="description" placeholder="Enter Description"
                                    class="form-control"></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Small Description</label>
                                <textarea rows="3" name="small_description" placeholder="Enter small Description"
                                    class="form-control"></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Original Price</label>
                                <input type="text" name="original_price" placeholder="Enter Original Price" class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Selling Price</label>
                                <input type="text" name="selling_price" placeholder="Enter Selling Price" class="form-control mb-2">
                            </div><br>
                            <div class="col-md-12">
                                <label class="mb-0">Upload Image</label>
                                <input type="file" name="image" class="form-control mb-2" required>
                            </div><br>
                            <div class="row">
                            <div class="col-md-6">
                                <label class="mb-0">Quantity</label>
                                <input type="number" name="qty" placeholder="Enter Product Quantity" class="form-control mb-2">
                            </div><br>
                            <div class="col-md-3">
                                <label class="mb-2">Status</label><br>
                                <input type="checkbox" name="status">
                            </div><br>
                            <div class="col-md-3">
                                <label class="mb-2">Trending</label><br>
                                <input type="checkbox" name="trending">
                            </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Title</label>
                                <input type="text" name="meta_title" placeholder="Enter Meta Title"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Decription</label>
                                <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                    class="form-control mb-2"></textarea>
                            </div><br>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords"
                                    class="form-control mb-2"></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" name="add_products_btn">Save</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>