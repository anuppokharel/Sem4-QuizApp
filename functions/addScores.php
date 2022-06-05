<?php
    require '../includes/session.php';
    require '../includes/connection.php';

    $id = $_SESSION['id'];
    $score = $_POST['score'];
    $todayDate = date('Y-m-d');
    $questionsLength = $_POST['questionsLength'];
    $average = ((round(( $score / $questionsLength ) * 10)) / 10) * $questionsLength;

    try {
        $sql = "select * from tbl_scores where user_id = $id";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) == 1) {
            $profileData = mysqli_fetch_assoc($query);
            $scoreDate = $profileData['score_created_date'];
            $oldScore = $profileData['today_top_score'];
            $oldAverageToday = $profileData['today_average_score'];
            $oldAverageTotal = $profileData['total_average_score'];
            $averageScoreToday = (($oldAverageToday + floor(( $score / $questionsLength ) * 10)) / 10) * $questionsLength;
            $averageScoreTotal = (($oldAverageTotal + floor(( $score / $questionsLength ) * 10)) / 10) * $questionsLength;

            if ($todayDate == $scoreDate) {
                if ($score > $oldScore) {
                    $sql = "update tbl_scores set today_top_score = $score, total_top_score = $score, today_average_score = $averageScoreToday, total_average_score = $averageScoreTotal where user_id = $id";

                    $query = mysqli_query($connection, $sql);
                } else {
                    $sql = "update tbl_scores set today_average_score = $averageScoreToday, total_average_score = $averageScoreToday where user_id = $id";

                    $query = mysqli_query($connection, $sql);
                }
            } else {
                if ($score > $oldScore) {
                    $sql = "update tbl_scores set total_top_score = $score, total_average_score = $averageScoreTotal where user_id = $id";

                    $query = mysqli_query($connection, $sql);
                } else {
                    $sql = "update tbl_scores set total_average_score = $averageScoreTotal where user_id = $id";

                    $query = mysqli_query($connection, $sql);
                }
            }
            
        } else {
            try {
                $sql = "insert into tbl_scores(today_top_score, total_top_score, user_id, today_average_score, total_average_score) values('$score', '$score', '$id', '$average', '$average')";

                $query = mysqli_query($connection, $sql);

            } catch(Exception $e) {
                die($e -> getMessage());
            }
        }
        
    } catch(Exception $e) {
        die($e -> getMessage());
    }

    
?>