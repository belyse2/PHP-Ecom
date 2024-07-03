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
                    <h4> Add Category</h4>
                </div>
                <div class="card-body">
                    <form action="code.php" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="">Name</label>
                            <input type="text" name="name" placeholder="Enter Category Name" class="form-control">
                        </div><br>
                        <div class="col-md-6">
                            <label for="">Slug</label>
                            <input type="text" name="slug" placeholder="Enter Category Slug" class="form-control">
                        </div><br>
                        <div class="col-md-12">
                            <label for="">Decsription</label>
                            <textarea rows="3" name="description" placeholder="Enter Description" class="form-control"></textarea>
                        </div><br>
                        <div class="col-md-12">
                            <label for="">Upload Image</label>
                            <input type="file" name="image" class="form-control" required>
                        </div><br>
                        <div class="col-md-12">
                            <label for="">Meta Title</label>
                            <input type="text" name="meta_title" placeholder="Enter Meta Title" class="form-control">
                        </div><br>
                        <div class="col-md-12">
                            <label for="">Meta Decription</label>
                            <textarea rows="3" name="meta_description" placeholder="Enter Meta Description" class="form-control"></textarea>
                        </div><br>
                        <div class="col-md-12">
                            <label for="">Meta Keywords</label>
                            <textarea rows="3" name="meta_keywords" placeholder="Enter Meta Keywords" class="form-control"></textarea>
                        </div><br>
                        <div class="col-md-6">
                            <label for="">Status</label>
                            <input type="checkbox" name="status">
                        </div><br>
                        <div class="col-md-6">
                            <label for="">Popular</label>
                            <input type="checkbox" name="popular">
                        </div>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary" name="add_category_btn">Save</button>
                        </div>
                    </div>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>