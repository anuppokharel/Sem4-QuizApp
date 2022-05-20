<?php
    require '../../includes/connection.php';

    $token = $_GET['token'];

    $sql = "delete from tbl_confidential where id = '$token'";

    $query = mysqli_query($connection, $sql);

    if ($query) {
        echo '<script language="javascript">';
        echo 'alert("Successfully deleted admin")';
        echo '</script>';
    }
    
    header('location: ../adminDashboard.php');
?>