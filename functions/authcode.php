<?php include ('../config/dbconn.php'); ?>
<?php
SESSION_start();
include ('../functions/myfunctions.php');

if (isset($_POST['register_btn'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if ($password == $cpassword) {
        // Check if email already exists
        $check_email_query = "SELECT email FROM users WHERE email='$email'";
        $check_email_query_run = mysqli_query($conn, $check_email_query);

        if (mysqli_num_rows($check_email_query_run) > 0) {
            $_SESSION['message'] = "Email already registered";
            header("Location: ../Register.php");
            exit(0); // Ensure the script stops executing after redirection
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into the database table
            $insert_query = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$hashed_password')";
            $insert_query_run = mysqli_query($conn, $insert_query);

            if ($insert_query_run) {
                $_SESSION['message'] = "Registered successfully";
                header("Location: ../login.php");
                exit(0); // Ensure the script stops executing after redirection
            } else {
                $_SESSION['message'] = "Something went wrong: " . mysqli_error($conn);
                header("Location: ../Register.php");
                exit(0); // Ensure the script stops executing after redirection
            }
        }
    } else {
        $_SESSION['message'] = "Password did not match";
        header("Location: ../Register.php");
        exit(0); // Ensure the script stops executing after redirection
    }
} elseif (isset($_POST['login_btn'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);


    // Fetch user by email
    $login_query = "SELECT * FROM users WHERE email = '$email'";
    $login_result = mysqli_query($conn, $login_query);

    if ($login_result) {
        if (mysqli_num_rows($login_result) > 0) {
            $user = mysqli_fetch_assoc($login_result);

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['auth'] = true;
                $_SESSION['auth_user'] = [
                    'user_id' =>$user['id'],
                    'name' => $user['name'],
                    'email' => $user['email']
                ];

                $_SESSION['role_as'] = $user['role_as'];

                if ($user['role_as'] == 1) {

                    redirect(" ../Admin/index.php", "Welcome to Admin Dashboard");
                    exit(0);
                } else {
                    redirect("../index.php", "Login successful");
                    exit(0);
                }

            } else {
                redirect("../login.php", "Wrong credentials");
                exit(0);
            }
        } else {
            redirect("../login.php", "Wrong credentials");
            exit(0);
        }
    } else {
        redirect("../login.php", "Query failed");
        exit(0);
    }
}
?>