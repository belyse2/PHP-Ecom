<?php
include ('../functions/myfunctions.php');

if (isset($_SESSION['auth'])) {

    if ($_SESSION['role_as'] != 1) {

        redirect("../index.php", "You are not Authorized to access this Page");
        exit(0);
    }

} else {

    redirect("../login.php", "Login to Continue please");
    exit(0);
}


?>