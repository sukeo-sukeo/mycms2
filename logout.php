<?php
session_start();

unset($_SESSION['id']);
unset($_SESSION['name']);
unset($_SESSION['error']);

header('Location: login.php'); 
exit();
