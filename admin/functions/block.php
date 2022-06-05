<?php
    require '../includes/sessionAdmin.php';

    $token = $_GET['token'];
    $type = $_GET['type'];
    $id = $_SESSION['id'];

    if ($type == 'user') {
        $sql = "update tbl_confidential set block = 0 where id = '$token'";
    } else if ($type == 'admin') {
        if ($token === $id) {
            try {
                $sql = "select * from tbl_confidential where status = 1 and id = '$token'";
        
                $query = mysqli_query($connection, $sql);
        
                if (mysqli_num_rows($query) === 1) {
                    header('location: ../adminDashboard.php?msg=2');
                    exit();
                }
        
            } catch (Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        } else {
            $sql = "update tbl_confidential set block = 0 where id = '$token'";
        }
    }

    $query = mysqli_query($connection, $sql);

    if ($query) {
        if ($type == 'user') {
            echo '<script language="javascript">';
            echo 'alert("User blocked successfully")';
            echo '</script>';
        } else if ($type == 'admin') {
            echo '<script language="javascript">';
            echo 'alert("Admin blocked successfully")';
            echo '</script>';
        }
    }

    if ($type == 'user') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=1');
    } else if ($type == 'admin') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=2');
    }
?>