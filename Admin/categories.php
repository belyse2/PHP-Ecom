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
                    <h4>All Categories</h4>
                </div>
                <div class="card-body" id="category_table">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Descriptions</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </thead>
                        <tbody>
                            <?php
                            $category = getAll("categories");
                            if (mysqli_num_rows($category) > 0) {
                                foreach ($category as $item) {
                                    ?>
                            <tr>
                                <td><?= $item['id']; ?></td>
                                <td><?= $item['name']; ?></td>
                                <td><?= $item['description']; ?></td>
                                <td><img src="../uploads/<?= $item['image']; ?>" width="50px" ;height="50px" ;
                                        alt="<?= $item['name']; ?>">
                                </td>
                                <td><?= $item['status'] == '0' ? "Visible" : "Hidden" ?></td>
                                <td><a href="edit_category.php?id=<?= $item['id']; ?>" class="btn btn-sm btn-primary">Edit</a>
                                    <form action="code.php" method="POST">
                                        <!-- <input type="hidden" name="category_id" value="<?= $item['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            name="delete_category_btn">Delete</button>
                                                 
                                    </form> -->
                                </td>
                                <td>
                                <button type="button" class="btn btn-sm btn-danger delete_category_btn"
                                value="<?=$item['id']; ?>">Delete</button>
                                </td>
                            </tr>
                            <?php
                                }

                            } else {
                                echo "No records Founds";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include ('includes/footer.php'); ?>