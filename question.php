<?php
    require 'includes/session.php';
    require 'includes/function.php';
    require 'includes/connection.php';

    $noOfTime = [];
    $token = $_GET['id'];

    try {
        $sql = "select * from tbl_questions where id = $token";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($data = mysqli_fetch_assoc($query)) {
                array_push($noOfTime, $data);
            }
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }
    
    echo '<script language="javascript">';
    echo 'let token =' . $token;
    echo '</script>';
    
    echo '<script language="javascript">';
    echo 'let noOfTime = ' . count($noOfTime);
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
                <img src="images/blog-img/" alt="" style="height: 200px; width: 450px; object-fit: cover;" id="blogImg">
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
                                <label for="firstOption" id="a_label">first option</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="secondOption" class="answer">
                                <label for="secondOption" id="b_label">second option</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="thirdOption" class="answer">
                                <label for="thirdOption" id="c_label">third option</label>
                            </li>
                            <li>
                                <input type="radio" name="answer" id="fourthOption" class="answer">
                                <label for="fourthOption" id="d_label">fourth option</label>
                            </li>
                        </ul>
                    </div>
                    <div class="nextBtn">
                        <button type="submit" id="quizSubmit">Submit</button>
                    </div>
                </div>
                <div class="question-footer"></div>
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