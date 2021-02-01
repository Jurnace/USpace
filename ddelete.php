<?php
// delete table `user` and `follower`
require_once "config.php";

if($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

if($conn->query("DROP TABLE IF EXISTS `user`")) {
    echo "Table `user` deleted <br>";
} else {
    echo "Failed to delete table `user` <br>";
}

if($conn->query("DROP TABLE IF EXISTS `follower`")) {
    echo "Table `follower` deleted <br>";
} else {
    echo "Failed to delete table `follower` <br>";
}

// loop through all the files in /avatar and delete them
foreach(glob("avatar/*") as $file) {
    unlink($file);
}