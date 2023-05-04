<?php

// fonction qui renvoie un utilisateur d'après son id
function getUser($id){
  try {
    $db = connect();
    $userQuery = $db->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
    $userQuery->execute(['id' => $id]);
    return $userQuery->fetch();
  } catch(Exception $e){
    if(DEBUG_MODE) echo $e->getMessage();
  }
  return false;
}

function getUsers($limit=10,$page=1){
  try {
    $db = connect();
    $users=$db->query('SELECT * FROM utilisateur '.generate_sql_limit($limit,$page));
    return $users->fetchAll();
  } catch (Exception $e) {
    if(DEBUG_MODE) echo $e->getMessage();
  }
  return false;
}

// modification d'un utilisateur
function updateUser($id){
  try {
    $db = connect();
    $updateUser = $db->prepare('UPDATE utilisateur SET login = :login, email = :email, password_hash = :password_hash, nom_utilisateur = :nom_utilisateur, prenom_utilisateur = :prenom_utilisateur, date_naissance = :date_naissance, num_telephone = :num_telephone, sexe = :sexe, adresse_postale = :adresse_postale, code_postal = :code_postal, ville = :ville WHERE id_utilisateur = :id');
    return $updateUser->execute([
      'login' => $_POST['login'],
      'email' => $_POST['email'],
      'password_hash' => password_hash($_POST['password'], PASSWORD_BCRYPT),
      'nom_utilisateur' => $_POST['nom'],
      'prenom_utilisateur' => $_POST['prenom'],
      'date_naissance' => date_fr_to_en($_POST['naissance']),
      'num_telephone' => $_POST['tel'],
      'sexe' => $_POST['sexe'],
      'adresse_postale' => $_POST['adresse'],
      'code_postal' => $_POST['postal'],
      'ville' => $_POST['ville'],
      'id' => $id
    ]);
  } catch (Exception $e) {
    if(DEBUG_MODE) echo $e->getMessage();
  }
  return false;
}

//suppression d'un utilisateur via son id
function deleteUser($id){
  try {
    $db = connect();
    $deleteUser = $db->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
    return $deleteUser->execute(['id' => $id]);
  } catch (Exception $e) {
    if(DEBUG_MODE) echo $e->getMessage();
  }
  return false;
}

//ajout d'un nouvel utilisateur
function adduser($is_admin=0){
  try {
    $db = connect();
    $datas = 'INSERT INTO utilisateur (login, email, password_hash, nom_utilisateur, prenom_utilisateur, date_naissance, num_telephone, sexe, adresse_postale, code_postal, ville, date_inscription';
    if($is_admin == 'admin') $datas.=', is_admin';
    $datas.=') VALUES (:login, :email, :password_hash, :nom_utilisateur, :prenom_utilisateur, :date_naissance, :num_telephone, :sexe, :adresse_postale, :code_postal, :ville, :date_inscription';
    if($is_admin == 'admin') $datas.=', :is_admin';
    $datas.=')';
    $insertUser = $db->prepare($datas);

    $tab = [
      'login' => $_POST['login'],
      'email' => $_POST['email'],
      'password_hash' => password_hash($_POST['password'], PASSWORD_BCRYPT),
      'nom_utilisateur' => $_POST['nom'],
      'prenom_utilisateur' => $_POST['prenom'],
      'date_naissance' => date_fr_to_en($_POST['naissance']),
      'num_telephone' => $_POST['tel'],
      'sexe' => $_POST['sexe'],
      'adresse_postale' => $_POST['adresse'],
      'code_postal' => $_POST['postal'],
      'ville' => $_POST['ville'],
      'date_inscription' => date('Y-m-d')
    ];
    if($is_admin == 'admin') $tab['is_admin'] = 1;
    $req = $insertUser->execute($tab);
    if($req) return $db->lastInsertId();
  } catch (Exception $e) {
    if(DEBUG_MODE) echo $e->getMessage();
  }
  return false;
}

function login(){
  if(!empty($_POST['login']) && !empty($_POST['password'])){
    try{
      $db = connect();
      $getData = $db->prepare('SELECT id_utilisateur, login, is_admin, password_hash FROM utilisateur WHERE login = :login');
      $getData->execute(['login' => $_POST['login']]);
      $req = $getData->fetch();
      if($req){
        if(password_verify($_POST['password'],$req['password_hash'])){
          $_SESSION['id_user'] = $req['id_utilisateur'];
          $_SESSION['login'] = $req['login'];
          $_SESSION['is_admin'] = $req['is_admin'];
          $_SESSION['connected'] = true;
          return true;
        }
      }
    } catch (Exception $e) {
      if(DEBUG_MODE) echo $e->getMessage();
    }
    return false;
  }
}

function logout(){
  session_destroy();
  unset($_SESSION);
  return is_connected();
}

function is_connected(){
  //if($_SESSION['connected']) return true;
  if(isset($_SESSION['connected'])) return $_SESSION['connected'];
  return false;
}

function is_admin(){
  if(is_connected() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) return true;
  return false;
}

?>