<?php

//on initialise une session si celle-ci n'existe pas
if(!isset($_SESSION)){
    session_start();
    if(!isset($_SESSION['connected'])) $_SESSION['connected'] = 0;
}

//on inclut le fichier de configuration
require_once('conf.php');

//on inclut le fichier de connexion à la BDD
require_once('models/class_db.php');

//on inclut le fichier des helpers
require_once('controllers/helpers.php');

//on inclut notre contrôleur général
require_once('controllers/mainController.php');

//on inclut les fonctions utilisateur
require_once('models/functions_users.php');
require_once('models/class_users.php');

require_once('models/class_annonces.php');
require_once('models/class_categories.php');



//déconnexion de l'utilisateur
if(isset($_GET['logout']) /*&& $_GET['logout'] == "true" && User::is_connected()*/){
    User::logout();
    echo'<script>alert("Vous êtes déconnecté");</script>';
}

//on inclut le header
include('views/header.php');

$is_connected = User::is_connected();
//$is_connected = true;

//on inclut le corps de page
if(empty($_GET['p'])) include('views/home.php');
elseif(!$is_connected){
    if($_GET['p'] == 'login') include('views/utilisateurs/login.php');
    elseif($_GET['p'] == 'register') include('views/utilisateurs/register.php');
    elseif($_GET['p'] == 'forget-pwd') include('views/utilisateurs/forget_password.php');
    elseif($_GET['p'] == 'reset-pwd') include('views/utilisateurs/reset_password.php');
    else include('views/errors/404.php');
}
elseif($is_connected){
    if($_GET['p'] == 'profile') include('views/utilisateurs/profile.php');
    elseif($_GET['p'] == 'update-profile') include('views/utilisateurs/update-profile.php');
    elseif($_GET['p'] == 'create-annonce') include('views/annonces/creation.php');
    elseif($_GET['p'] == 'update-annonce') include('views/annonces/modification.php');
    elseif($_GET['p'] == 'liste-annonces') include('views/annonces/liste.php');
    elseif($_GET['p'] == 'create-cat') include('views/categories/creation.php');
    elseif($_GET['p'] == 'update-cat') include('views/categories/modification.php');
    else include('views/errors/404.php');
}
else include('views/errors/404.php');

//on inclut le footer
include('views/footer.php');

?>