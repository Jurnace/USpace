<?php
session_start();

// remove everything in the PHP session
session_destroy();

// redirect user to welcome.php
header("Location: welcome.php");