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

    $title = filter_input(INPUT_POST, "name");
    $description = filter_input(INPUT_POST, "adress");
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
        $requete = $pdo->prepare("select * from shop WHERE id = :id");
        $requete->bindParam(":id", $id);
        $requete->execute();
        $lignes = $requete->fetchAll();

        foreach ($lignes as $l) {
            ?>
            <form action="updateShop.php?shop=<?php echo $l['id'] ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="token" value="<?php echo $token ?>">
                <label for="name" >Nom du magasin</label>
                <input type="text" id="name" name="name" value="<?php echo $l['name'] ?>" required>
                <label for="adress">Adresse du magasin</label>
                <input type="text" id="adress" name="adress" value="<?php echo $l['adress'] ?>" required>
                <label for="category">Catégorie</label>
                <input type="text" id="category" name="category" value="<?php echo $l['category'] ?>" required>
                <label for="photo">Photo du magasin</label>
                <input type="file" id="photo" name="photo" value="<?php echo $l['photo'] ?>" required>
                <input type="submit" value="Modifier" name="modify" id="modify">
            </form>
        <?php } ?>
    </main>

<?php
include "footer.php";
?>