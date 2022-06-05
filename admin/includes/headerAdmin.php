<div class="header">
    <div class="container">
        <div class="logo">
            <a href="adminDashboard.php"><h1>Stock Quiz App</h1></a>
        </div>
        <div class="navbar-wrapper">
            <!-- <div class="navbar header">
                <ul>
                    <li><a href="home.php">Home</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div> -->
            <div class="profile">
                <div class="profile-info">
                    <?php if (isset($_SESSION['username'])) { ?>
                        <img src="../images/profile-img/<?php echo $_SESSION['image']; ?>" id="profileImg">
                    <?php } else { ?>
                        <a href="../login.php?msg=5"><i class="fas fa-user-circle"></i></a>
                    <?php } ?>               
                </div>
                <div class="profile-dropdown">
                    <div class="profile-dropdown-inner">
                        <div class="div">
                            <img src="../images/profile-img/<?php echo $_SESSION['image']; ?>" id="profileFullImg">
                            <small id="profileName"><?php echo $_SESSION['name']; ?></small>
                        </div>
                        <div class="div2">
                            <a href="adminProfile.php">Profile</a>
                            <a href="adminSetting.php">Settings</a>
                            <?php if ($_SESSION['status'] == 1) { ?>
                                <a href="../includes/logout.php">Log Out</a>
                            <?php } else { ?>
                                <a href="includes/logout.php">Log Out</a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>