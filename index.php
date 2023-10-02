<?php
$title = "TerraTurboThune";
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
</main>
</body>

<?php
include "footer.php";
?>