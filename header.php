<?php
include "header_mini.php";
?>
<body>
<nav>
    <nav>
        <div class="nav-header">
            <a href="index.php" class="home">
                <div class="icone">
                    <img src="img/logo-ttt.png" alt="Logo">
                </div>
                <div class="nav-title">
                    <h1>Gigaldi</h1>
                </div>
            </a>
        </div>
        <div style="display: flex">
            <?php if ($_SESSION['user']['pro']) {?>
            <div class="qr-container">
                <a href="proprioAddPoints.php">
                    <i class="fa-solid fa-qrcode"></i>
                </a>
            </div>
            <?php } ?>
            <div class="nav-account">
                <a href="login.php">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>

    </nav>

</nav>
<header>
</header>