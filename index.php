<?php
$title = "Gigaldi";
include "header.php";
include_once "config.php";
$pdo = new PDO("mysql:host=" . Config::SERVEUR . "; dbname=" . Config::BDO, Config::UTILISATEUR, Config::MOTDEPASSE);
?>

<body>
<main>
    <?php
    if ($_SESSION['user']['id'] != null ) {
        echo "<h1 class='nom'>Bonjour, ".$_SESSION['user']['name']."</h1>";
    }
    ?>

    <div class="searchbar">
        <form action="?" method="get">
            <input type="text" id="searchInput" name="query" placeholder="Recherche sur Gigaldi...">
        </form>
    </div>


    <div class="card-deck">
    <?php
    $query = "";
    var_dump($query);
    $query = $_GET['query'];
    var_dump($query);

    if ($query==""){
        echo "if";
        $requete = $pdo->prepare("select * from shop LIMIT 30");
        $requete->execute();
    } else {
        echo "else";
        $query = "'%".$query."%'";
        echo '<br>';
        echo $query;
        $requete = $pdo->prepare("SELECT * FROM shop WHERE name LIKE :query");
        $requete->bindParam(':query', $query);
        var_dump($requete);
        $requete->execute();
    }


    $lignes = $requete->fetchAll();

    foreach ($lignes as $l) {
    ?>
            <div class="card-container">
                <a class="magasin no-link-style" href="shop.php?id=<?php echo $l['id'] ?>">
                    <div class="card">
                        <img class="card-img-top" src="img/<?php echo $l['photo']?>" alt="Card image cap">
                        <div class="card-body">
                            <h2 class="card-title"><?php echo $l['name']?></h2>
                            <p class="card-text"><?php echo $l['category']?></p>
                            <p class="card-text"><small class="text-muted"><?php echo $l['adress']?></small></p>
                        </div>
                    </div>
                </a>
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