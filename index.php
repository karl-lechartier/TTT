<?php
$title = "Gigaldi";
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);
?>

<body>
<main>
    <div class="card-deck">
    <?php
    $requete = $pdo->prepare("select * from shop LIMIT 30");
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
        <div class="card">
            <img class="card-img-top" src="img/<?php echo $l['photo']?>" alt="Card image cap">
            <div class="card-body">
                <h2 class="card-title"><?php echo $l['name']?></h2>
                <p class="card-text"><?php echo $l['category']?></p>
                <p class="card-text"><small class="text-muted"><?php echo $l['adress']?></small></p>
            </div>
        </div>
        <?php
        }
        ?>
    </div>
</main>
</body>

<?php
include "footer.php";
?>