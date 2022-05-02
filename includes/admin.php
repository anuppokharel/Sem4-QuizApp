<?php
    if (isset($_SESSION['token']) && $_SESSION['token'] == 1) {
        header("location: admin/adminDashboard.php");
    }
?>