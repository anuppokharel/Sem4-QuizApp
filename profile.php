<?php
    require 'includes/session.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/styles.css">
    <title>Profile</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header">
            Profile
        </h3>
        <div class="mainCard">
            <div class="card-wrapper">
                <div class="container profile">
                    <div class="profile-info-wrapper">
                        <img src="images/profile-img/<?php echo $_SESSION['image']; ?>" alt="" style="height: 250px; width: 250px;">
                        <b><h3><?php echo $_SESSION['name']; ?></h3></b>
                    </div>
                    <div class="statistics">
                        <div class="statistics-inner today">
                            <h4 class="statistics-subheader">
                                Today Statistics
                            </h4>
                            <div class="info-container today">
                                <div class="score total">
                                    <p>Top Score</p>
                                    <span>19</span>
                                </div>
                                <div class="score average">
                                    <p>Average Score</p>
                                    <span>12</span>
                                </div>
                            </div>
                        </div>
                        <div class="statistics-inner total">
                            <h4 class="statistics-subheader">
                                Total Statistics
                            </h4>
                            <div class="info-container total">
                                <div class="score total">
                                    <p>Top Score</p>
                                    <span>19</span>
                                </div>
                                <div class="score average">
                                    <p>Average Score</p>
                                    <span>19</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="share" style="margin: 15px 0">
                        <label for="">Share your profile:</label>
                        <input type="text" style="margin: 5px 0; padding: 3px; font-size: 16px; width: 50%;">
                        <div class="action">
                            <button type="submit">Copy</button>
                            <button type="submit">Visit</button>
                        </div>
                    </div>
                    <div class="delete">
                        <button type="submit">Delete</button>
                    </div>
                </div>
            </div>
        </div>
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