<?php

session_start();
include("config/dbconn.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function getAllActive($table){ 
    global $conn;
    $query = "SELECT * FROM categories WHERE status='1'";
    return $query_run = mysqli_query($conn,$query);
}
function getproductByCategory($category_id){
    global $conn;
    $query = "SELECT * FROM products WHERE category_id='$category_id' AND status='1'";
    return $query_run = mysqli_query($conn,$query);
}
function getByslugActive($table,$slug){
    global $conn;
    $query = "SELECT * FROM $table WHERE slug='$slug' AND status='1' LIMIT 1";
    return $query_run = mysqli_query($conn,$query);
}
function getByIDActive($table,$id){
    global $conn;
    $query = "SELECT * FROM $table WHERE id='$id' AND status='1'";
    return $query_run = mysqli_query($conn,$query);
}
function getCartItems() {
    global $conn;
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['auth_user']['user_id'])) {
        $userId = $_SESSION['auth_user']['user_id'];
        $query = "SELECT c.id as cart_id, c.prod_id, c.prod_qty, p.id as product_id, p.name, p.image, p.selling_price 
                  FROM carts c 
                  JOIN products p ON c.prod_id = p.id 
                  WHERE c.user_id = '$userId' 
                  ORDER BY c.id DESC";

        $query_run = mysqli_query($conn, $query);

        if ($query_run) {
            return $query_run;
        } else {
            // Handle query error
            echo "Error: " . mysqli_error($conn);
            return false;
        }
    } else {
        // Handle the case where the user is not authenticated
        echo "User is not authenticated.";
        return false;
    }
}
function redirect($url, $message)
{
    $_SESSION['message'] = $message;
    header("Location:" . $url);
    exit(0);
}
?>