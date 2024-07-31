<?php
session_start();
include ('../middleware/adminMiddleware.php');
include ('includes/header.php');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <?php
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $products = getByID('products', $id);
                if (mysqli_num_rows($products) > 0) {
                    $data = mysqli_fetch_array($products);
                    ?>
            <div class="card">
                <div class="card-header">
                    <h4>Edit Product</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                        <div class="row">
                            <div class="col-md-12">
                                <label for="">Select Category</label>
                                <select name="category_id" class="form-select mb-2">
                                    <option selected>Select Category</option>
                                    <?php 
                                $categories = getAll("categories");
                                if(mysqli_num_rows($categories) > 0)
                                {
                                    foreach($categories as $item){
                                        ?>
                                    <option value="<?= $item['id']; ?>"
                                        <?= ($item['id'] == $data['category_id']) ? 'selected' : ''; ?>>
                                        <?= $item['name']; ?></option>

                                    <?php
                                    }
                                }
                                else
                                {
                                    echo"Not Category Available";
                                }
                                ?>
                                </select>
                            </div><br>
                            <input type="hidden" name="product_id" value="<?= $data['id']; ?>">
                            <div class="col-md-6">
                                <label for="">Name</label>
                                <input type="text" name="name" value="<?= $data['name']; ?>" placeholder="Enter Product Name"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Slug</label>
                                <input type="text" name="slug" value="<?= $data['slug']; ?>" placeholder="Enter Product Slug"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Description</label>
                                <textarea rows="3" name="description" placeholder="Enter Description"
                                    class="form-control mb-2"><?= $data['description']; ?></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Small Description</label>
                                <textarea rows="3" name="small_description" placeholder="Enter Small Description"
                                    class="form-control mb-2"><?= $data['small_description']; ?></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Original Price</label>
                                <input type="text" name="original_price" value="<?= $data['original_price']; ?>" placeholder="Enter Original Price"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-6">
                                <label class="mb-0">Selling Price</label>
                                <input type="text" name="selling_price" value="<?= $data['selling_price']; ?>" placeholder="Enter Selling Price"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-12">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" class="form-control">
                                        <img src="../uploads/<?= $data['image']; ?>" alt="Current Image" class="img-thumbnail mt-2"
                                            style="max-width: 150px; max-height: 150px;">
                                        <input type="hidden" name="existing_image" value="<?= $data['image']; ?>">
                                    </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="mb-0">Quantity</label>
                                    <input type="number" name="qty" value="<?= $data['qty']; ?>" placeholder="Enter Product Quantity"
                                        class="form-control mb-2">
                                </div><br>
                                <div class="col-md-3">
                                    <label class="mb-2">Status</label><br>
                                    <input type="checkbox" name="status" <?= $data['status'] ? 'checked' : ''; ?>>
                                </div><br>
                                <div class="col-md-3">
                                    <label class="mb-2">Trending</label><br>
                                    <input type="checkbox" name="trending" <?= $data['trending'] ? 'checked' : ''; ?>>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Title</label>
                                <input type="text" name="meta_title" value="<?= $data['meta_title']; ?>" placeholder="Enter Meta Title"
                                    class="form-control mb-2">
                            </div><br>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Description</label>
                                <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                    class="form-control mb-2"><?= $data['meta_description']; ?></textarea>
                            </div><br>
                            <div class="col-md-12">
                                <label class="mb-0">Meta Keywords</label>
                                <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords"
                                    class="form-control mb-2"><?= $data['meta_keywords']; ?></textarea>
                            </div><br>
                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary" name="update_product_btn">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <?php
                } else {
                    echo "Product ID not found!";
                }
            } else {
                echo "Something went wrong!";
            }
            ?>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>
