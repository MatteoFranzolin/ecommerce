<?php
include '../models/User.php';

session_destroy();
session_start();

$_SESSION['current_user'] = null;

header('Location: ../views/login.php');
?>
