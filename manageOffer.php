<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id_shop = $_GET['shop'];

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (!$_SESSION['user']['pro']) {
    header ("location: account.php");
}

$requete = $pdo->prepare("Select * from user_shop WHERE id_shop = :id_shop");
$requete->bindParam("id_shop", $id_shop);
$requete->execute();
$lignes = $requete->fetchAll();
foreach ($lignes as $l) {
    if ($_SESSION['user']['id'] != $l['id_user']) {
        header ("location: account.php");
    }
}

?>
<main>
    <div class="button-ajout-magasin-container">
        <a href="addOffer.php?id_shop=<?php echo $id_shop?>" class="button">Ajouter une offre</a>
    </div>
    <?php
    $requete = $pdo->prepare("select * from offer WHERE shop_id = :shop_id");
    $requete->bindParam(":shop_id", $id_shop);
    $requete->execute();
    $lignes = $requete->fetchAll();
    ?>
    <div class="cards-container">
        <?php foreach ($lignes as $l) { ?>
            <div class="card">
                <h2><?php echo htmlspecialchars($l['title']); ?></h2>
                <p><?php echo htmlspecialchars($l['description']); ?></p>
                <p><?php echo htmlspecialchars($l['date_start']); ?></p>
                <p><?php echo htmlspecialchars($l['date_end']); ?></p>
                <h4><?php echo htmlspecialchars($l['points']); ?></h4>
                <a href="updateOffer.php?id=<?php echo htmlspecialchars($l['id']); ?>" class="btn btn-update">Modifier</a>
                <a href="deleteOffer.php?id=<?php echo htmlspecialchars($l['id']); ?>" class="btn btn-delete">Supprimer</a>
            </div>
        <?php } ?>
    </div>

</main>
<?php
include "footer.php";
?>