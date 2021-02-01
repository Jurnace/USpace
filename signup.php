<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // not a POST request
    echo "0";
    exit();
}

// make sure "name", "username" "email" and "password" are set
if(!isset($_POST["name"]) || !isset($_POST["username"]) || !isset($_POST["email"]) || !isset($_POST["password"])) {
    echo "0";
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "0";
    exit();
}

// set the timezone of the MySQL server
$conn->query("SET time_zone = '+08:00'");

session_start();

// trim "name" "username" and "email"
$name = trim($_POST["name"]);
// make the "username" lower case
$username = strtolower(trim($_POST["username"]));

if(preg_match("/\s/", $username)) {
    // username contains spaces
    echo "0";
    exit();
}

$email = trim($_POST["email"]);
// hash the password
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

// check if username exists
$stmt_u = $conn->prepare("SELECT `username` FROM `user` WHERE `username`=?");
$stmt_u->bind_param("s", $username);
$stmt_u->execute();
$stmt_u->store_result();

if($stmt_u->num_rows() > 0) {
    // username exists
    echo "1";
    exit();
}

$stmt_u->close();

// check if email exists
$stmt_e = $conn->prepare("SELECT `email` FROM `user` WHERE `email`=?");
$stmt_e->bind_param("s", $email);
$stmt_e->execute();
$stmt_e->store_result();

if($stmt_e->num_rows() > 0) {
    // email exists
    echo "2";
    exit();
}

$stmt_e->close();

$stmt = $conn->prepare("INSERT INTO `user` (`name`, `username`, `email`, `password`) VALUES(?, ?, ?, ?)");

$stmt->bind_param("ssss", $name, $username, $email, $password);

if($stmt->execute()) {
    $stmt->store_result();
    if($conn->affected_rows === 1) {
        // 1 row inserted, set the "userid" in PHP session
        $_SESSION["userid"] = $stmt->insert_id;
        echo "3";
    } else {
        echo "0";
    }
} else {
    echo "0";
}