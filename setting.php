<?php
    require 'includes/connection.php';
    require 'includes/function.php';
    require 'includes/session.php';

    $error = [];
    $username = $_SESSION['username'];


    try {
        $sql = "select * from tbl_confidential where username = '$username'";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) == 1) {
            $data = mysqli_fetch_assoc($query);
            $currentpwd = $data['password'];
        }
    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    if (isset($_POST['passwordBtn'])) {
        if (checkForm($_POST, 'currentpw')) {
            $currentpw = $_POST['currentpw'];
            $currentpwe = md5($currentpw);

            if (strlen($currentpw) < 4) {
                $error['currentpw'] = 'Invalid password';
            }
            if (!($currentpwe == $currentpwd)) {
                $error['currentpw'] = 'Your current password does not match';
            }
            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $currentpw)) {
                $error['currentpw'] = 'Not a valid password';
            }
        } else {
            $error['currentpw'] = 'Provide your current password';
        }

        if (checkForm($_POST, 'newpw')) {
            $newpw = $_POST['newpw'];

            if (strlen($newpw) < 4) {
                $error['newpw'] = 'Invalid password';
            }
            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $newpw)) {
                $error['newpw'] = 'Not a valid password';
            }
        } else {
            $error['newpw'] = 'Provide your current password';
        }

        if (checkForm($_POST, 'confirmpw')) {
            $confirmpw = $_POST['confirmpw'];
            $confirmpwe = md5($confirmpw);

            if (strlen($confirmpw) < 4) {
                $error['confirmpw'] = 'Invalid password';
            }
            if (!($confirmpw == $newpw)) {
                $error['confirmpw'] = 'Password does not match';
            }
            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $confirmpw)) {
                $error['confirmpw'] = 'Not a valid password';
            }
        } else {
            $error['confirmpw'] = 'Provide your current password';
        }

        if (count($error) == 0) {
            try {
                $sql = "update tbl_confidential set password = '$confirmpwe' where username = '$username'";

                $query = mysqli_query($connection, $sql);

                if ($query) {
                    $successMsg = 'Successfully changed password';
                }

            } catch (Exception $e) {
                $error['database'] = $e -> getMessage();
            
            }
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
    <link rel="stylesheet" href="styles/styles.css"/>
    <title>Settings</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header">
            Account Settings - Change Password
        </h3>
        <div class="card-wrapper">
            <div class="mainCard">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="items currentpw">
                        <label for="currentpw">current password</label>
                        <input type="password" name="currentpw" id="currentpw" placeholder="Enter your current password">
                    </div>
                    <?php echo checkError($error, 'currentpw'); ?>
                    <div class="items newpw">
                        <label for="newpw">new password</label>
                        <input type="password" name="newpw" id="newpw" placeholder="Enter your current password">
                    </div>
                    <?php echo checkError($error, 'newpw'); ?>
                    <div class="items confirmpw">
                        <label for="confirmpw">confirm password</label>
                        <input type="password" name="confirmpw" id="confirmpw" placeholder="Enter your current password">
                    </div>
                    <?php echo checkError($error, 'confirmpw'); ?>
                    <div class="items passwordBtn">
                        <button type="submit" name="passwordBtn">Confirm</button>
                    </div>
                </form>
                <div class="success-error">
                    <?php if (isset($successMsg)) { echo '<b><span class="success">' . $successMsg . '</span></b>'; } ?>
                    <?php echo checkError($error, 'database'); ?>
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