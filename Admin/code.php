<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

include("../config/dbconn.php");
include("../functions/myfunctions.php");

session_start(); // Ensure session is started

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
?>
