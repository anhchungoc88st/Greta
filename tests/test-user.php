<?php

if(!isset($_SESSION)){
    session_start();
    $_SESSION['connected'] = false;
}

require_once('../conf.php');
require_once('../controllers/helpers.php');
require_once('../models/functions_users.php');

//fonction d'insertion
$_POST = array();
$_POST['login'] = 'test';
$_POST['email'] = 'test@test.com';
$_POST['password'] = '12345';
$_POST['nom'] = 'Degrave';
$_POST['prenom'] = 'Arnaud';
$_POST['naissance'] = '11/09/1988';
$_POST['tel'] = '0660603020';
$_POST['sexe'] = 0;
$_POST['adresse'] = '11 avenue jean paul';
$_POST['postal'] = '06150';
$_POST['ville'] = 'Cannes';
//$id = adduser('admin'); //pour ajouter un admin
$id = adduser(); //pour ajouter un utilisateur normal

if(!$id) die('Erreur lors de l\'ajout');

//fonction récupération d'un utilisateur
$userinfo = getUser($id);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($userinfo);

//fonction modification
$_POST['ville'] = 'Mandelieu'; //on change une valeur
$update = updateUser($id);
if(!$update) die('Modification impossible');

//fonction récupération d'un utilisateur
$userinfo = getUser($id);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($userinfo);

//fonction de connexion
$_POST['login'] = 'test';
$_POST['password'] = '12345';
login();

//fonction is_connected
if(is_connected()) echo'Utilisateur connecté'; 
else die('Utilisateur non connecté');

//fonction is_admin
if(is_admin()) echo'Utilisateur admin'; else echo'Utilisateur normal';

//fonction logout
logout();

//fonction is_connected
if(is_connected()) die('Erreur lors du logout'); else echo 'Utilisateur déconnecté';

//fonction suppression d'un utilisateur
$deleted = deleteUser($id);
if(!$deleted) die('Suppression utilisateur impossible'); else echo 'Utilisateur supprimé';

//fonction récupération de tous les utilisateurs
$tab = getUsers();
print_r($tab);

?>