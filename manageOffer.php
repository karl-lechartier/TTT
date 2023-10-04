<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

$id_shop = $_GET['shop'];
?>
<main>
    <a href="addOffer.php?id_shop=<?php echo $id_shop?>">Ajouter une offre</a>
    <?php
    $requete = $pdo->prepare("select * from offer WHERE shop_id = :shop_id");
    $requete->bindParam(":shop_id", $id_shop);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
        ?>
            <table>
                <tr>
                    <td><?php echo $l['title'] ?></td>
                    <td><?php echo $l['description'] ?></td>
                    <td><?php echo $l['date_start'] ?></td>
                    <td><?php echo $l['date_end'] ?></td>
                    <td><?php echo $l['points'] ?></td>
                    <td><a href="updateOffer.php?id=<?php echo $l['id'] ?>">Modifier</a></td>
                    <td><a href="deleteOffer.php?id=<?php echo $l['id'] ?>">Supprimer</a></td>
                </tr>
            </table>
        <?php } ?>
</main>
<?php
include "footer.php";
?>