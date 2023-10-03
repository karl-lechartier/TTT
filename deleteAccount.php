<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (isset($_POST['supp'])) {
    $id = $_SESSION['user']['id'];

    $requete = $pdo->prepare("DELETE FROM user where id=:id");
    $requete->bindParam(":id", $id);
    $requete->execute();

    $_SESSION = array();
    session_destroy();
    header('location: index.php');
}
?>
<main>
    <form action="deleteAccount.php" method="post">
        <input type="submit" value="Valider la suppression" name="supp">
    </form>
</main>
<?php
include "footer.php"?>