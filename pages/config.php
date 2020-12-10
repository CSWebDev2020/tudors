<?php
define('DB_SERVER', 'us-cdbr-east-02.cleardb.com');
define('DB_USERNAME', 'b3b35e78bb19ee');
define('DB_PASSWORD', 'da3077b3');
define('DB_NAME', 'heroku_4a075d33191a53f');

$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($link === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}