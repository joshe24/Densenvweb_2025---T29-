<?php

function sanitize($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

function require_login() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../public/login.php");
        exit;
    }
}
