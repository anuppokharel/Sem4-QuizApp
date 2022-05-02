<?php
    require_once '../includes/sessionAdmin.php';
    require '../includes/function.php';

    $error = [];
    $users = [];
    $questions = [];
    $contacts = [];
    $admins = [];


    // Dashboard 

    try {
        $sql = "select * from tbl_confidential where status = 2";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($user = mysqli_fetch_assoc($query)) {
                array_push($users, $user);
            }
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    try {
        $sql = "select * from tbl_questions";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($question = mysqli_fetch_assoc($query)) {
                array_push($questions, $question);
            }
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    try {
        $sql = "select * from tbl_contact";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($contact = mysqli_fetch_assoc($query)) {
                array_push($contacts, $contact);
            }
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    try {
        $sql = "select * from tbl_confidential where status = 1";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($admin = mysqli_fetch_assoc($query)) {
                array_push($admins, $admin);
            }
        }

    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    // Add Admin 

    if (isset($_POST['addAdminBtn'])) {
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

        if (count($error) == 0) {
            try {
                $sql = "insert into tbl_confidential(name, username, profile_img, email, password, phone, country, city, gender, status) values('$name','$username','$image','$email','$cPassword','$phone','$country','$city','$gender','1')";
    
                $query = mysqli_query($connection, $sql);
    
                if ($query) {
                    $name = $username = $email = $phone = $password = $image = $country = $city = $status = '';
                    $successMsg = 'Admin added successfully';
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
    <link rel="stylesheet" href="../styles/styles.css"/>
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="header">
        <?php require '../includes/headerAdmin.php'; ?>
    </div>
    <div class="admin-body">
        <div class="container">
            <div class="tab-container">
                <div class="tabs">
                    <div class="button active">Dashboard</div>
                    <div class="button">Add Admin</div>
                    <div class="button">Admin/User Status</div>
                    <div class="button">Add Questions & Answers</div>
                    <div class="button">Add Topics/Categories</div>
                    <div class="button">List Questions & Topics</div>
                    <div class="button">View Contact Messages</div>
                </div>
                <div class="contents">
                    <div class="content active">
                        <div class="total-inner-container">
                            <div class="total">
                                <h3>Users</h3>
                                <span><?php echo count($users); ?></span>
                            </div>
                            <div class="total">
                                <h3>Questions</h3>
                                <span><?php echo count($questions); ?></span>
                            </div>
                            <div class="total">
                                <h3>Contacts</h3>
                                <span><?php echo count($contacts); ?></span>
                            </div>
                            <div class="total">
                                <h3>Admins</h3>
                                <span><?php echo count($admins); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="addAdmin-inner-container">
                            <div class="addAdmin">
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
                                        <br><input type="radio" name="gender" id="others" value="others" style="width: min-content">
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
                                    <div class="items addAdminBtn">
                                        <button type="submit" name="addAdminBtn">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="status-inner-container">
                            <h3>Admin Status</h3>
                            <table border="1">
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            <h3>User Status</h3>
                            <table border="1">
                                <tr>
                                    <th>Name</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="content">
                        <div class="question-inner-container">
                            <form action="">
                                <div class="items title">
                                    <label for="title">title</label>
                                    <input type="text" name="title" id="title" placeholder="Enter the title of your question"><br>
                                </div>
                                <div class="items">
                                    <label for="answers">answers</label>
                                    <input type="text" name="answers" id="answers" placeholder="Submit your password"><br>
                                </div>
                                <div class="items image">
                                    <label for="questionImage">Image</label><br>
                                    <input type="file" name="questionImage" id="questionImage"><br>
                                </div>
                                <div class="items options">
                                    <select name="topic" id="topic">
                                        <option value="">Select your topic</option>
                                    </select>
                                </div>
                                <div class="items button">
                                    <button>Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="topic-inner-container">
                            <form action="">
                                <div class="items title">
                                    <label for="topicName">Topic name</label>
                                    <input type="text" name="topicName" id="topicName" placeholder="Enter the name of topic">
                                </div>
                                <div class="items button">
                                    <button>Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="list-inner-container">
                            <h3>Questions</h3>
                            <table border="1">
                                <tr>
                                    <th>topic</th>
                                    <th>title</th>
                                    <th>answer</th>
                                    <th>posted_by</th>
                                    <th>action</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                            <h3>Topics</h3>
                            <table border="1">
                                <tr>
                                    <th>topic name</th>
                                    <th>action</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="content">
                        <div class="contact-inner-container">
                            <h3>Contact messages</h3>
                            <table border="1">
                                <tr>
                                    <th>username</th>
                                    <th>email</th>
                                    <th>message</th>
                                    <th>action</th>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <?php require '../includes/footerAdmin.php'; ?>
    </div>

    <!-- jQuery and JavaScript  -->

    <script src="../lib/jquery/jQuery.js"></script>
    <script src="../lib/jquery/dist/jquery.validate.js"></script>
    <script src="../scripts/scripts.js"></script>
</body>
</html>