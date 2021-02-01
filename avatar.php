<?php
// output a square image to make sure all avatars are a sqaure in alluser.php

if(!isset($_GET["img"])) {
    // img paramter not found
    echo "Unknown image";
    exit();
}

$path =  "avatar/" . $_GET["img"];
if(!file_exists($path)) {
    // file not found
    echo "Unknown image";
    exit();
}

$info = getimagesize($path);
$mime = $info["mime"];

$image;

// load the image depending on the type
if($mime === "image/jpeg") {
    $image = imagecreatefromjpeg($path);
} else if($mime === "image/png") {
    $image = imagecreatefrompng($path);
} else if($mime === "image/gif") {
    $image = imagecreatefromgif($path);
} else {
    echo "Unknown image";
    exit();
}

// resize the image
$image_new = imagescale($image, 512, 512);

// set the content type
header("Content-Type: " . $mime);

// display the image
if($mime === "image/jpeg") {
    imagejpeg($image_new);
} else if($mime === "image/png") {
    imagepng($image_new);
} else if($mime === "image/gif") {
    imagegif($image_new);
}