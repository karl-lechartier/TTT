<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (isset($_POST['sub'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id = $_SESSION['user']['id'];
    $subscription = 1;

    $requete = $pdo->prepare("UPDATE user SET subscription = :subscription WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->bindParam(":subscription", $subscription);
    $requete->execute();

    $_SESSION['user']['subscription'] = $subscription;
    header('location: account.php');
}

if (isset($_POST['unsub'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id = $_SESSION['user']['id'];
    $subscription = 0;

    $requete = $pdo->prepare("UPDATE user SET subscription = :subscription WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->bindParam(":subscription", $subscription);
    $requete->execute();

    $_SESSION['user']['subscription'] = $subscription;
    header('location: account.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
    <main>
        <form action="subscriptionUser.php" method="post">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <?php if ($_SESSION['user']['subscription'] == 0) {?>
                <input type="submit" value="S'abonner" name="sub">
            <?php } else {?>
                <input type="submit" value="Se désabonner" name="unsub">
            <?php } ?>
        </form>
    </main>
<?php
include "footer.php"?>