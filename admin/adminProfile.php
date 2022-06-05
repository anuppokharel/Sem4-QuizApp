<?php
    require_once 'includes/sessionAdmin.php';

    $id = $_SESSION['id'];

    if (isset($_FILES['image'])) {
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            if ($_FILES['image']['size'] < 5120000) {
                $file_types = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['image']['type'], $file_types)) {
                    $name = uniqid() . '_' . $_FILES['image']['name'];
                    if (move_uploaded_file($_FILES['image']['tmp_name'], '../images/profile-img/' . $name)) {
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
    <link rel="stylesheet" href="../styles/styles.css"/>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/headerAdmin.php'; ?>
    </div>
    <div class="admin-body">
        <div class="container-profile">
            <div class="admin-profile">
                <img src="../images/profile-img/<?php echo $_SESSION['image']; ?>" alt="" style="height: 250px; width: 250px;">
                <b><h3><?php echo $_SESSION['name']; ?></h3></b>
                <p id="role"><span>Admin</span></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="changeProfilePictureForm">
                    <div id="changeProfilePictureDiv">
                        <label for="changeProfilePicture">Change your profile picture</label><br>
                        <input type="file" name="image" id="changeProfilePicture">
                    </div>
                </form>
            </div>
            <a href="../includes/logout.php"><button>Logout</button></a>
        </div>
    </div>
    <div class="footer">
        <?php require 'includes/footerAdmin.php'; ?>
    </div>

    <!-- jQuery and JavaScript  -->

    <script src="../lib/jquery/jQuery.js"></script>
    <script src="../lib/jquery/dist/jquery.validate.js"></script>
    <script src="../scripts/scripts.js"></script>
</body>
</html>