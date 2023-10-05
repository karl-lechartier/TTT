<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if ($_SESSION['user']['id']) {
    header('location: index.php');
}

if (isset($_POST['valider'])) {
    $token = filter_input(INPUT_POST, "token");
    if ($token != $_SESSION["token"]) {
        die("Erreur de Token");
    }

    $name = filter_input(INPUT_POST, "name");
    $lastname = filter_input(INPUT_POST, "lastname");
    $mail = filter_input(INPUT_POST, "mail");
    $adress = filter_input(INPUT_POST, "adress");
    $postalcode = filter_input(INPUT_POST, "postalcode");
    $city = filter_input(INPUT_POST, "city");
    $password = filter_input(INPUT_POST, "password");
    $pro = filter_input(INPUT_POST, "pro");

    if ($pro == "on") {
        $estPro = 1;
    } else {
        $estPro = 0;
    }

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);


    $requete2 = $pdo->prepare("SELECT COUNT(*) as total FROM user WHERE mail = :mail");
    $requete2->bindParam(":mail", $mail);
    $requete2->execute();
    $lignes = $requete2->fetchAll();

    foreach ($lignes as $l) {
        if ($l['total'] == 0) {
            $requete = $pdo->prepare("insert into user (id, name, lastname, mail, adress, postalcode, city, points, subscription, password, pro) VALUES (NULL, :name, :lastname, :mail, :adress, :postalcode, :city, 0, 0, :password, :pro)");
            $requete->bindParam(':name', $name);
            $requete->bindParam(':lastname', $lastname);
            $requete->bindParam(':mail', $mail);
            $requete->bindParam(':adress', $adress);
            $requete->bindParam(':postalcode', $postalcode);
            $requete->bindParam(':city', $city);
            $requete->bindParam(':password', $passwordHash);
            $requete->bindParam(':pro', $estPro);
            $requete->execute();

            $id = $pdo->lastInsertId();

            $_SESSION['user']['id'] = $id;
            $_SESSION['user']['name'] = $name;
            $_SESSION['user']['lastname'] = $lastname;
            $_SESSION['user']['mail'] = $mail;
            $_SESSION['user']['adress'] = $adress;
            $_SESSION['user']['postalcode'] = $postalcode;
            $_SESSION['user']['city'] = $city;
            $_SESSION['user']['points'] = 0;
            $_SESSION['user']['subscription'] = 0;
            $_SESSION['user']['pro'] = $estPro;
            header('location: index.php');
        } else {
            die("L'adresse mail a déjà été utilisée");
        }
    }
}
$token = uniqid();
$_SESSION["token"] = $token;

?>


    <main>
        <h1 class="titre">Créer un compte</h1>

        <form action="create_login.php" method="post" class="login-form">
            <input type="hidden" value="<?php echo $token ?>" name="token">

            <label for="name" class="form-label">Prénom :</label>
            <input type="text" id="name" name="name" required placeholder="Krarkl" class="form-input">

            <label for="lastname" class="form-label">Nom :</label>
            <input type="text" id="lastname" name="lastname" required placeholder="Lechartier" class="form-input">

            <label for="mail" class="form-label">Mail :</label>
            <input type="email" id="mail" name="mail" required placeholder="krarlk@mail.fr" class="form-input">

            <label for="adress" class="form-label">Adresse :</label>
            <input type="text" id="adress" name="adress" required placeholder="4 route de Krakrl" class="form-input">

            <label for="postalcode" class="form-label">Code postal :</label>
            <input type="number" id="postalcode" name="postalcode" required placeholder="44000" class="form-input">

            <label for="city" class="form-label">Ville :</label>
            <input type="text" id="city" name="city" required placeholder="Nantes" class="form-input">

            <label for="password" class="form-label">Mot de passe :</label>
            <input type="password" id="password" name="password" required placeholder="password" class="form-input">

            <div class="pro">
                <label for="pro" class="form-label">Êtes-vous professionnel ?</label>
                <div class="switch">
                    <input type="checkbox" id="pro" name="pro" class="form-input-checkbox">
                    <label for="pro" class="slider"></label>
                </div>
            </div>

            <input type="submit" value="Valider" name="valider" class="submit-button">
        </form>
        <div class="already-have-account">
            <h2>Vous avez déjà un compte?</h2>
            <a href="login.php" class="already-account-link">Se connecter</a>
        </div>
    </main>
<?php
include "footer.php";
?>