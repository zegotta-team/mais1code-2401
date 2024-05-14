<?php
session_start();
if (!empty($_SESSION['empresaId'])) {
    header("Location: home.php");
    die();
}

require 'view/cadastrar_empresa.phtml';