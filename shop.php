<?php
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);

$id = $_GET['id'];
?>
    <main class="shop">
        <?php
        $requete = $pdo->prepare("select * from shop WHERE id = :id");
        $requete->bindParam(":id", $id);
        $requete->execute();
        $lignes = $requete->fetchAll();

        foreach ($lignes as $l) {
            ?>
            <img src="img/<?php echo $l['photo'] ?>" alt="IMG photo shop">
            <div class="container-shop">
                <h1><?php echo $l['name'] ?></h1>
                <p class="category"><?php echo $l['category'] ?></p>
                <p class="adress"><i><?php echo $l['adress'] ?></i></p>
            </div>
        <?php }
        $requete = $pdo->prepare("select * from offer WHERE shop_id = :shop_id");
        $requete->bindParam(":shop_id", $id);
        $requete->execute();
        $lignes = $requete->fetchAll();
        ?>
        <h2>Les offres :</h2>
        <br>
        <div class="cards-container">
            <?php foreach ($lignes as $l) { ?>
                <div class="card">
                    <h2><?php echo htmlspecialchars($l['title']); ?></h2>
                    <p><b>Description :</b></p>
                    <p><?php echo htmlspecialchars($l['description']); ?></p>
                    <br>
                    <p><b>Disponible dans l'intervalle</b></p>
                    <p><?php echo htmlspecialchars($l['date_start']); ?></p>
                    <p><?php echo htmlspecialchars($l['date_end']); ?></p>
                    <br>
                    <h4>Cette offre coute <?php echo htmlspecialchars($l['points']); ?> points.</h4>
                </div>
            <?php } ?>
        </div>


    </main>
<?php
include "footer.php";
?>