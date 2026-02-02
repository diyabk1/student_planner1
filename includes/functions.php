<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

function check_login() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}


function format_date($date) {
    return date("D, M jS", strtotime($date));
}
?>