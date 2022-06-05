<?php
    require_once 'includes/sessionAdmin.php';
    require 'includes/function.php';

    $error = [];
    $countries = [];
    $topics = [];
    $users = [];
    $questions = [];
    $contacts = [];
    $admins = [];
    $name = $username = $email = $phone = $password = $image = $country = $city = $status = '';
    $topicName = $image = $title = $answer = $topic = '';

    // Stuffs 

    try {
        $sql = "select * from tbl_countries order by country_name";
        
        $query = mysqli_query($connection, $sql);

        while($country = mysqli_fetch_assoc($query)) {
            array_push($countries, $country);
        }

    } catch (Exception $e) {
        $error['connection'] = $e -> getMessage();
    }
    
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
        $sql = "select * from tbl_topics";

        $query = mysqli_query($connection, $sql);

        if (mysqli_num_rows($query) > 0) {
            while($topic = mysqli_fetch_assoc($query)) {
                array_push($topics, $topic);
            }
        }
    } catch (Exception $e) {
        $error['database'] = $e -> getMessage();
    }

    try {
        $sql = "select * from tbl_contacts";

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
                        move_uploaded_file($_FILES['image']['tmp_name'], '../images/profile-img/' . $image);
                    } else {
                        $error['imageAddAdmin'] = 'Upload valid image type';
                    }
                } else {
                    $error['imageAddAdmin'] = 'Upload less then 512kb image';
                }   
            } else {
                $error['imageAddAdmin'] = 'Upload valid image';
            }
        } else {
            $error['imageAddAdmin'] = 'Upload image';
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
                    echo '<script language="javascript">';
                    echo 'alert("Admin added successfully")';
                    echo '</script>';
                }
                
                header('Refresh: 0; url=adminDashboard.php?redirect=5');
            } catch (Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        }
    }

    // Add Topic

    if (isset($_POST['addTopicBtn'])) {
        if (checkForm($_POST, 'topicName')) {
            $topicName = $_POST['topicName'];
        } else {
            $error['topicName'] = 'Enter your topic name';
        }
        
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            if ($_FILES['image']['size'] < 10240000) {
                $file_types = ['images/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['image']['type'], $file_types)) {
                    $image = uniqid() . '_' . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], '../images/topic-img/' . $image);
                } else {
                    $error['imageTopic'] = 'Upload valid image type';
                }
            } else {
                $error['imageTopic'] = 'Upload image less then 1024mb';
            }
        } else {
            $error['imageTopic'] = 'Upload image';
        }

        if (count($error) == 0) {
            try {
                $sql = "insert into tbl_topics(topic_name, image) values('$topicName', '$image')";

                $query = mysqli_query($connection, $sql);

                if ($query) {
                    $topicName = $image = '';
                    echo '<script language="javascript">';
                    echo 'alert("Topic added")';
                    echo '</script>';
                }

                header('Refresh: 0; url=adminDashboard.php?redirect=6');
            } catch (Exception $e) {
                $error['database'] = $e -> getMessage();
            }
        }
    }

    // Add Questions & Answers

    if (isset($_POST['addQuestionsAnswers'])) {
        if (checkForm($_POST, 'question')) {
            $question = $_POST['question'];

            if (strlen($question) > 100) {
                $error['question'] = 'Question character should be less then 100 characters';
            }
        } else {
            $error['question'] = 'Enter your question';
        }
        
        if (checkForm($_POST, 'firstOption')) {
            $firstOption = trim($_POST['firstOption']);
        } else {
            $error['firstOption'] = 'Enter the first option of your question';
        }
        
        if (checkForm($_POST, 'secondOption')) {
            $secondOption = trim($_POST['secondOption']);
        } else {
            $error['secondOption'] = 'Enter the second option of your question';
        }
        
        if (checkForm($_POST, 'thirdOption')) {
            $thirdOption = trim($_POST['thirdOption']);
        } else {
            $error['thirdOption'] = 'Enter the third option of your question';
        }
        
        if (checkForm($_POST, 'fourthOption')) {
            $fourthOption = trim($_POST['fourthOption']);
        } else {
            $error['fourthOption'] = 'Enter the fourth option of your question';
        }
        
        if (checkForm($_POST, 'answer')) {
            $answer = trim($_POST['answer']);
        } else {
            $error['answer'] = 'Enter the answer of your question';
        }
        
        if (isset($_FILES['image']['name']) && $_FILES['image']['error'] == 0) {
            if ($_FILES['image']['size'] < 10240000) {
                $imageTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['image']['type'], $imageTypes)) {
                    $image = uniqid() . '_' . $_FILES['image']['name'];
                    move_uploaded_file($_FILES['image']['tmp_name'], '../images/blog-img/' . $image);
                } else {
                    $error['imageQuestion'] = 'Upload valid image type';
                }
            } else {
                $error['imageQuestion'] = 'Upload image with less then 1024mb';
            }
        } else {
            $error['imageQuestion'] = 'Upload image';
        }

        if (checkForm($_POST, 'topic_id')) {
            $topic_id = $_POST['topic_id'];
        } else {
            $error['topic_id'] = 'Select the topic of your question';
        }
        
        if (count($error) == 0) {
            try {
                $question = mysqli_real_escape_string($connection, $question);

                $sql = "insert into tbl_questions(question, firstOption, secondOption, thirdOption, fourthOption, answer, question_image, topic_id) values('$question', '$firstOption', '$secondOption', '$thirdOption', '$fourthOption', '$answer','$image','$topic_id')";

                $query = mysqli_query($connection, $sql);

                if ($query) {
                    $question = $answer = $topic_id = '';
                    echo '<script language="javascript">';
                    echo 'alert("Successfully added question")';
                    echo '</script>';
                }

                header('Refresh: 0; url=adminDashboard.php?redirect=7');
            } catch (Exception $e) {
                die($e -> getMessage());
            }
        }
    }

    if (isset($_GET['msg']) && $_GET['msg'] == 1) {
        echo '<script language="javascript">';
        echo 'alert("You cannot delete the current admin")';
        echo '</script>';
        header('Refresh: 0; url=adminDashboard.php?redirect=2');
    } else if (isset($_GET['msg']) && $_GET['msg'] == 2) {
        echo '<script language="javascript">';
        echo 'alert("You cannot block the current admin")';
        echo '</script>';
        header('Refresh: 0; url=adminDashboard.php?redirect=2');
    }    

    if (isset($_GET['redirect'])) {
        echo '<script language="javascript">';
        echo 'const redirect = ' . $_GET['redirect'];
        echo '</script>';
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
        <div class="container">
            <div class="tab-container">
                <div class="tabs">
                    <div class="button active" id="dashboard">Dashboard</div>
                    <div class="button" id="user-status">User Status</div>
                    <div class="button" id="admin-status">Admin Status</div>
                    <div class="button" id="list-topic">List Topics</div>
                    <div class="button" id="list-question">List Questions</div>
                    <div class="button" id="add-admin">Add Admin</div>
                    <div class="button" id="add-topic">Add Topics/Categories</div>
                    <div class="button" id="add-question">Add Questions & Answers</div>
                    <div class="button" id="contact-msg">View Contact Messages</div>
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
                        <div class="table-inner-container">
                            <div class="users-container">
                                <h3>User Status</h3>
                                <table class="admin-panel-table">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php foreach ($users as $key => $user) { ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $user['name']; ?></td>
                                            <td><?php echo $user['username']; ?></td>
                                            <td><?php echo $user['email']; ?></td>
                                            <td><?php echo $user['phone']; ?></td>
                                            <td>
                                                <?php if ($user['block'] == 0) { ?>
                                                    <a href="functions/unblock.php?token=<?php echo $user['id']; ?>&type=user" style="color: green" onclick= "return confirm('Are you sure you want to unblock this user?')">Unblock</a>
                                                <?php } else { ?>
                                                    <a href="functions/block.php?token=<?php echo $user['id']; ?>&type=user" style="color: red" onclick= "return confirm('Are you sure you want to block this user?')">Block</a>
                                                <?php } ?>
                                                <br><a href="functions/delete.php?token=<?php echo $user['id']; ?>&type=user" style="color: red" onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="table-inner-container">
                            <div class="admin-container">
                                <h3>Admin Status</h3>
                                <table class="admin-panel-table">
                                    <tr>
                                        <th>S.N.</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Action</th>
                                    </tr>
                                    <?php foreach ($admins as $key => $admin) { ?>
                                        <tr>
                                            <td><?php echo $key + 1; ?></td>
                                            <td><?php echo $admin['name']; ?></td>
                                            <td><?php echo $admin['username']; ?></td>
                                            <td><?php echo $admin['email']; ?></td>
                                            <td><?php echo $admin['phone']; ?></td>
                                            <td>
                                                <?php if ($admin['block'] == 0) { ?>
                                                    <a href="functions/unblock.php?token=<?php echo $admin['id']; ?>&type=admin" style="color: green" onclick="return confirm('Are you sure you want to unblock this admin')">Unblock</a>
                                                <?php } else { ?>
                                                    <a href="functions/block.php?token=<?php echo $admin['id']; ?>&type=admin" style="color: red" onclick="return confirm('Are you sure you want to block this admin?')">Block</a>
                                                <?php } ?>
                                                    <br><a href="functions/delete.php?token=<?php echo $admin['id']; ?>&type=admin" style="color: red" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                                            </td>
                                        </tr>   
                                    <?php } ?>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="content">
                        <div class="table-inner-container">
                            <h3>Topics</h3>
                            <table class="admin-panel-table">
                                <tr>
                                    <th>Topic name</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($topics as $topic) { ?>
                                    <tr>
                                        <td><?php echo $topic['topic_name']; ?></td>
                                        <td>
                                            <a href="functions/delete.php?token=<?php echo $topic['id']; ?>&type=topic" style="color: red" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <div class="content">
                        <div class="table-inner-container">
                            <h3>Questions</h3>
                            <table class="admin-panel-table">
                                <tr>
                                    <th>Topic</th>
                                    <th>Title</th>
                                    <th>Answer</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($questions as $question) { ?>
                                    <tr>
                                        <td><?php echo $question['topic_id']; ?></td>
                                        <td><?php echo $question['question']; ?></td>
                                        <td><?php echo $question['answer']; ?></td>
                                        <td><?php echo $question['created_at']; ?></td>
                                        <td>
                                            <a href="functions/delete.php?token=<?php echo $topic['id']; ?>&type=question" style="color: red" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    
                    <div class="content">
                        <div class="form-inner-container">
                            <h3>Add Admin</h3>
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
                                    <input type="file" name="image" id="addImage">            
                                </div>
                                <?php echo checkError($error, 'imageAddAdmin'); ?>
                                <div class="items country">
                                    <label for="country">country</label><br>
                                    <select name="country" id="country">
                                        <option value=""><b>Select your country</b></option>
                                        <?php foreach($countries as $country) { ?>
                                            <option value="<?php echo $country['id']; ?>"><?php echo $country['country_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php echo checkError($error, 'country'); ?>
                                <div class="items city">
                                    <label for="city">city</label><br>
                                    <select name="city" id="city">
                                        <option value=""><b>Select your city</b></option>
                                    </select>
                                </div>
                                <?php echo checkError($error, 'city'); ?>
                                <div class="items addAdminBtn">
                                     <button type="submit" name="addAdminBtn">Add</button>
                                </div>
                                <div class="items error">
                                    <?php echo checkError($error, 'database'); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form-inner-container">
                            <h3>Add Topics</h3>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                <div class="items title">
                                    <label for="topicName">Topic name</label>
                                    <input type="text" name="topicName" id="topicName" placeholder="Enter the name of topic">
                                </div>
                                <?php echo checkError($error, 'topicName'); ?>
                                <div class="items image">
                                    <label for="tImage">Topic image</label>
                                    <input type="file" name="image" id="tImage">
                                </div>
                                <?php echo checkError($error, 'imageTopic'); ?>
                                <div class="items button">
                                    <button type="submit" name="addTopicBtn">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="form-inner-container">
                            <h3>Add Question & Answer</h3>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                                <div class="items question">
                                    <label for="question">question</label>
                                    <input type="text" name="question" id="question" placeholder="Enter your question"><br>
                                </div>
                                <?php echo checkError($error, 'question'); ?>
                                <div class="items">
                                    <label for="firstOption">first option</label>
                                    <input type="text" name="firstOption" id="firstOption" placeholder="Submit your first option"><br>
                                </div>
                                <?php echo checkError($error, 'firstOption'); ?>
                                <div class="items">
                                    <label for="secondOption">second option</label>
                                    <input type="text" name="secondOption" id="secondOption" placeholder="Submit your second option"><br>
                                </div>
                                <?php echo checkError($error, 'secondOption'); ?>
                                <div class="items">
                                    <label for="thirdOption">third option</label>
                                    <input type="text" name="thirdOption" id="thirdOption" placeholder="Submit your third option"><br>
                                </div>
                                <?php echo checkError($error, 'thirdOption'); ?>
                                <div class="items">
                                    <label for="fourthOption">fourth option</label>
                                    <input type="text" name="fourthOption" id="fourthOption" placeholder="Submit your fourth option"><br>
                                </div>
                                <?php echo checkError($error, 'fourthOption'); ?>
                                <div class="items">
                                    <label for="answer">Answer</label><br>
                                    <select name="answer" id="answer">
                                        <option value="">Select your answer</option>
                                        <option value="firstOption">First Option</option>
                                        <option value="secondOption">Second Option</option>
                                        <option value="thirdOption">Third Option</option>
                                        <option value="fourthOption">Fourth Option</option>
                                    </select>
                                </div>
                                <?php echo checkError($error, 'answer'); ?>
                                <div class="items image">
                                    <label for="qImage">Image</label><br>
                                    <input type="file" name="image" id="qImage"><br>
                                </div>
                                <?php echo checkError($error, 'imageQuestion'); ?>
                                <div class="items option">
                                    <select name="topic_id" id="topic_id">
                                        <option value=""><b>Select your topic</b></option>
                                        <?php foreach($topics as $topic) { ?>
                                            <option value="<?php echo $topic['id']; ?>"><?php echo $topic['topic_name']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <?php echo checkError($error, 'topic_id'); ?>
                                <div class="items button">
                                    <button type="submit" name="addQuestionsAnswers">Add</button>
                                    <?php echo checkError($error, 'database'); ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="content">
                        <div class="table-inner-container">
                            <h3>Contact messages</h3>
                            <table class="admin-panel-table">
                                <tr>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                                <?php foreach($contacts as $contact) { ?>
                                    <tr>
                                        <td><?php echo $contact['username']; ?></td>
                                        <td><?php echo $contact['email']; ?></td>
                                        <td><?php echo $contact['message']; ?></td>
                                        <td><a href="functions/delete.php?token=<?php echo $contact['id']; ?>&type=contact" style="color: red" onclick="return confirm('Are you sure you want to delete this contact message?')">Delete</a></td>
                                    </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
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