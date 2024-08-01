<?php 

session_start();
include('../config/dbconn.php');

if(isset($_SESSION['auth'])) {
    if(isset($_POST['scope'])) {
        $scope = $_POST['scope'];
        switch($scope) {
            case "add":
                $prod_id = $_POST['prod_id'];
                $prod_qty = $_POST['prod_qty'];

                $user_id = $_SESSION['auth_user']['user_id'];

                // Check if the product is already in the cart
                $check_cart_query = "SELECT * FROM carts WHERE user_id='$user_id' AND prod_id='$prod_id'";
                $check_cart_run = mysqli_query($conn, $check_cart_query);

                if(mysqli_num_rows($check_cart_run) > 0) {
                    // Product already in the cart
                    echo json_encode(['status' => 203, 'message' => 'Product already in cart']);
                } else {
                    // Product not in the cart, insert new entry
                    $insert_query = "INSERT INTO carts (user_id, prod_id, prod_qty) VALUES ('$user_id', '$prod_id', '$prod_qty')";
                    $query_run = mysqli_query($conn, $insert_query);

                    if($query_run) {
                        echo json_encode(['status' => 201, 'message' => 'Product added to cart successfully']); // Inserted successfully
                    } else {
                        echo json_encode(['status' => 500, 'message' => 'Failed to add product to cart']); // Insert failed
                    }
                }
                break;
            default:
                echo json_encode(['status' => 500, 'message' => 'Invalid request']); // Invalid scope
        }
    }
} else {
    echo json_encode(['status' => 401, 'message' => 'Please log in to continue']); // Not authenticated
}

?>
