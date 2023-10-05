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

    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $name = filter_input(INPUT_POST, "name");
    $adress = filter_input(INPUT_POST, "adress");
    $category = filter_input(INPUT_POST, "category");
    $photo = $_FILES["photo"];

    $nomOriginal = basename($photo["name"]);

    $emplacementTemporaire = $photo["tmp_name"];

    $nomIMG  = "";

    $requete = $pdo->prepare("insert into shop (id, name, adress,category, photo) VALUES (NULL, :name, :adress, :category, :photo)");
    $requete->bindParam(':name', $name);
    $requete->bindParam(':adress', $adress);
    $requete->bindParam(':category', $category);
    $requete->bindParam(':photo', $nomIMG);
    $requete->execute();

    $id = $pdo->lastInsertId();

    $est_proprio = 1;

    //INSERT INTO `user_shop` (`id_user`, `id_shop`, `est_proprio`) VALUES ('6', '13', '1');
    $requete = $pdo->prepare("INSERT INTO `user_shop` (`id_user`, `id_shop`, `est_proprio`) VALUES (:id_user, :id_shop, :est_proprio)");
    $requete->bindParam(':id_user', $_SESSION['user']['id']);
    $requete->bindParam(':id_shop', $id);
    $requete->bindParam(':est_proprio', $est_proprio);
    $requete->execute();

    $nomIMG = $id."-".$nomOriginal;
    move_uploaded_file($photo["tmp_name"], "img/$nomIMG");

    $requete = $pdo->prepare("update shop set photo=:photo where id=:id");
    $requete->bindParam(":photo", $nomIMG);
    $requete->bindParam(":id", $id);
    $requete->execute();

    header('location: managed-shop.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>
    <main>
        <h1 class="titre">Ajouter un magasin</h1>
        <form action="ajout_magasin.php" method="post" enctype="multipart/form-data" class="login-form">
            <input type="hidden" name="token" value="<?php echo $token ?>">

            <label for="name" class="form-label">Nom du magasin</label>
            <input type="text" id="name" name="name" required class="form-input">

            <label for="adress" class="form-label">Adresse du magasin</label>
            <input type="text" id="adress" name="adress" required class="form-input">

            <label for="category" class="form-label">Catégorie</label>
            <input type="text" id="category" name="category" required class="form-input">

            <label for="photo" class="form-label">Photo du magasin</label>
            <input type="file" id="photo" name="photo" enctype="multipart/form-data" accept=".jpg, .jpeg, .png" required class="form-input">

            <input type="submit" value="Ajouter au magasin" name="valider" class="submit-button">
        </form>
    </main>
<?php
include "footer.php";
?>