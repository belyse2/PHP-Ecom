<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/dbconn.php");
include("../functions/myfunctions.php");

session_start();

if (isset($_POST['add_category_btn'])) {
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $description = $_POST['description'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $meta_keywords = $_POST['meta_keywords'] ?? '';
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';

    // Check if image key exists and file was uploaded successfully
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $path = "../uploads";

        // Check if the uploads directory exists, if not create it
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                $_SESSION['message'] = "Failed to create uploads directory.";
                header("Location: add-category.php");
                exit(0);
            }
        }

        // Extract file extension
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);

        // Check if extension was extracted correctly
        if (!$image_ext) {
            $image_ext = 'jpg'; // default to jpg if extraction fails
        }

        $filename = time() . "." . $image_ext;

        // Perform database insertion
        $query = "INSERT INTO categories (name, slug, description, meta_title, meta_description, meta_keywords, status, popular, image) VALUES ('$name', '$slug', '$description', '$meta_title', '$meta_description', '$meta_keywords', '$status', '$popular', '$filename')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            // Move uploaded file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $filename)) {
                $_SESSION['message'] = "Category Added Successfully.";
                header("Location: add-category.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Failed to upload image.";
                header("Location: add-category.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Failed to add category. Something went wrong.";
            header("Location: add-category.php");
            exit(0);
        }
    } 
    else {
        $_SESSION['message'] = "Image file is missing or upload failed.";
        header("Location: add-category.php");
        exit(0);
    }
}
else if (isset($_POST['update_category_btn'])) {
    $id = $_POST['category_id'] ?? '';
    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $description = $_POST['description'] ?? '';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $meta_keywords = $_POST['meta_keywords'] ?? '';
    $status = isset($_POST['status']) ? '1' : '0';
    $popular = isset($_POST['popular']) ? '1' : '0';
    $filename = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $path = "../uploads";

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                $_SESSION['message'] = "Failed to create uploads directory.";
                header("Location: edit-category.php?id=$id");
                exit(0);
            }
        }

        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        if (!$image_ext) {
            $image_ext = 'jpg';
        }

        $filename = time() . "." . $image_ext;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $filename)) {
            $_SESSION['message'] = "Failed to upload image.";
            header("Location: edit-category.php?id=$id");
            exit(0);
        }
    } else {
        $filename = $_POST['existing_image'] ?? '';
    }

    $query = "UPDATE categories SET name='$name', slug='$slug', description='$description', meta_title='$meta_title', meta_description='$meta_description', meta_keywords='$meta_keywords', status='$status', popular='$popular', image='$filename' WHERE id='$id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Category Updated Successfully.";
        header("Location: edit_category.php?id=$id");
        // header("Location: categories.php");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to update category. Something went wrong.";
        header("Location: edit_category.php?id=$id");
        exit(0);
    }
}
// elseif (isset($_POST['delete_category_btn'])) {
//     $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

//     // Fetch the image path
//     $query = "SELECT image FROM categories WHERE id = $category_id";
//     $query_run = mysqli_query($conn, $query);
//     $category = mysqli_fetch_assoc($query_run);

//     if ($category) {
//         $image_path = '../uploads/' . $category['image'];

//         // Delete the image file
//         if (file_exists($image_path)) {
//             unlink($image_path);
//         }

//         // Delete the category
//         $delete_query = "DELETE FROM categories WHERE id = $category_id";
//         $delete_query_run = mysqli_query($conn, $delete_query);

//         if ($delete_query_run) {
//             $_SESSION['message'] = "Category Deleted Successfully.";
//             header("Location: categories.php");
//             exit(0);
//         } else {
//             $_SESSION['message'] = "Something Went Wrong.";
//             header("Location: categories.php");
//             exit(0);
//         }
//     } else {
//         $_SESSION['message'] = "Category Not Found.";
//         header("Location: categories.php");
//         exit(0);}
// }

