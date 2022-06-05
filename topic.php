<?php
    session_start();

    require 'includes/admin.php';
    require 'includes/function.php';
    require 'includes/connection.php';

    $questions = [];
    $token = $_GET['id'];

    try {
        $sql = "select tbl_questions.*, tbl_topics.topic_name from tbl_questions join tbl_topics on tbl_questions.topic_id = tbl_topics.id where tbl_topics.id = $token";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($question = mysqli_fetch_assoc($query)) {
                array_push($questions, $question);
            }
        }
    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css">
    <title>Home</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header quiz">
            <?php foreach($questions as $question) { ?>
                <?php echo $question['topic_name']; ?>
            <?php } ?>
        </h3>
        <div class="card-wrapper">
            <?php foreach($questions as $question) { ?>
                <div class="card quiz">
                    <a href="question.php?id=<?php echo $question['id']; ?>" style="color: #000">
                        <img src="images/blog-img/<?php echo $question['question_image']; ?>" alt="" id="blogImg">
                        <div class="question-header">
                            <h3><?php echo $question['question']; ?></h3>
                        </div>
                        <div class="question-footer">
                            <span id="timeField"><?php echo getShortTime($question['created_at']); ?></span>
                            <p id="categoryField"><?php echo $question['topic_name']; ?></p>
                        </div>
                    </a>
                </div>
            <?php } ?>
        </div>
        <!-- <div class="body-footer quiz">
            <button>Load more</button>
        </div> -->
    </div>
    <div class="footer">
        <?php require 'includes/footer.php'; ?>
    </div>

    <!-- jQuery and JavaScript -->

    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts/scripts.js"></script>
</body>
</html>