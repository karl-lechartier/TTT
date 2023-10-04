<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id_shop = $_GET['shop'];
?>
<main>
    <?php
    echo $id_shop;
    $requete = $pdo->prepare("select * from offer WHERE shop_id = :shop_id");
    $requete->bindParam(":shop_id", $id_shop);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
        ?>
        <h2><?php echo $l['title'] ?></h2>
        <p><?php echo $l['description'] ?></p>
        <p>Date de début : <?php echo $l['date_start'] ?></p>
        <p>Date de fin : <?php echo $l['date_end'] ?></p>
        <p>Points : <?php echo $l['points'] ?></p>
        <form action="manageOffer.php" method="post">
            <label for="title">Titre </label>
            <input type="text" id="title" name="title" value="<?php echo $l['title'] ?>" required>
        </form>
        <?php } ?>
</main>
<?php
include "footer.php";
?>