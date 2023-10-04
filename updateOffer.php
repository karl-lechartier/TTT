<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

$id = $_GET['id'];

if (isset($_POST['modify'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $title = filter_input(INPUT_POST, "title");
    $description = filter_input(INPUT_POST, "description");
    $date_start = filter_input(INPUT_POST, "date_start");
    $date_end = filter_input(INPUT_POST, "date_end");
    $points = filter_input(INPUT_POST, "points");

    $requete = $pdo->prepare("UPDATE `offer` SET title = :title, description = :description, date_start = :date_start, date_end = :date_end, points = :points WHERE id = :id");
    $requete->bindParam(":title",$title);
    $requete->bindParam(":description",$description);
    $requete->bindParam(":date_start",$date_start);
    $requete->bindParam(":date_end",$date_end);
    $requete->bindParam(":points",$points);
    $requete->bindParam(":id",$id);
    $requete->execute();

    header('location: managed-shop.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
<main>
    <?php
    $requete = $pdo->prepare("select * from offer WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
    <form action="updateOffer.php?id=<?php echo $l['id']?>" method="post">
        <input type="hidden" name="token" value="<?php echo $token ?>">
        <label for="title">Titre </label>
        <input type="text" id="title" name="title" value="<?php echo $l['title'] ?>" required >
        <label for="description">Description </label>
        <textarea name="description" id="description" cols="30" rows="10" required><?php echo $l['description'] ?></textarea>
        <label for="date_start">Date de début </label>
        <input type="datetime-local" id="date_start" name="date_start" value="<?php echo $l['date_start'] ?>" required>
        <label for="date_end">Date de fin </label>
        <input type="datetime-local" id="date_end" name="date_end" value="<?php echo $l['date_end'] ?>" required>
        <label for="points">Points </label>
        <input type="number" value="<?php echo $l['points'] ?>" id="points" name="points" required>
        <input type="submit" value="Modifier" name="modify" id="modify">
    </form>
        <?php } ?>
</main>

<?php
include "footer.php";
?>