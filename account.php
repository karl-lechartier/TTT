<?php
include "header.php";

include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (isset($_POST['valider'])) {
    $token = filter_input(INPUT_POST, "token");
    if ($token != $_SESSION["token"]) {
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

$now = DateTime::createFromFormat('U.u', microtime(true));

srand($now->format("Hisu"));
$random = rand();

$requete = $pdo->prepare("select COUNT(*) as total from code WHERE id_user = :id_user");
$requete->bindParam(':id_user', $_SESSION['user']['id']);
$requete->execute();
$lignes = $requete->fetchAll();

foreach ($lignes as $l) {
    if ($l['total'] == 0) {

        $requete2 = $pdo->prepare("select COUNT(*) as total from code WHERE code = :code");
        $requete2->bindParam(':code', $random);
        $requete2->execute();
        $lignes2 = $requete2->fetchAll();

        foreach ($lignes2 as $l2) {
            if ($l2['total'] == 0) {
                $requete3 = $pdo->prepare("insert into code (id, code, id_user) VALUES (NULL, :code, :id_user)");
                $requete3->bindParam(':code', $random);
                $requete3->bindParam(':id_user', $_SESSION['user']['id']);
                $requete3->execute();
            }
        }
    }
}
?>

<main class="main-account">
    <?php
    $requete = $pdo->prepare("select * from code WHERE id_user = :id_user");
    $requete->bindParam(":id_user", $_SESSION['user']['id']);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
        <h1><?php echo $l['code'] ?></h1>
    <?php
    }
    $requete = $pdo->prepare("select * from user WHERE id = :id");
    $requete->bindParam(':id', $_SESSION['user']['id']);
    $requete->execute();
    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
            <p>Bienvenue <?php echo $l['name'] ?></p>
    <p class="points">Vous avez <?php echo $l['points'] ?> Gigaldi Coins</p>
    <?php if ($_SESSION['user']['subscription'] == 1) { ?>
        <p>Abonnement Premium</p>
        <a href="subscriptionUser.php">Se désabonner</a>
    <?php } else { ?><a href="subscriptionUser.php">S'abonner</a><?php } ?>
    <button type="button" onclick="toggleDisplay()">Modifier vos informations</button>
    <form action="account.php" method="post" id="userForm">
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
        <input type="checkbox" id="pro" name="pro" <?php if ($l['pro'] == 1) {
            echo "checked";
        } ?> >
        <input type="submit" value="Sauvegarder" name="valider" id="valider">
    </form>
        <?php if ($l['pro'] == 1) { ?>
        <a href="managed-shop.php">Voir mes magasins</a>
        <?php }
    } ?>
    <a href="logout.php">Se déconnecter</a>
    <a href="deleteAccount.php">Supprimer son compte</a>
</main>
<script>
    function toggleDisplay() {
        var form = document.getElementById("userForm");

        if (form.style.display === 'none' || form.style.display === '') {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    }

</script>


</script>
<?php
include "footer.php";
?>
