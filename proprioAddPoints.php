<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (!$_SESSION['user']['pro']) {
    header ("location: account.php");
}

if (isset($_POST['valider'])) {
    $token = filter_input(INPUT_POST, "token");
    if ($token != $_SESSION["token"]) {
        die("Erreur de Token");
    }

    $code = filter_input(INPUT_POST, "code");
    $points = filter_input(INPUT_POST, "points");
    $pointsDouble = $points * 2;

    $requete = $pdo->prepare("Select * from code WHERE code = :code");
    $requete->bindParam(":code", $code);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
        $requete2 = $pdo->prepare("Select * from user WHERE id = :id");
        $requete2->bindParam(":id", $l['id_user']);
        $requete2->execute();
        $lignes2 = $requete2-> fetchAll();

        foreach ($lignes2 as $l2) {
            if ($l2['subscription'] == 1) {
                $p = $l2['points'] + $pointsDouble;
                $requete3 = $pdo->prepare("Update user SET points = :points WHERE id = :id");
                $requete3->bindParam(":points", $p);
                $requete3->bindParam(":id", $l['id_user']);
                $requete3->execute();
            } else {
                $p = $l2['points'] + $points;
                $requete3 = $pdo->prepare("Update user SET points = :points WHERE id = :id");
                $requete3->bindParam(":points", $p);
                $requete3->bindParam(":id", $l['id_user']);
                $requete3->execute();
            }
        }
    }

    $requete = $pdo->prepare("Delete from code WHERE code = :code");
    $requete->bindParam(":code", $code);
    $requete->execute();

    header("location: managed-shop.php");
}
$token = uniqid();
$_SESSION["token"] = $token;
?>
<main>
    <h1 class="titre">Ajouter des points</h1>
    <form action="proprioAddPoints.php" method="post" class="login-form">
        <input type="hidden" name="token" id="token" value="<?php echo $token ?>">

        <label for="code" class="form-label">Code client </label>
        <input type="number" id="code" name="code" required class="form-input">

        <label for="points" class="form-label">Points gagnés </label>
        <input type="number" id="points" name="points" required class="form-input">

        <input type="submit" id="valider" name="valider" value="Valider" class="button">
    </form>
</main>
<?php
include "footer.php";
?>