<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id = $_GET['id'];
?>
<main>
    <?php
    $requete = $pdo->prepare("select * from shop WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
        <img src="img/<?php echo $l['photo']?>" alt="IMG photo shop">
        <h2><?php echo $l['name']?></h2>
        <p><?php echo $l['category']?></p>
        <p><?php echo $l['adress']?></p>
    <?php }
    $requete = $pdo->prepare("select * from offer WHERE shop_id = :shop_id");
    $requete->bindParam(":shop_id", $id);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
        <h2><?php echo $l['title']?></h2>
        <p><?php echo $l['description']?></p>
        <p><?php echo $l['date_start']?></p>
        <p><?php echo $l['date_end']?></p>
        <h4><?php echo $l['points']?></h4>
    <?php } ?>
</main>
<?php
include "footer.php";
?>