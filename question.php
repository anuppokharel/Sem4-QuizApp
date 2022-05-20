<?php
    require 'includes/session.php';
    require 'includes/function.php';
    require 'includes/connection.php';

    $token = $_GET['id'];
    $error = [];

    try {
        $sql = "select tbl_questions.*, tbl_topics.topic_name from tbl_questions join tbl_topics on tbl_questions.topic_id = tbl_topics.id where tbl_questions.id = $token";

        $query = mysqli_query($connection, $sql);

        $question = mysqli_fetch_assoc($query);
    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }
    
    echo '<script language="javascript">';
    echo 'let token =' . $token;
    echo '</script>';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css" />
    <title>Document</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <div class="card-wrappeer">
            <div class="mainCard">
                <img src="images/blog-img/<?php echo $question['question_image']; ?>" alt="" style="height: 200px; width: 450px; object-fit: cover;">
                <div class="question-header">
                    <h2>Question</h2>
                </div>
                <div class="question-body">
                    <div class="attempt-list">
                        <p><span>1</span>out of<span>5</span>question.&nbsp;</p>
                    </div>
                    <div class="options">
                        <ul>
                            <li>
                                <input type="radio" name="answer" id="firstOption" class="answer">
                                <label for="firstOption" id="a_label">500 billion</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="secondOption" class="answer">
                                <label for="secondOption" id="b_label">200 billion</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="thirdOption" class="answer">
                                <label for="thirdOption" id="c_label">300 billion</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="fourthOption" class="answer">
                                <label for="fourthOption" id="d_label">150 billion</label>
                            </li>
                        </ul>
                    </div>
                    <div class="nextBtn">
                        <button type="submit" id="quizSubmit">Next Question</button>
                    </div>
                </div>
                <div class="question-footer">
                    <span id="timeField"><?php echo getPostedTime($question['created_at']); ?></span>
                    <p id="categoryField"><?php echo $question['topic_name']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php require 'includes/footer.php'; ?>
    </div>

    <!-- jQuery & JS  -->

    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts/scripts.js"></script>
</body>
</html>