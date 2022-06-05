<?php
    define('db_host', '127.0.0.1');
    define('db_username', 'root');
    define('db_password', '');
    define('db_name', 'db_quizapp');

    // initialize the connection 

    $connection = mysqli_connect(db_host, db_username, db_password, db_name);

?>