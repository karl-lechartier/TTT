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
    <script>
        function toggleReadonly() {
            var name = document.getElementById("name");
            name.readOnly = !name.readOnly;
            var lastname = document.getElementById("lastname");
            lastname.readOnly = !lastname.readOnly;
            var mail = document.getElementById("mail");
            mail.readOnly = !mail.readOnly;
            var adress = document.getElementById("adress");
            adress.readOnly = !adress.readOnly;
            var postalcode = document.getElementById("postalcode");
            postalcode.readOnly = !postalcode.readOnly;
            var city = document.getElementById("city");
            city.readOnly = !city.readOnly;
            var pro = document.getElementById("pro");
            pro.disabled = !pro.disabled;
            var valider = document.getElementById("valider");
            valider.disabled = !valider.disabled;
        }
    </script>
    <?php
    $requete = $pdo->prepare("select * from user WHERE id = :id");
    $requete->bindParam(':id', $_SESSION['user']['id']);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
    <p>Points : <?php echo $l['points'] ?></p>
    <?php if($_SESSION['user']['subscription'] == 1) {?>
        <p>Abonnement Premium</p>
        <a href="subscriptionUser.php">Se désabonner</a>
    <?php } else { ?><a href="subscriptionUser.php">S'abonner</a><?php } ?>
    <br>
    <button type="submit" onclick="toggleReadonly()" >Modifier</button>
    <form action="account.php" method="post">
            <input type="hidden" name="id" value="<?php echo $l["id"] ?>">
            <input type="hidden" name="token" value="<?php echo $token ?>">
            <label for="name">Prénom :</label>
            <input type="text" id="name" name="name" required value="<?php echo $l['name'] ?>" readonly>
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required value="<?php echo $l['lastname'] ?>" readonly>
            <label for="mail">Mail :</label>
            <input type="email" id="mail" name="mail" required value="<?php echo $l['mail'] ?>" readonly>
            <label for="adress">Adresse :</label>
            <input type="text" id="adress" name="adress" required value="<?php echo $l['adress'] ?>" readonly>
            <label for="postalcode">Code postal :</label>
            <input type="text" id="postalcode" name="postalcode" required value="<?php echo $l['postalcode'] ?>" readonly>
            <label for="city">Ville :</label>
            <input type="text" id="city" name="city" required value="<?php echo $l['city'] ?>" readonly>
            <label for="pro">Est professionnel :</label>
            <input type="checkbox" id="pro" name="pro" <?php if ($l['pro'] == 1) {echo "checked"; } ?> disabled>
            <input type="submit" value="Sauvegarder" name="valider" id="valider" disabled>
        <?php } ?>
    </form>
    <a href="logout.php">Se déconnecter</a>
    <a href="deleteAccount.php">Supprimer son compte</a>
</main>
<?php
include "footer.php";
?>
