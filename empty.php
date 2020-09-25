<?php session_start(); if(!isset($_SESSION['username'])){header('Location: login.php');} ?>

<?php 
unset($_SESSION['cart']);
header('Location: cart.php');
?>