elseif (isset($_POST['delete_category_btn'])) {
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    // Fetch the image path
    $query = "SELECT image FROM categories WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $category_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $category = $result->fetch_assoc();
    $stmt->close();

    if ($category) {
        $image_path = '../uploads/' . $category['image'];

        // Delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the category
        $delete_query = "DELETE FROM categories WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $category_id);
        $delete_query_run = $stmt->execute();
        $stmt->close();

        if ($delete_query_run) {
            echo 200;
        } else {
            echo 500;
        }
    } else {
        echo 404; // Category not found
    }
    exit(0); // Ensure no further output is sent
}
// Products 
elseif(isset($_POST['add_products_btn']))
{
    $category_id = $_POST['category_id']; 

    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $original_price = $_POST['original_price'] ?? '';
    $selling_price = $_POST['selling_price'] ?? '';
    $description = $_POST['description'] ?? '';
    $small_description = $_POST['small_description'] ?? '';
    $qty = $_POST['qty'] ?? '';
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $meta_keywords = $_POST['meta_keywords'] ?? '';
    
    // Check if image key exists and file was uploaded successfully
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {

        $image = $_FILES['image']['name'];
        $path = "../uploads";

        // Check if the uploads directory exists, if not create it
        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                $_SESSION['message'] = "Failed to create uploads directory.";
                header("Location: add-products.php");
                exit(0);
            }
        }

        // Extract file extension
        $image_ext = pathinfo($image, PATHINFO_EXTENSION);

        // Check if extension was extracted correctly
        if (!$image_ext) {
            $image_ext = 'jpg'; // default to jpg if extraction fails
        }

        $filename = time() . "." . $image_ext;

        $query = "INSERT INTO products (category_id,name, slug,small_description,description,original_price,selling_price,qty, meta_title, meta_description, meta_keywords, status, trending, image) VALUES ('$category_id','$name', '$slug', '$description','$small_description','$original_price','$selling_price','$qty','$meta_title', '$meta_description', '$meta_keywords', '$status', '$trending', '$filename')";
        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            // Move uploaded file
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $filename)) {
                $_SESSION['message'] = "Product Added Successfully.";
                header("Location: add-products.php");
                exit(0);
            } else {
                $_SESSION['message'] = "Failed to upload image.";
                header("Location: add-products.php");
                exit(0);
            }
        } else {
            $_SESSION['message'] = "Failed to add Product. Something went wrong.";
            header("Location: add-products.php");
            exit(0);
        }
    }
    else{
        $_SESSION['message'] = "Image file is missing or upload failed.";
        header("Location: add-products.php");
        exit(0);
    }
}
else if (isset($_POST['update_product_btn'])) {
    $product_id = $_POST['product_id'];
    $category_id = $_POST['category_id'];

    $name = $_POST['name'] ?? '';
    $slug = $_POST['slug'] ?? '';
    $original_price = $_POST['original_price'] ?? '';
    $selling_price = $_POST['selling_price'] ?? '';
    $description = $_POST['description'] ?? '';
    $small_description = $_POST['small_description'] ?? '';
    $qty = $_POST['qty'] ?? '';
    $status = isset($_POST['status']) ? '1' : '0';
    $trending = isset($_POST['trending']) ? '1' : '0';
    $meta_title = $_POST['meta_title'] ?? '';
    $meta_description = $_POST['meta_description'] ?? '';
    $meta_keywords = $_POST['meta_keywords'] ?? '';

    $filename = $_POST['existing_image'] ?? '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image']['name'];
        $path = "../uploads";

        if (!is_dir($path)) {
            if (!mkdir($path, 0777, true)) {
                $_SESSION['message'] = "Failed to create uploads directory.";
                header("Location: edit-products.php?id=$product_id");
                exit(0);
            }
        }

        $image_ext = pathinfo($image, PATHINFO_EXTENSION);
        if (!$image_ext) {
            $image_ext = 'jpg';
        }

        $filename = time() . "." . $image_ext;

        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $path . '/' . $filename)) {
            $_SESSION['message'] = "Failed to upload image.";
            header("Location: edit-products.php?id=$product_id");
            exit(0);
        }
    }

    $query = "UPDATE products SET category_id='$category_id', name='$name', slug='$slug', original_price='$original_price', selling_price='$selling_price', description='$description', small_description='$small_description', qty='$qty', status='$status', trending='$trending', meta_title='$meta_title', meta_description='$meta_description', meta_keywords='$meta_keywords', image='$filename' WHERE id='$product_id'";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $_SESSION['message'] = "Product Updated Successfully.";
        header("Location: edit_products.php?id=$product_id");
        exit(0);
    } else {
        $_SESSION['message'] = "Failed to update Product. Something went wrong.";
        header("Location: edit_products.php?id=$product_id");
        exit(0);
    }
}
else if (isset($_POST['delete_products_btn'])) {

    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);

    // Fetch the image path
    $query = "SELECT image FROM products WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product) {
        $image_path = '../uploads/' . $product['image'];

        // Delete the image file
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Delete the product
        $delete_query = "DELETE FROM products WHERE id = ?";
        $stmt = $conn->prepare($delete_query);
        $stmt->bind_param("i", $product_id);
        $delete_query_run = $stmt->execute();
        $stmt->close();

        if ($delete_query_run) {
            echo 200;
        } else {
            echo 500;
        }
    } else {
        echo 404; // Product not found
    }
    exit(0);
}
else{
    header("Location: ../index.php");
}
?>