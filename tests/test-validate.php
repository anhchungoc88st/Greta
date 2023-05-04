<?php

//on initialise une session si inexistante (n'est pas nécessaire pour faire fonctionner la class validate)
if(!isset($_SESSION)) session_start();

/* on inclut la class qui va nous servir pour la validation du formulaire : */
require_once('../controllers/class_validate.php');


/********************************/
/* EXEMPLE USAGE DE LA CLASS : */
/******************************/

/* on déclare des faux champs de formulaire pour faire nos tests */
$_POST = [
    'name' => 'toto"', //nom
    'email' => 'sdf sdf@sdfsdf.fr', //email
    'phone' => '0634567891', //téléphone
    'code_postal' => '06350', //code postal
    'password' => '12345', //mot de passe
    'password_verify' => '12345', //vérification mot de passe
    'date_fr' => '11/09/1988', //date française
    'date_en' => '1988-11-09', //date anglaise
    'age' => 22, //age
    'cat' => 12, //numéro de catégorie
    'price' => 21.2, //prix avec virgule
    'alphabetic' => 'sdfhuUHUihdef', //texte alphabétique (uniquement des lettres majuscules et/ou minuscules)
    'champ_a_exclure' => 'sdfkjhsdfjh', //champ qui ne doit pas être gardé
    'champ_a_exclure_b' => 'dddd' //champ qui ne doit pas être gardé
];

/* on instancie la class Validate avec en paramètre notre tableau $_POST */
$v = new Validate($_POST);

/* on définit les règles de validation par champ de formulaire */
/* à gauche : le nom du champ de formulaire à tester */
/* à droite : la/les règle(s) de vérification */
$v->validate([
  'name' => ['required', 'minLength:3','type:string'], // vérifie que c'est une chaîne de caractères d'un minimum de 3 caractères
  'email' => ['required', 'maxLength:150','type:email'], // vérifie que c'est une adresse mail remplie + valide + maximum 150 caractères
  'phone' => ['type:phone'], // vérifie que c'est un numéro de téléphone valide
  'code_postal' => ['type:zipcode'], //vérifie que c'est un code postal valide : 06000
  'password' => ['required', 'maxLength:150','type:password'],
  'password_verify' => ['samePassword'], //compare avec le data['password'] existant (intervient toujours APRES un data data['password'])
  'age' => ['minLength:2','type:int','minValue:18','maxValue:98'],
  'cat' => ['minLength:2'], //vérifie que le champ existe et fait au moins 2 caractères
  'date_fr' => ['type:date-fr'],//vérifie que c'est une date au format français : jj-mm-aaaa
  'date_en' => ['type:date-en'],//vérifie que c'est une date au format anglais : aaaa-mm-jj
  'price' => ['type:float'], //vérifie que c'est un flottant
  'test' => ['exists'], //vérifie simplement si un champ est passé (existe)
  'alphabetic' => ['type:alphabetic'] //chaîne alphabétique uniquement (lettres majuscules/minuscules)
]);

if(!$v->ok()) { //méthode qui vérifie s'il n'y a pas d'erreurs
  var_dump($v->errors()); //on affiche les erreurs
}

$v->logs(); //on affiche les logs pour debugger ou mieux comprendre la classe

echo'<br><br><br><br><br><br><br><br><br>_POST: ';
print_r($_POST); // on affiche les $_POST avant validation

echo'<br><br>datas sanitized: ';
$_POST = $v->getDatas(); //on récupère tous les champs validés et filtrés et on les assigne à $_POST.
print_r($_POST); // on affiche les $_POST après validation

echo'<br><br>datas session: ';
if(isset($_SESSION)){ 
    $_SESSION['form_errors'] = $v->errors(); // s'il y a des erreurs on les enregistre dans la session
    print_r($_SESSION);
} else echo 'Aucune session ouverte';

?>