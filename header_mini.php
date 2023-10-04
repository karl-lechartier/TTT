<?php
session_start();
if (!isset($_SESSION['user'])){
    $_SESSION['user']['id'] = null;
    $_SESSION['user']['name'] = null;
    $_SESSION['user']['lastname'] = null;
    $_SESSION['user']['mail'] = null;
    $_SESSION['user']['adress'] = null;
    $_SESSION['user']['postalcode'] = null;
    $_SESSION['user']['city'] = null;
    $_SESSION['user']['points'] = null;
    $_SESSION['user']['subscription'] = null;
    $_SESSION['user']['pro'] = null;
    $_SESSION['error'] = null;
}
$title="Gigaldi"
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $title ?></title>
<link rel="stylesheet" href="scss/main.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@300;400;500;600;700&family=Lobster+Two:wght@400;700&display=swap" rel="stylesheet"><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css"
          integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <link rel="script" href="script.js">
    <link rel="icon" href="img/logo-ttt.png">
</head>