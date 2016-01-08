<<?php 
require 'base.php';
$_SESSION['logged'] = false;
session_destroy();
header('Location: index.php');

?>