<?php
$title = "Gigaldi";
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);
?>

<body>
<main>
    <p>
    <?php
    $requete = $pdo->prepare("select * from shop WHERE id = 1");
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
        echo $l['name'];
    }
    ?>
    </p>
    <img src="img/logo-ttt.png" alt="Logo">
    <h1>Gigaldi</h1>
</main>
</body>

<?php
include "footer.php";
?>