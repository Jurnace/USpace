<?php
if($_SERVER["REQUEST_METHOD"] !== "POST") {
    // not a POST request
    echo "0";
    exit();
}

// make sure all the paramaters are set
if(!isset($_POST["name"]) || !isset($_POST["age"]) || !isset($_POST["education"]) || !isset($_POST["hobbies"]) || !isset($_POST["languages"]) || !isset($_POST["experience"]) || !isset($_POST["bio"])) {
    echo "0";
    exit();
}

// make sure the avatar is selected
if(!isset($_FILES["avatar"]) || empty($_FILES["avatar"]["name"])) {
    echo "0";
    exit();
}

if(getimagesize($_FILES["avatar"]["tmp_name"]) === FALSE) {
    // file uploaded is not an image
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
    // user not logged in
    echo "0";
    exit();
}

// convert to integer
$user_id = intval($_SESSION["userid"]);

// trim to remove spaces before and after text
$name = trim($_POST["name"]);
$age = trim($_POST["age"]);
if(!ctype_digit($age)) {
    // age is not a number
    echo "0";
    exit();
}

$education = trim($_POST["education"]);
$hobbies = trim($_POST["hobbies"]);
$languages = trim($_POST["languages"]);
$experience = trim($_POST["experience"]);
$bio = trim($_POST["bio"]);

// the file name for the avatar
$filename = $user_id . "." . pathinfo($_FILES["avatar"]["name"], PATHINFO_EXTENSION);
// the file path for the avatar
$path = "avatar/" . $filename;

if(file_exists($path)) {
    // old file(avatar) exists, delete it
    unlink($path);
}

if(!move_uploaded_file($_FILES["avatar"]["tmp_name"], $path)) {
    // moving file failed
    echo "0";
    exit();
}

$stmt = $conn->prepare("UPDATE `user` SET `name`=?, `age`=?, `education`=?, `hobbies`=?, `languages`=?, `working_experience`=?, `bio`=?, `avatar`=? WHERE `id`=?");
$stmt->bind_param("sissssssi", $name, $age, $education, $hobbies, $languages, $experience, $bio, $filename, $user_id);

if($stmt->execute()) {
    $stmt->store_result();
    if($conn->affected_rows === 1) {
        // 1 row updated
        echo "1";
    } else {
        echo "0";
    }
} else {
    echo "0";
}