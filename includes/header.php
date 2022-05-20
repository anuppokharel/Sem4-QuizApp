<div class="header">
    <div class="container">
        <div class="logo">
            <h1>Stock Quiz App</h1>
        </div>
        <div class="navbar-wrapper">
            <div class="navbar header">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div>
            <div class="profile">
                <div class="profile-info">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <img src="images/profile-img/<?php echo $_SESSION['image']; ?>" id="profileImg">
                    <?php } else { ?>
                        <a href="login.php"><i class="fas fa-user-circle"></i></a>
                    <?php } ?>               
                </div>
                <div class="profile-dropdown">
                    <div class="profile-dropdown-inner">
                        <div class="div">
                            <img src="images/profile-img/<?php if(isset($_SESSION['image'])) { echo $_SESSION['image']; } ?>" id="profileFullImg">
                            <small id="profileName"><?php if(isset($_SESSION['image'])) { echo $_SESSION['name']; } ?></small>
                        </div>
                        <div class="div2">
                            <a href="profile.php">Profile</a>
                            <a href="setting.php">Settings</a>
                            <a href="includes/logout.php">Log Out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>