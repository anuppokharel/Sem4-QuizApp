<?php
    require 'session.php';
    require 'connection.php';

    $id = $_GET['token'];

    try {
        $sql = "select * from tbl_scores where user_id = $id";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) == 1) {
            try {
                $sql = "delete from tbl_scores where user_id = $id";
        
                $query = mysqli_query($connection, $sql);
        
                if($query) {
                    header("location: ../profile.php?msg=1");
                }
            } catch(Exception $e) {
                die($e -> getMessage());
            }
        } else {
            header("location: ../profile.php?msg=2");
        }
    } catch(Exception $e) {
        die($e -> getMessage());
    }

    
    ?>