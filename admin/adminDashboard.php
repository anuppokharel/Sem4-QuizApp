<?php
    require_once '../includes/sessionAdmin.php';
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
    <div class="body-container">
        <?php print_r($_SESSION); ?>
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