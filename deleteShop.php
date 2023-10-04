<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

$id = filter_input(INPUT_GET, "id");

if (isset($_POST['supp'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id = filter_input(INPUT_POST, "id");

    $requete = $pdo->prepare("DELETE FROM `user_shop` WHERE id_shop=:id");
    $requete->bindParam(":id", $id);
    $requete->execute();

    $requete = $pdo->prepare("SELECT photo FROM `shop` WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->execute();

    $requete = $pdo->prepare("DELETE FROM `shop` WHERE id=:id");
    $requete->bindParam(":id", $id);
    $requete->execute();

    $_SESSION = array();
    session_destroy();
    header('location: index.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
    <main>
        <form action="deleteAccount.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="submit" value="Valider la suppression" name="supp">
        </form>
    </main>
<?php
include "footer.php" ?>