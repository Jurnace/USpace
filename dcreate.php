<?php
// create table `user` and `follower`
require_once "config.php";

if($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

$sql1 = "CREATE TABLE IF NOT EXISTS `user`(
    `id` INT NOT NULL AUTO_INCREMENT,
    `username` VARCHAR(20) NOT NULL UNIQUE,
    `email` VARCHAR(255) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `age` INT,
    `working_experience` VARCHAR(1000),
    `education` VARCHAR(255),
    `hobbies` VARCHAR(255),
    `languages` VARCHAR(255),
    `bio` VARCHAR(2000),
    `joined` DATETIME DEFAULT CURRENT_TIMESTAMP,
    `avatar` VARCHAR(255),
    PRIMARY KEY (id)
)";

if($conn->query($sql1)) {
    echo "Table `user` created <br>";
} else {
    echo "Failed to create table `user` <br>";
}

$sql2 = "CREATE TABLE IF NOT EXISTS `follower`(
    `follower_id` INT NOT NULL,
    `following_id` INT NOT NULL
)";

if($conn->query($sql2)) {
    echo "Table `database` created <br>";
} else {
    echo "Failed to create table `database` <br>";
}

if(!is_dir("avatar")) {
    if(mkdir("avatar")) {
        echo "`avatar` folder created <br>";
    } else {
        echo "Failed to create folder `avatar` <br>";
    }
}