<?php
    require '../includes/connection.php';

    $questions = [];
    $token = $_POST['token'];

    try {
        if (isset($_POST['token']) && $_POST['token'] == 999) {
            $sql = "select tbl_questions.*, tbl_topics.topic_name from tbl_questions join tbl_topics on tbl_questions.topic_id = tbl_topics.id";
        } else {
            $sql = "select tbl_questions.*, tbl_topics.topic_name from tbl_questions join tbl_topics on tbl_questions.topic_id = tbl_topics.id where tbl_questions.id = $token";
        }

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($question = mysqli_fetch_assoc($query)) {
                array_push($questions, $question);
            }
            echo json_encode($questions);
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

?>