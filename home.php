<?php
    session_start();

    require 'includes/admin.php';
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
            Recently quizzes
        </h3>
        <div class="card-wrapper">
            <div class="card quiz">
                <a href="" style="color: #000">
                    <img src="images/blog-img/demo.jpg" alt="" id="blogImg">
                    <div class="question-header">
                        <h3>What is the net worth of Elon Musk?</h3>
                    </div>
                    <div class="question-footer">
                        <span>1999-06-21</span>
                        <p>Category</p>
                    </div>
                </a>
            </div>
        </div>
        <!-- <div class="body-footer quiz">
            <button>Load more</button>
        </div> -->
        <h3 class="body-header topics">
            Popular topics
        </h3>
        <div class="card-wrapper">
            <div class="card topics">
                <img src="images/topic-img/demo.jpg" alt="" id="topicImg">
                <h4>Bank</h4>
            </div>
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