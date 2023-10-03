<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

session_start();

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
                $_SESSION['mdp'] = $password_saisi;
                header('location: index.php');
            } else {
                echo "Votre pseudo et/ou mot de passe sont incorrect.";
            }
        }
    }
}

?>
<main>
    <form action="login.php" method="post">
        <label for="mail">Adresse mail :</label>
        <input type="email" required id="mail" name="mail" placeholder="krarlk@mail.fr">
        <label for="password">Mot de passe</label>
        <input type="password" required id="password" name="password" placeholder="password">
        <input type="submit" value="Valider" name="valider">
    </form>
    <a href="create_login.php">Créer un compte</a>
</main>
<?php
include "footer.php"
?>