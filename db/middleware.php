<?php
function guest(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (isset($_SESSION['id']) && $_SESSION['login']) {
        header("Location: index.php");
        exit();
    }
}
function auth(): void
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['id']) || !$_SESSION['login']) {
        header("Location: login.php");
        exit();
    }
}