<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (isset($_POST['supp'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id = $_SESSION['user']['id'];
    echo "prout";
    $requete = $pdo->prepare("DELETE from code where id_user = :id_user");
    $requete->bindParam(":id_user", $id);
    $requete->execute();
    echo "pipi";
    $requete = $pdo->prepare("DELETE FROM user where id=:id");
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
    <div class="button-ajout-magasin-container">
        <form action="deleteAccount.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input class="button" type="submit" value="Valider la suppression" name="supp">
        </form>
    </div>
</main>
<?php
include "footer.php"?>