<?php
    require '../includes/connection.php';

    $token = $_GET['token'];
    $type = $_GET['type'];

    $sql = "update tbl_confidential set block = 1 where id = '$token'";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        if ($type == 'user') {
            echo '<script language="javascript">';
            echo 'alert("User unblocked successfully")';
            echo '</script>';
        } else if ($type == 'admin') {
            echo '<script language="javascript">';
            echo 'alert("Admin unblocked successfully")';
            echo '</script>';
        }
    }
    
    if ($type == 'user') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=1');
    } else if ($type == 'admin') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=2');
    }
?>