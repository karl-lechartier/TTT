<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);



if (isset($_POST['valider'])) {
    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $mail = filter_input(INPUT_POST, "mail");
    $adress = filter_input(INPUT_POST, "adress");
    $postalcode = filter_input(INPUT_POST, "postalcode");
    $city = filter_input(INPUT_POST, "city");
    $password = filter_input(INPUT_POST, "password");
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $requete = $pdo->prepare("insert into user (id, name, lastname, mail, adress, postalcode, city, points, subscription, password) VALUES (NULL, :name, :lastname, :mail, :adress, :postalcode, :city, 0, 0, :password)");
    $requete->bindParam(':name', $name);
    $requete->bindParam(':lastname', $lastname);
    $requete->bindParam(':mail', $mail);
    $requete->bindParam(':adress', $adress);
    $requete->bindParam(':postalcode', $postalcode);
    $requete->bindParam(':city', $city);
    $requete->bindParam(':password', $passwordHash);
    $requete->execute();

    $_SESSION['mdp'] = $password;
    header('location: index.php');
}
?>
<main>
    <form action="create_login.php" method="post">
        <label for="name">Prénom :</label>
        <input type="text" id="name" name="name" required placeholder="Krarkl">
        <label for="lastname">Nom :</label>
        <input type="text" id="lastname" name="lastname" required placeholder="Lechartier">
        <label for="mail">Mail :</label>
        <input type="email" id="mail" name="mail" required placeholder="krarlk@mail.fr">
        <label for="adress">Adresse :</label>
        <input type="text" id="adress" name="adress" required placeholder="4 route de Krakrl">
        <label for="postalcode">Code postal :</label>
        <input type="text" id="postalcode" name="postalcode" required placeholder="44000">
        <label for="city">Ville :</label>
        <input type="text" id="city" name="city" required placeholder="Nantes">
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required placeholder="password">
        <input type="submit" value="Valider" name="valider">
    </form>
</main>
<?php
include "footer.php";
?>