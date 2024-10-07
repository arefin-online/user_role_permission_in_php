<?php
include_once('header.php');
unset($_SESSION['user']);
header('location: login.php');
exit;