<?php
    require '../includes/connection.php';

    if (isset($_POST['username'])) {
        $username = $_POST['username'];

        $sqlUsername = "select username from tbl_confidential where username = '$username'";

        $queryUsername = mysqli_query($connection, $sqlUsername);

        if (mysqli_num_rows($queryUsername) == 1) {
            echo 'Username already taken';
        } else {
            echo 'Username available';
        }
    }
    
    if (isset($_POST['email'])) {

        $email = $_POST['email'];

        $sqlEmail = "select email from tbl_confidential where email = '$email'";
        
        $queryEmail = mysqli_query($connection, $sqlEmail);
        
        if (mysqli_num_rows($queryEmail) == 1) {
            echo 'Email already registered';
        } else {
            echo 'Email available';
        }
    }
?>