<?php

if(!isset($_SESSION)){
    session_start();
    $_SESSION['connected'] = false;
}

$_SESSION['id_user'] = 5;

require_once('../conf.php');
require_once('../controllers/helpers.php');
require_once('../models/class_db.php');
require_once('../models/class_annonces.php');

//fonction d'insertion
$_POST = array();
$_POST['titre']="Voiture";
$_POST['description']="Voiture de 2005, Mercedes, en bon etat.";
$_POST['duree_de_publication_en_mois']=3;
$_POST['prix_vente_objet']=9800;
$_POST['id_mode_paiement']=5;
$_POST['id_etat']=3;

$annonce = new Annonces(); //instance de la classe Annonce dans un objet $annonce

$id = $annonce->add(); //pour ajouter une annonce

if(!$id) die('Erreur lors de l\'ajout');

//fonction récupération d'une annonce
$annonceInfo = $annonce->getById($id);
if(!$annonceInfo) die('Erreur lors de la récupération d\'une annonce');
print_r($annonceInfo);

//fonction modification
$_POST['titre']="Voiture neuve"; //on change une valeur
$update = $annonce->update($id);
if(!$update) die('Modification impossible');

//fonction récupération d'une annonce
$annonceInfo = $annonce->getById($id);

if(!$annonceInfo) die('Erreur lors de la récupération d\'une annonce ');
print_r($annonceInfo);

//fonction suppression d'un annonce
$deleted = $annonce->delete($id);
if(!$deleted) die('Suppression annonce impossible'); else echo 'annonce supprimée';

//fonction récupération de tous les annonces
$tab = $annonce->getAll();
print_r($tab);

?>