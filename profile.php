<?php
    require_once 'includes/session.php';
    require 'includes/connection.php';

    $id = $_SESSION['id'];

    try {
        $sql = "select * from tbl_scores where user_id = $id";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query)) {
            $profileData = mysqli_fetch_assoc($query);
        }
        
    } catch(Exception $e) {
        die($e -> getMessage());
    }

    if (isset($_FILES['image'])) {
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            if ($_FILES['image']['size'] < 5120000) {
                $file_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['image']['type'], $file_types)) {
                    $name = uniqid() . '_' . $_FILES['image']['name'];
                    if (move_uploaded_file($_FILES['image']['tmp_name'], 'images/profile-img/' . $name)) {
                        $sql = "update tbl_confidential set profile_img = '$name' where tbl_confidential.id = $id";
                        $query = mysqli_query($connection, $sql);
                        if ($query) {
                            echo '<script language="javascript">';
                            echo 'alert("Profile picture changed successfully")';
                            echo '</script>';

                            try {
                                $sql = "select * from tbl_confidential where id = $id";
                        
                                $query = mysqli_query($connection, $sql);
                        
                                if (mysqli_num_rows($query) == 1) {
                                    $userdata = mysqli_fetch_assoc($query);

                                    $_SESSION['image'] = $userdata['profile_img'];
                                }
                        
                            } catch (Exception $e) {
                                die($e -> getMessage());
                            }
                        }
                    } else {
                        die('Upload unsuccessful');
                    }
                } else {
                    die('Image type different');
                }
            } else {
                die('Image size large');
            }
        } else {
            die('Image error');
        }
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
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="changeProfilePictureForm">
                            <div id="changeProfilePictureDiv">
                                <label for="changeProfilePicture">Change your profile picture</label><br>
                                <input type="file" name="image" id="changeProfilePicture">
                            </div>
                        </form>
                    </div>
                    <div class="statistics">
                        <div class="statistics-inner today">
                            <h4 class="statistics-subheader">
                                Today Statistics
                            </h4>
                            <div class="info-container today">
                                <div class="score total">
                                    <p>Top Score</p>
                                    <span><?php if (isset($profileData['today_top_score'])) { echo $profileData['today_top_score']; } else {
                                        echo 0;
                                    } ?></span>
                                </div>
                                <div class="score average">
                                    <p>Average Score</p>
                                    <span><?php if (isset($profileData['today_average_score'])) { echo $profileData['today_average_score']; } else {
                                        echo 0;
                                    } ?></span>
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
                                    <span><?php if (isset($profileData['total_top_score'])) { echo $profileData['total_top_score']; } else {
                                        echo 0;
                                    } ?></span>
                                </div>
                                <div class="score average">
                                    <p>Average Score</p>
                                    <span><?php if (isset($profileData['total_average_score'])) { echo $profileData['total_average_score']; } else {
                                        echo 0;
                                    } ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="delete">
                        <a href="includes/delete.php?token=<?php echo $id; ?>" onclick="return confirm('Are you sure you want to delete your data? It cannot be undone once you press \'Yes\'')"><button type="submit">Delete</button></a>
                        <div class="deleteMsg">
                            <?php
                                if (isset($_GET['msg']) && $_GET['msg'] == 1) { echo '<p class="success">You have deleted your progress successfully.</p>'; }
                                if (isset($_GET['msg']) && $_GET['msg'] == 2) { echo '<p class="error">You have no progress to be deleted.</p>'; }
                            ?>
                        </div>
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


