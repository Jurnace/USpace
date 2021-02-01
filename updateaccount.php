<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // not a POST request
    echo "0";
    exit();
}

// make sure "oldPassword" and "newPassword" are set
if(!isset($_POST["oldPassword"]) || !isset($_POST["newPassword"])) {
    echo "0";
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "0";
    exit();
}

session_start();

if(!isset($_SESSION["userid"])) {
    // user is not logged in
    echo "0";
    exit();
}

//convert to integer
$user_id = intval($_SESSION["userid"]);

$old_password = $_POST["oldPassword"];

// get the hashed password
$stmt = $conn->prepare("SELECT `password` FROM `user` WHERE `id`=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($password);
$stmt->store_result();

if($stmt->num_rows() !== 1) {
    // user not found
    echo "0";
    exit();
}

$stmt->fetch();

// make sure the old password matches with the stored password
if(!password_verify($old_password, $password)) {
    echo "0";
    exit();
}

// hash the new password
$new_password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);

$stmt_p = $conn->prepare("UPDATE `user` SET `password`=? WHERE `id`=?");
$stmt_p->bind_param("si", $new_password, $user_id);

if($stmt_p->execute()) {
    $stmt_p->store_result();
    if($conn->affected_rows === 1) {
        // 1 row updated
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "0";
}