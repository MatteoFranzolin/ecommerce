<?php
require_once '../models/User.php';
require_once '../models/Session.php';

session_start();
session_destroy();

Session::Deactive($_SESSION['session_id']);
$_SESSION['session_id'] = null;
$_SESSION['current_user'] = null;

header('Location: ../views/login.php');
?>
