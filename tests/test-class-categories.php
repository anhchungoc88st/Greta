<?php

if(!isset($_SESSION)){
    session_start();
    $_SESSION['connected'] = false;
}

require_once('../conf.php');
require_once('../controllers/helpers.php');
require_once('../models/class_db.php');
require_once('../models/class_categories.php');

//fonction d'insertion
$_POST = array();
$_POST['nom_cat'] = 'test';


$categorie = new Categories(); // instance de la classe catégories dans un objet $categorie




$id = $categorie->add(); //pour ajouter une catégorie

if(!$id) die('Erreur lors de l\'ajout');

//fonction récupération d'une catégorie
$categorieinfo = $categorie->getById($id);
if(!$categorieinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($categorieinfo);

//fonction modification
$_POST['nom_cat'] = 'Mandelieu'; //on change une valeur
$update = $categorie->update($id);
if(!$update) die('Modification impossible');

//fonction récupération d'une catégorie
$categorieinfo = $categorie->getById($id);
if(!$categorieinfo) die('Erreur lors de la récupération d\'un utilisateur');
print_r($categorieinfo);

//fonction récupération d'une catégorie par nom
$categorieByName = $categorie->getByName($_POST['nom_cat']);
if(!$categorieByName) die('Erreur lors de la récupération d\'une catégorie');
print_r($categorieByName);

//fonction suppression d'une catégorie
$deleted = $categorie->delete($id);
if(!$deleted) die('Suppression utilisateur impossible'); else echo 'Utilisateur supprimé';

//fonction récupération de toutes les catégories
$tab = $categorie->getAll();
print_r($tab);

?>