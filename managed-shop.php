<?php
$title = "Gigaldi";
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

if (!$_SESSION['user']['id']) {
    header('location: index.php');
}

if (!$_SESSION['user']['pro']) {
    header ("location: account.php");
}
?>

    <body>
    <main>
        <div class="button-ajout-magasin-container">
            <a class="button" href="ajout_magasin.php">Ajouter un Magasin</a>
        </div>
        <div class="card-deck">
            <?php
            $requete = $pdo->prepare("SELECT shop.*, user_shop.est_proprio FROM shop JOIN user_shop ON shop.id = user_shop.id_shop WHERE user_shop.id_user=:id_user");
            $requete->bindParam(':id_user', $_SESSION['user']['id']);
            $requete->execute();
            $lignes = $requete->fetchAll();

            foreach ($lignes as $l) {
                ?>
                    <div class="card-container">
                        <div class="card">
                            <a class="magasin no-link-style" href="shop.php?id=<?php echo $l['id'] ?>">
                                <img class="card-img-top" src="img/<?php echo $l['photo']?>" alt="Card image cap">
                                <div class="card-body">
                                    <h2 class="card-title"><?php echo $l['name']?></h2>
                                    <p class="card-text"><?php echo $l['category']?></p>
                                    <p class="card-text"><small class="text-muted"><?php echo $l['adress']?></small></p>
                                </div>
                            </a>
                            <div class="button-container">
                                <a class="button" href="deleteShop.php?shop=<?php echo $l['id'] ?>">Supprimer le magasin</a>
                                <a class="button" href="updateShop.php?shop=<?php echo $l['id'] ?>">Modifier les informations</a>
                                <a class="button" href="manageOffer.php?shop=<?php echo $l['id'] ?>">Gérer les offres</a>
                            </div>
                        </div>
                    </div>

                <?php
            }
            ?>
        </div>
    </main>
    </body>

<?php
include "footer.php";
?>