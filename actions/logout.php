<?php
include '../models/User.php';

session_start();

$_SESSION['current_user'] = null;

header('Location: ../views/login.php');
?>
