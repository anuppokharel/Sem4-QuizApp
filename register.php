<?php
    require 'includes/connection.php';
    require 'includes/function.php';

    $error = [];
    $countries = [];
    $name = $username = $email = $phone = $password = $image = $country = $city = $status = '';
    
    try {
        $sql = "select * from tbl_countries order by country_name";
        
        $query = mysqli_query($connection, $sql);

        while($country = mysqli_fetch_assoc($query)) {
            array_push($countries, $country);
        }

    } catch (Exception $e) {
        $error['connection'] = $e -> getMessage();
    }

    if (isset($_POST['registerBtn'])) {
        if (checkForm($_POST, 'name')) {
            $name = $_POST['name'];

            if (strlen($name) < 8) {
                $error['name'] = 'Your name should be atleast 8 characters';

            } else if (!preg_match("/^[a-zA-Z ]+$/", $name)) {
                $error['name'] = 'Your name should not have special characters';
            }
        } else {
            $error['name'] = 'Enter your name';
        }

        if (checkForm($_POST, 'username')) {
            $username = $_POST['username'];

        } else {
            $error['username'] = 'Enter your username';
        }

        if (checkForm($_POST, 'email')) {
            $email = $_POST['email'];

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = 'Enter correct email address';
            }
        } else {
            $error['email'] = 'Enter your email address';
        }

        if (checkForm($_POST, 'phone')) {
            $phone = $_POST['phone'];

            if (strlen($phone) > 10) {
                $error['phone'] = 'Enter valid phone number';
            }
        } else {
            $error['phone'] = 'Enter your phone number';
        }

        if (checkForm($_POST, 'password')) {
            $password = $_POST['password'];

            if (!preg_match("/^[a-zA-Z0-9]+$/", $password)) {
                $error['password'] = 'Provide a password with atleast a number';
            }
        } else {
            $error['password'] = 'Provide a password';
        }

        if (checkForm($_POST, 'confirmPassword')) {
            $confirmPassword = $_POST['confirmPassword'];
            $cPassword = md5($confirmPassword);

            if (!($password == $confirmPassword)) {
                $error['confirmPassword'] = 'Your password does not match';
            }
        } else {
            $error['confirmPassword'] = 'Provide a matching password';
        }

        if (checkForm($_POST, 'gender')) {
            $gender = $_POST['gender'];
        } else {
            $error['gender'] = 'Select your gender';
        }

        if(isset($_FILES['image'])) {
            if($_FILES['image']['error'] == 0) {
                if($_FILES['image']['size'] <= 10240000) {
                    $imageTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                    if(in_array($_FILES['image']['type'], $imageTypes)) {
                        $image = uniqid() . '_' . $_FILES['image']['name'];
                        move_uploaded_file($_FILES['image']['tmp_name'], 'images/profile-img/' . $image);
                    } else {
                        $error['image'] = 'Upload valid image type';
                    }
                } else {
                    $error['image'] = 'Upload less then 512kb image';
                }   
            } else {
                $error['image'] = 'Upload valid image';
            }
        } else {
            $error['image'] = 'Upload image';
        }

        if (checkForm($_POST, 'country')) {
            $country = $_POST['country'];
        } else {
            $error['country'] = 'Select your country';
        }

        if (checkForm($_POST, 'city')) {
            $city = $_POST['city'];
        } else {
            $error['city'] = 'Select your city';
        }

        if (isset($_POST['status'])) {
            $status = 2;
        } else {
            $error['status'] = 'Please accept our terms & conditions';
        }

        if (count($error) == 0) {
            try {
                $sql = "insert into tbl_confidential(name, username, profile_img, email, password, phone, country, city, gender, status) values('$name','$username','$image','$email','$cPassword','$phone','$country','$city','$gender','$status')";
    
                $query = mysqli_query($connection, $sql);
    
                if ($query) {
                    $name = $username = $email = $phone = $password = $image = $country = $city = $status = '';
                    header('location: login.php?msg=1');
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
    <title>Register</title>
</head>
<body>
    <div class="header">
        <?php require 'includes/header.php'; ?>
    </div>
    <div class="body-container">
        <h3 class="body-header">
            Register
        </h3>
        <div class="card-wrapper">
            <div class="mainCard">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                    <div class="items name">
                        <label for="name">name</label><br>
                        <input type="text" name="name" id="name" placeholder="Full name" value="<?php echo $name; ?>">
                    </div>
                    <?php echo checkError($error, 'name'); ?>
                    <div class="items username">
                        <div class="label-username">
                            <label for="username">username</label>
                            <span class="queryMsgUsername"></span>
                        </div>
                        <input type="text" name="username" id="username" placeholder="Username" value="<?php echo $username; ?>">
                    </div>
                    <?php echo checkError($error, 'username'); ?>
                    <div class="items email">
                        <div class="label-email">
                            <label for="email">email</label>
                            <span class="queryMsgEmail"></span>
                        </div>
                        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>">
                    </div>
                    <?php echo checkError($error, 'email'); ?>
                    <div class="items phone">
                        <label for="phone">phone</label><br>
                        <input type="number" name="phone" id="phone" placeholder="Phone number" value="<?php echo $phone; ?>">
                    </div>
                    <?php echo checkError($error, 'phone'); ?>
                    <div class="items password">
                        <label for="password">password</label><br>
                        <input type="password" name="password" id="password" placeholder="Password">
                    </div>
                    <?php echo checkError($error, 'password'); ?>
                    <div class="items confirmPassword">
                        <label for="confirmPassword">confirm password</label><br>
                        <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirm Password">
                    </div>
                    <?php echo checkError($error, 'confirmPassword'); ?>
                    <div class="items gender">
                        <p style="margin-bottom: 5px">Gender</p>
                        <input type="radio" name="gender" id="male" value="male" style="width: min-content">
                        <label for="male">male</label>
                        <input type="radio" name="gender" id="female" value="female" style="width: min-content">
                        <label for="female">female</label>
                        <input type="radio" name="gender" id="others" value="others" style="width: min-content">
                        <label for="other">others</label>
                    </div>
                    <?php echo checkError($error, 'gender'); ?>
                    <div class="items image">
                        <label for="image">add image</label><br>
                        <input type="file" name="image" id="image">            
                    </div>
                    <?php echo checkError($error, 'image'); ?>
                    <div class="items country">
                        <label for="country">country</label><br>
                        <select name="country" id="country">
                            <option value="">Select your country</option>
                            <?php foreach($countries as $country) { ?>
                                <option value="<?php echo $country['id']; ?>"><?php echo $country['country_name']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <?php echo checkError($error, 'country'); ?>
                    <div class="items city">
                        <label for="city">city</label><br>
                        <select name="city" id="city">
                            <option value="">Select your city</option>
                        </select>
                    </div>
                    <?php echo checkError($error, 'city'); ?>
                    <div class="items terms-condition">
                        <input type="checkbox" name="status" id="terms" value="checked" style="width: min-content">
                        <label for="terms">I accept the terms & condition</label>
                    </div>
                    <div class="items registerBtn">
                        <button type="submit" name="registerBtn">Register</button>
                    </div>
                    <div class="items">
                        <p>Already a member? <a href="login.php">Login</a></p>
                    </div>
                </form>
                <div class="success-error">
                    <?php echo checkError($error, 'database'); ?>
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