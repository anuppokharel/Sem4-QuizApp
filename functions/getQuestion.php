<?php
    require '../includes/connection.php';

    $token = $_POST['token'];
    $questions = [];

    try {
        $sql = "select * from tbl_questions where id = $token";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) == 1) {
            $question = mysqli_fetch_assoc($query);
            echo json_encode($question);
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

?>