<?php
session_start();

function admin_required() {
    if (!isset($_SESSION['admin'])) {
        header("Location: login.php");
        exit;
    }
}
