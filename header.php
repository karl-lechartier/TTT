<?php
include "header_mini.php";
?>
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
        <?php
        if ($_SESSION is null) { ?>
            <a href="logout.php">Se déconnecter</a>
        <?php } else {?>
            <a href="login.php">Se connecter</a>
        <?php }
        ?>
        <a href="ajout_magasin.php">Ajouter un Magasin</a>
        <a href="">Rien</a>
        <a href="">Rien</a>
    </div>
</nav>
<header>
</header>