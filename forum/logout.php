<?php

session_start();


session_unset();


session_destroy();


if (isset($_COOKIE['user_id'])) {
    setcookie('user_id', '', time() - 3600, '/'); 
}
if (isset($_COOKIE['user_name'])) {
    setcookie('user_name', '', time() - 3600, '/');
}

// Ana sayfaya yönlendir
header("Location: blog.php");
exit();
