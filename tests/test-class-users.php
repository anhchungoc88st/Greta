<?php


if(!isset($_SESSION)) {
    session_start();
    $_SESSION['connected'] = false;
}

require_once('../config.php');
require_once('../controllers/helpers.php');
require_once('../models/class_db.php');
require_once('../models/class_users.php');

// fonction d'insertion
$_POST = array();
$_POST['login'] = 'test';
$_POST['email'] = 'test@test.com';
$_POST['password'] = '12345';
$_POST['nom'] = 'Moutacharrif';
$_POST['prenom'] = 'Widad';
$_POST['naissance'] = '20/02/1990';
$_POST['tel'] = '0601020301';
$_POST['sexe'] = 1;
$_POST['adresse'] = '2, vieux chemin de la colle';
$_POST['postal'] = '06160';
$_POST['ville'] = 'Antibes';


$user = new User(); // Instance de la classe User dans un objet $user


//$id = adduser('admin'); // pour ajouter un utilisateur admin
$id = $user->add(); // pour ajouter un utilisateur non admin


if(!$id) die('Erreur lors de l\'ajout');

//fonction récupération d'un utilisateur
$userinfo = $user->getById($id);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($userinfo);

//fonction modification
$_POST['postal'] = '06400';
$_POST['ville'] = 'Cannes';
$update = $user->update($id);
if(!$update) die('Erreur lors de la modification');
print_r($update);

//fonction récupération d'un utilisateur
$userinfo = $user->getById($id);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($userinfo);

//fonction connexion
$_POST['login'] = 'test';
$_POST['password'] = '12345';
$user->login();

//fonction is_connected
if(User::is_connected()) echo 'Utilisateur connecté';
else die ('Utilisateur non connecté');

//fonction is_admin
if(User::is_admin()) echo 'Utilisateur admin';
else echo 'Utilisateur non admin';

//fonction Logout
User::logout();

//fonction is_connected
if(User::is_connected()) die('Erreur lors du logout');
else echo ('Utilisateur déconnecté');

//fonction récupération de tous les utilisateurs
$tab = $user->getAll();
print_r($tab);


//fonction récupération d'un utilisateur
$userinfo = $user->getByName($_POST['nom']);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($userinfo);




//fonction envoie URL pour réinisialiser le mot de passe
$mail = $user->forgetPwd($_POST['email']);
if(!$mail) die('Erreur lors de l\'envoie du message');


$userinfo = $user->getById($id);
if(!$userinfo) die('Erreur lors de la récupération d\'un utilisateur');
echo $userinfo['token'];


//fonction envoie URL pour réinisialiser le mot de passe
$reset = $user->resetPass('nouveau_mdp',$userinfo['token']);
if(!$reset) die('Erreur lors du reset du mdp');




//fonction suppression d'un utilisateur
$deleted = $user->delete($id);
if(!$deleted) die('Suppression utilisateur impossible');
else echo 'Utilisateur supprimé';

?>
