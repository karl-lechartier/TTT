<?php
include "header_mini.php";
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<nav>
    <input type="checkbox" id="nav-check">
    <div class="nav-header">
        <div class="icone">
            <img src="img/logo-ttt.png" alt="Logo">
        </div>
        <div class="nav-title">
            <a href="index.php" class="home"><h1>Gigaldi</h1></a>
        </div>
    </div>
    <div class="nav-btn">
        <label for="nav-check">
            <span></span>
            <span></span>
            <span></span>
        </label>
    </div>

    <div class="nav-links">
        <a href="login.php">Se connecter</a>
        <a href="ajout_magasin.php">Ajouter un Magasin</a>
        <a href="">Rien</a>
        <a href="">Rien</a>
    </div>
</nav>
<header>
</header>