<?php
    require '../includes/sessionAdmin.php';

    $token = $_GET['token'];
    $type = $_GET['type'];
    $id = $_SESSION['id'];

    if ($type == 'user') {
        $sql = "delete from tbl_confidential where id = '$token'";
    } else if ($type == 'admin') {
        if ($token === $id) {
            try {
                $sql = "select * from tbl_confidential where status = 1 and id = '$token'";
        
                $query = mysqli_query($connection, $sql);
        
                if (mysqli_num_rows($query) === 1) {
                    header('location: ../adminDashboard.php?msg=1');
                    exit();
                }
        
            } catch (Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        } else {
            $sql = "delete from tbl_confidential where id = '$token'";
        }
    } else if ($type == 'topic') {
        $sql = "delete from tbl_topics where id = '$token'";
    } else if ($type == 'question') {
        $sql = "delete from tbl_questions where id = '$token'";
    } else if ($type == 'contact') {
        $sql = "delete from tbl_contacts where id = '$token'";
    }

    $query = mysqli_query($connection, $sql);

    if ($query) {
        if ($type == 'user') {
            echo '<script language="javascript">';
            echo 'alert("User deleted successfully")';
            echo '</script>';
        } else if ($type == 'admin') {
            echo '<script language="javascript">';
            echo 'alert("Admin deleted successfully")';
            echo '</script>';
        } else if ($type == 'topic') {
            echo '<script language="javascript">';
            echo 'alert("Topic deleted successfully")';
            echo '</script>';
        } else if ($type == 'question') {
            echo '<script language="javascript">';
            echo 'alert("Question deleted successfully")';
            echo '</script>';
        } else if ($type == 'contact') {
            echo '<script language="javascript">';
            echo 'alert("Contact deleted successfully")';
            echo '</script>';
        }
    }
    
    if ($type == 'user') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=1');
    } else if ($type == 'admin') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=2');
    } else if ($type == 'topic') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=3');
    } else if ($type == 'question') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=4');
    } else if ($type == 'contact') {
        header('Refresh: 0; url=../adminDashboard.php?redirect=8');
    }
?>