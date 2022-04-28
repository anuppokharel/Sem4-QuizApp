<?php
    session_start();

    require 'includes/connection.php';
    require 'includes/function.php';

    $error = [];
    $username = $email = $message = '';

    if (isset($_POST['contactBtn'])) {
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

        if (checkForm($_POST, 'email')) {
            $email = $_POST['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Enter a valid email address';
            }
        } else {
            $error['email'] = 'Enter your email address';
        }

        if (checkForm($_POST, 'message')) {
            $message = $_POST['message'];

            if (strlen($message) < 15) {
                $error['message'] = 'Enter atleast 15 characters minimum';
            }
        } else {
            $error['message'] = 'Provide your message';
        }

        if (checkForm($_POST, 'password')) {
            $password = $_POST['password'];

            if (!preg_match("/^[a-zA-Z]+[0-9]+$/", $password)) {
                $error['password'] = 'Provide a password with atleast a number';
            }
        } else {
            $error['password'] = 'Enter your password';
        }

        if (count($error) == 0) {
            try {
                $sql = "insert into tbl_contact(username, email, message, password) values('$username', '$email', '$message', '$password')";

                $query = mysqli_query($connection, $sql);

                if ($query) {
                    $successMsg = 'Successfully placed a contact message';
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
    <link rel="stylesheet" href="styles/styles.css">
    <title>Contact</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header">
            Contact
        </h3>
        <div class="card-wrapper">
            <div class="mainCard">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="items username">
                        <label for="username">username</label><br>
                        <input type="text" name="username" id="username" placeholder="Enter your username" value="<?php echo $username ?>">
                    </div>
                    <?php echo checkError($error, 'username'); ?>
                    <div class="items email">
                        <label for="email">email</label><br>
                        <input type="text" name="email" id="email" placeholder="Enter your email address" value="<?php echo $username ?>">
                    </div>
                    <?php echo checkError($error, 'email'); ?>
                    <div class="items message">
                        <label for="message">message</label><br>
                        <textarea name="message" id="message" cols="50" rows="5" placeholder="Write your message"><?php echo $username ?></textarea>
                    </div>
                    <?php echo checkError($error, 'message'); ?>
                    <div class="items password">
                        <label for="password">password</label><br>
                        <input type="password" name="password" id="password" placeholder="Enter your password">
                    </div>
                    <?php echo checkError($error, 'password'); ?>
                    <div class="items contactBtn">
                        <button type="submit" name="contactBtn">Submit</button>
                    </div>
                </form>
                <div class="success-error">
                    <?php if(isset($successMsg)) { echo '<b><span class="success">' . $successMsg . '</span></b>'; } ?>
                    <?php echo checkError($error, 'database'); ?>
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