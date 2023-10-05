<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id = $_GET['id'];

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (!$_SESSION['user']['pro']) {
    header ("location: account.php");
}

$requete = $pdo->prepare("Select * from user_shop WHERE id_shop = :id_shop");
$requete->bindParam("id_shop", $id);
$requete->execute();
$lignes = $requete->fetchAll();
foreach ($lignes as $l) {
    if ($_SESSION['user']['id'] != $l['id_user']) {
        header ("location: account.php");
    }
}

if (isset($_POST['supp'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id_offer = filter_input(INPUT_POST, "id_offer");

    $requete = $pdo->prepare("DELETE FROM offer where id=:id");
    $requete->bindParam(":id", $id_offer);
    $requete->execute();

    header('location: managed-shop.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
    <main>
        <form action="deleteOffer.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input type="hidden" name="id_offer" value="<?php echo $id ?>">
            <input type="submit" value="Valider la suppression" name="supp">
        </form>
    </main>
<?php
include "footer.php";
?>