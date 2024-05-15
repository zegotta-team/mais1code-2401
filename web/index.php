<?php
session_start();
if (!empty($_SESSION['empresaId'])) {
    header("Location: home.php");
    die();
}

require_once 'view/login.html';
