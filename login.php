<?php
    session_start();
    
    require 'includes/connection.php';
    require 'includes/function.php';

    if (isset($_COOKIE['username'])) {
        $_SESSION['username'] = $_COOKIE['username'];
        header('location: home.php');
    }

    if (isset($_SESSION['username'])) {
        header('location: home.php');
    }

    $error = [];
    $username = '';

    if (isset($_POST['loginBtn'])) {
        if (checkForm($_POST, 'username')) {
            $username = $_POST['username'];

            if (strlen($username) < 4) {
                $error['username'] = 'Enter 4 character username';
            }
            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $username)) {
                $error['username'] = 'Enter a valid username';
            }
        } else {
            $error['username'] = 'Enter your username';
        }

        if (checkForm($_POST, 'password')) {
            $password = $_POST['password'];
            $encPassword = md5($password);

            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $password)) {
                $error['password'] = 'Provide a password with atleast a number';
            }
        
        } else {
            $error['password'] = 'Enter your password';
        }
        
        if (count($error) == 0) {
            try {
                $sql = "select * from tbl_confidential where username = '$username' and password = '$encPassword'";

                $query = mysqli_query($connection, $sql);

                if (mysqli_num_rows($query) == 1) {
                    $userdata = mysqli_fetch_assoc($query);

                    session_start();

                    $_SESSION['token'] = $userdata['status'];
                    $_SESSION['name'] = $userdata['name'];
                    $_SESSION['username'] = $userdata['username'];
                    $_SESSION['image'] = $userdata['profile_img'];

                    if (isset($_POST['remember'])) {
                        setcookie('username', $username, time() + (7*24*60*60));
                    }

                    if ($userdata['status'] == 1) {
                        $username = '';
                        header("location: admin/adminDashboard.php");
                    } else if ($userdata['status'] == 2) {
                        $username = '';
                        header('location: home.php');
                    } else {

                    }
                } else {
                    $error['database'] = 'Invalid username or password';
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
    <title>Login</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header">
            Login
        </h3>
        <div class="card-wrapper">
            <div class="mainCard">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="items username">
                        <label for="username">username</label><br>
                        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>">
                    </div>
                    <?php echo checkError($error, 'username') ?>
                    <div class="items password">
                        <label for="password">password</label><br>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <?php echo checkError($error, 'password') ?>
                    <div class="items remember">
                        <input type="checkbox" name="remember" id="remember" value="remember" style="width: min-content">
                        <label for="remember">Remember me</label>
                    </div>
                    <div class="items loginBtn">
                        <button type="submit" name="loginBtn">Login</button>
                    </div>
                    <div class="items">
                        <p>Not a member? <a href="register.php">Register</a></p>
                    </div>
                </form>
                <div class="error">
                    <?php echo checkError($error, 'database'); ?>
                </div>
                <div class="get">
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 1 ) { echo '<b><span class="success">Successfully registered</span></b>'; } ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 2 ) { echo '<b><span class="success">Logout successfully</span></b>'; } ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 3 ) { echo '<b><span class="error">Login to continue</span></b>'; } ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 4 ) { echo '<b><span class="error"></span></b>'; } ?>
                    <?php if (isset($_GET['msg']) && $_GET['msg'] == 5 ) { echo '<b><span class="error">Not authorized</span></b>'; } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php require 'includes/footer.php'; ?>
    </div>

    <!-- jQuery and JavaScript  -->

    <script src="lib/jquery/jQuery.js"></script>
    <script src="lib/jquery/dist/jquery.validate.js"></script>
    <script src="scripts/scripts.js"></script>
</body>
</html>