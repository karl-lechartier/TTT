<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (isset($_POST['valider'])) {
    $token=filter_input(INPUT_POST, "token");
    if($token!=$_SESSION["token"]){
        die("Erreur de Token");
    }

    $id = filter_input(INPUT_POST, "id");
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $mail = filter_input(INPUT_POST, "mail");
    $adress = filter_input(INPUT_POST, "adress");
    $postalcode = filter_input(INPUT_POST, "postalcode");
    $city = filter_input(INPUT_POST, "city");
    $pro = filter_input(INPUT_POST, "pro");

    if ($pro == "on") {
        $estPro = 1;
    } else {
        $estPro = 0;
    }

    $requete = $pdo->prepare("UPDATE `user` SET name = :name, lastname = :lastname, mail = :mail, adress = :adress, postalcode = :postalcode, city = :city, pro = :pro WHERE id = :id");
    $requete->bindParam(":name", $name);
    $requete->bindParam(":lastname", $lastname);
    $requete->bindParam(":mail", $mail);
    $requete->bindParam(":adress", $adress);
    $requete->bindParam(":postalcode", $postalcode);
    $requete->bindParam(":city", $city);
    $requete->bindParam(":pro", $estPro);
    $requete->bindParam(":id", $id);
    $requete->execute();

    $_SESSION['user']['name'] = $name;
    $_SESSION['user']['lastname'] = $lastname;
    $_SESSION['user']['mail'] = $mail;
    $_SESSION['user']['adress'] = $adress;
    $_SESSION['user']['postalcode'] = $postalcode;
    $_SESSION['user']['city'] = $city;
    $_SESSION['user']['pro'] = $estPro;
    header('location: account.php');
}

$token = uniqid();
$_SESSION["token"] = $token;
?>

<main>
    <form action="account.php" method="post">
        <?php
        $requete = $pdo->prepare("select * from user WHERE id = :id");
        $requete->bindParam(':id', $_SESSION['user']['id']);
        $requete->execute();
        $lignes = $requete->fetchAll();

        foreach ($lignes as $l) {
        ?>
            <input type="hidden" name="id" value="<?php echo $l["id"] ?>">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <label for="name">Prénom :</label>
            <input type="text" id="name" name="name" required value="<?php echo $l['name'] ?>">
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required value="<?php echo $l['lastname'] ?>">
            <label for="mail">Mail :</label>
            <input type="email" id="mail" name="mail" required value="<?php echo $l['mail'] ?>">
            <label for="adress">Adresse :</label>
            <input type="text" id="adress" name="adress" required value="<?php echo $l['adress'] ?>">
            <label for="postalcode">Code postal :</label>
            <input type="text" id="postalcode" name="postalcode" required value="<?php echo $l['postalcode'] ?>">
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required value="<?php echo $l['city'] ?>">
            <label for="pro">Est professionnel :</label>
            <input type="checkbox" id="pro" name="pro" <?php if ($l['pro'] == 1) {echo "checked"; } ?>>
            <input type="submit" value="Sauvegarder" name="valider" >
        <?php } ?>
    </form>
    <a href="logout.php">Se déconnecter</a>
    <a href="deleteAccount.php">Supprimer son compte</a>
</main>
<?php
include "footer.php";
?>
