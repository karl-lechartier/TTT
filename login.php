<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if ($_SESSION['user']['id']) {
    header('location: account.php');
}

if (isset($_POST['valider'])) {
    if (!empty($_POST['mail']) AND !empty($_POST['password'])) {
        $mail_saisi = htmlspecialchars($_POST['mail']);
        $password_saisi = htmlspecialchars($_POST['password']);

        $requete = $pdo->prepare("select * from user WHERE mail = :mail");
        $requete->bindParam(':mail', $mail_saisi);
        $requete->execute();
        $lignes = $requete->fetchAll();

        foreach ($lignes as $l) {
            if (password_verify($password_saisi, $l['password'])) {
                $_SESSION['user']['id'] = $l["id"];
                $_SESSION['user']['name'] = $l["name"];
                $_SESSION['user']['lastname'] = $l["lastname"];
                $_SESSION['user']['mail'] = $l["mail"];
                $_SESSION['user']['adress'] = $l["adress"];
                $_SESSION['user']['postalcode'] = $l["postalcode"];
                $_SESSION['user']['city'] = $l["city"];
                $_SESSION['user']['points'] = $l["points"];
                $_SESSION['user']['subscription'] = $l["subscription"];
                $_SESSION['user']['pro'] = $l['pro'];
                header('location: index.php');
            } else {
                echo "Votre pseudo et/ou mot de passe sont incorrect.";
            }
        }
    }
}

?>
<main>
    <h1 class="titre">Se connecter</h1>

    <form action="login.php" method="post" class="login-form">
        <label for="mail" class="form-label">Adresse mail :</label>
        <input type="email" required id="mail" name="mail" placeholder="krarlk@mail.fr" class="form-input">

        <label for="password" class="form-label">Mot de passe</label>
        <input type="password" required id="password" name="password" placeholder="password" class="form-input">

        <input type="submit" value="Valider" name="valider" class="submit-button">
    </form>

    <div class="create-account">
        <h2>Vous n'avez pas encore de compte?</h2>
        <a href="create_login.php" class="create-account-link">Créer un compte</a>
    </div>

</main>
<?php
include "footer.php"
?>