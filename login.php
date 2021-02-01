<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // not a POST request
    echo "0";
    exit();
}

// make sure "username" and "password" are set
if(!isset($_POST["username"]) || !isset($_POST["password"])) {
    echo "0";
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "0";
    exit();
}

// trim the username
$username = trim($_POST["username"]);
$password = $_POST["password"];

session_start();

$stmt = $conn->prepare("SELECT `id`, `password` FROM `user` WHERE `username`=?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->store_result();

if($stmt->num_rows() > 0) {
    // a user with the username exists
    $stmt->bind_result($id, $current_password);
    $stmt->fetch();
    // compare the received password with the password stored
    if(password_verify($password, $current_password)) {
        // passwords match, set the "userid" in PHP session
        $_SESSION["userid"] = $id;
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "0";
}