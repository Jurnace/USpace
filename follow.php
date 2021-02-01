<?php
session_start();
if(!isset($_SESSION["userid"])) {
    // user is not logged in
    header("Location: welcome.php");
    exit();
}

if(!isset($_GET["userid"])) {
    // the "userid" parameter is not found
    header("Location: index.php");
    exit();
}

if(!isset($_GET["mode"])) {
    // the "mode" parameter is not found
    header("Location: index.php");
    exit();
}

if(!is_numeric($_GET["userid"])) {
    // "userid" is not a number
    header("Location: index.php");
    exit();
}

require_once "config.php";

if($conn->connect_errno) {
    echo "Failed to connect to MySQL: " . $conn->connect_error;
    exit();
}

// convert to integer
$user_id = intval($_SESSION["userid"]);
$target_id = intval($_GET["userid"]);

if($user_id === $target_id) {
    // user tries to follow/unfollow himself
    header("Location: index.php");
    exit();
}

// make sure the follower exists
$stmt_u = $conn->prepare("SELECT * FROM `user` WHERE `id`=?");
$stmt_u->bind_param("i", $user_id);
$stmt_u->execute();
$stmt_u->store_result();

// make sure the user to be followed exists
$stmt_t = $conn->prepare("SELECT * FROM `user` WHERE `id`=?");
$stmt_t->bind_param("i", $target_id);
$stmt_t->execute();
$stmt_t->store_result();

// check if they exist
if($stmt_u->num_rows() === 0 || $stmt_t->num_rows() === 0) {
    header("Location: index.php");
    exit();
}

// close the database queries which are no longer used
$stmt_u->close();
$stmt_t->close();

if($_GET["mode"] === "0") {
    $stmt = $conn->prepare("DELETE FROM `follower` WHERE `follower_id`=? AND `following_id`=?");
    $stmt->bind_param("ii", $user_id, $target_id);
    $stmt->execute();
    $stmt->store_result();

    if($conn->affected_rows === 1) {
        header("Location: viewprofile.php?userid=" . $target_id);
    } else {
        echo "Unable to unfollow user";
    }
} else if($_GET["mode"] === "1") {
    $stmt = $conn->prepare("INSERT INTO `follower` (`follower_id`, `following_id`) VALUES(?, ?)");
    $stmt->bind_param("ii", $user_id, $target_id);
    $stmt->execute();
    $stmt->store_result();

    if($conn->affected_rows === 1) {
        header("Location: viewprofile.php?userid=" . $target_id);
    } else {
        echo "Unable to follow user";
    }
} else {
    header("Location: index.php");
}


