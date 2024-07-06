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
                $category = getByID('categories', $id);
                if (mysqli_num_rows($category) > 0) {
                    $data = mysqli_fetch_array($category);
                    ?>
                    <div class="card">
                        <div class="card-header">
                            <h4>Edit Category</h4>
                        </div>
                        <div class="card-body">
                            <form action="code.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="category_id" value="<?= $id; ?>">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="name">Name</label>
                                        <input type="text" name="name" value="<?= $data['name']; ?>"
                                            placeholder="Enter Category Name" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="slug">Slug</label>
                                        <input type="text" name="slug" value="<?= $data['slug']; ?>"
                                            placeholder="Enter Category Slug" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="description">Description</label>
                                        <textarea rows="3" name="description" placeholder="Enter Description"
                                            class="form-control"><?= $data['description']; ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="image">Upload Image</label>
                                        <input type="file" name="image" class="form-control">
                                        <img src="../uploads/<?= $data['image']; ?>" alt="Current Image" class="img-thumbnail mt-2"
                                            style="max-width: 150px; max-height: 150px;">
                                        <input type="hidden" name="existing_image" value="<?= $data['image']; ?>">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_title">Meta Title</label>
                                        <input type="text" name="meta_title" value="<?= $data['meta_title']; ?>"
                                            placeholder="Enter Meta Title" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_description">Meta Description</label>
                                        <textarea rows="3" name="meta_description" placeholder="Enter Meta Description"
                                            class="form-control"><?= $data['meta_description']; ?></textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label for="meta_keywords">Meta Keywords</label>
                                        <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords"
                                            class="form-control"><?= $data['meta_keywords']; ?></textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="status">Status</label>
                                        <input type="checkbox" name="status" <?= $data['status'] ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="popular">Popular</label>
                                        <input type="checkbox" name="popular" <?= $data['popular'] ? 'checked' : ''; ?>>
                                    </div>
                                    <div class="col-md-6 mt-3">
                                        <button type="submit" class="btn btn-primary" name="update_category_btn">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <?php
                } else {
                    echo "Category ID not found!";
                }
            } else {
                echo "Something went wrong!";
            }
            ?>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>