<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id_shop = $_GET['id_shop'];

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

if (isset($_POST['valider'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $date_start = filter_input(INPUT_POST, "date_start");
    $date_end = filter_input(INPUT_POST, "date_end");
    $points = filter_input(INPUT_POST, "points");
    $shop = filter_input(INPUT_POST, "shop");

    if ($date_end > $date_start) {
        $requete = $pdo->prepare("INSERT INTO offer (id, title, description, date_start, date_end, points, shop_id) VALUES (NULL, :title, :description, :date_start, :date_end, :points, :shop_id)");
        $requete->bindParam(":title",$title);
        $requete->bindParam(":description",$description);
        $requete->bindParam(":date_start",$date_start);
        $requete->bindParam(":date_end",$date_end);
        $requete->bindParam(":points",$points);
        $requete->bindParam(":shop_id",$shop);
        $requete->execute();

        header('location: managed-shop.php');
    } else {
        die("La date de fin ne peut pas être égal ou plus petite que la date de début");
    }
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
    <main>
        <h1>Ajouter une offre</h1>
        <form action="addOffer.php" method="post" class="login-form">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <input class="form-input" type="hidden" name="shop" value="<?php echo $id_shop ?>">

            <label class="form-label" for="title">Titre </label>
            <input class="form-input" type="text" id="title" name="title" required>

            <label class="form-label" for="description">Description </label>
            <textarea class="form-input" name="description" id="description" cols="30" rows="10" required></textarea>

            <label class="form-label" for="date_start">Date de début </label>
            <input class="form-input" type="datetime-local" id="date_start" name="date_start" required>

            <label class="form-label" for="date_end">Date de fin </label>
            <input class="form-input" type="datetime-local" id="date_end" name="date_end" required>

            <label class="form-label" for="points">Points </label>
            <input class="form-input" type="number" id="points" name="points" required>

            <input type="submit" value="Valider" name="valider" id="valider" class="button">
        </form>
    </main>

<?php
include "footer.php";
?>