<?php
    session_start();

    require 'connection.php';

    if (isset($_SESSION['username'])) {
        $username = $_SESSION['username'];

        try {
            $sql = "select * from tbl_confidential where username = '$username' and status = 1";

            $query = mysqli_query($connection, $sql);

            if (mysqli_num_rows($query) == 1) {
                $data = mysqli_fetch_assoc($query);

                $newUsername = $data['username'];

                if (!($username == $newUsername)) {
                    header("location: ../login.php?msg=5");
                }
            } else {
                header("location: ../login.php?msg=5");
            }
        } catch (Exception $e) {
            $error['database'] = $e -> getMessage();
        }

    } else {
        header("location: ../login.php?msg=5");
    }
?>