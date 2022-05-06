<?php
    require '../../includes/connection.php';

    $token = $_GET['token'];
    $tokenName = $_GET['name'];

    $sql = "update tbl_confidential set block = 0 where id = '$token'";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        header('location: ../adminDashboard.php');
    }
?>