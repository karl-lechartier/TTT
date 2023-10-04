<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}


$id = $_GET['shop'];

if (isset($_POST['modify'])) {

    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $name = filter_input(INPUT_POST, "name");
    $adress = filter_input(INPUT_POST, "adress");
    $category = filter_input(INPUT_POST, "category");
    $photo = $_FILES["photo"];

    $requete = $pdo->prepare("select * from shop WHERE id = :id");
    $requete->bindParam(":id", $id);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
        $nomImgDB = $l['photo'];
    }
    $nomOriginal = basename($photo["name"]);
    $nomIMG = $id."-".$nomOriginal;

    if ( $nomIMG != $nomImgDB and $nomIMG != $id."-"){
        $requete = $pdo->prepare("UPDATE `shop` SET name = :name, adress = :adress, category = :category, photo = :photo WHERE id = :id");
        $requete->bindParam(":name",$name);
        $requete->bindParam(":adress",$adress);
        $requete->bindParam(":category",$category);
        $requete->bindParam(":photo",$nomOriginal);
        $requete->bindParam(":id",$id);
        $requete->execute();
        move_uploaded_file($photo["tmp_name"], "img/$nomIMG");
    }else {
        $requete = $pdo->prepare("UPDATE `shop` SET name = :name, adress = :adress, category = :category WHERE id = :id");
        $requete->bindParam(":name",$name);
        $requete->bindParam(":adress",$adress);
        $requete->bindParam(":category",$category);
        $requete->bindParam(":id",$id);
        $requete->execute();
    }

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
                <input type="file" id="photo" name="photo" value="<?php echo $l['photo'] ?>">
                <input type="submit" value="Modifier" name="modify" id="modify">
            </form>
        <?php } ?>
    </main>

<?php
include "footer.php";
?>