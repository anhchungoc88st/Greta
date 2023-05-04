<?php

class User extends Db {

    public function __construct()
    {
       parent::__construct();  //lance le connexion à la bdd grâce au constructeur de la classe mère
       $this->table = "utilisateurs";  //On change la propriété "table" en y mettant le nom de la table dont on aura besoin ici et dans les méthodes de la classe mère
    }

    public function delete($id) {
        return $this->delete_($id);
    }


    public function getById($id) {
        return $this->getById_($id);
    }

    public function getAll($limit=10, $page=1) {
        return $this->getAll_($limit, $page);
    }


    public function update($id){
        try {
            $db = $this->db;
            $updateUser = $db->prepare('UPDATE '.$this->table.' SET login = :login, email = :email, nom_utilisateur = :nom_utilisateur, prenom_utilisateur = :prenom_utilisateur, date_naissance = :date_naissance, num_telephone = :num_telephone, sexe = :sexe, adresse_postale = :adresse_postale, code_postal = :code_postal, ville = :ville WHERE id = :id');
            return $updateUser->execute([
            'login' => $_POST['login'],
            'email' => $_POST['email'],
            'nom_utilisateur' => $_POST['nom'],
            'prenom_utilisateur' => $_POST['prenom'],
            'date_naissance' =>$_POST['naissance'],
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

    public function add($is_admin=0){
        try {
          $db = $this->db;
          $datas = 'INSERT INTO '.$this->table.' (login, email, password_hash, nom_utilisateur, prenom_utilisateur, date_naissance, num_telephone, sexe, adresse_postale, code_postal, ville, date_inscription';
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
            'date_naissance' => $_POST['naissance'],
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
      
    public function login(){
        if(!empty($_POST['login']) && !empty($_POST['password'])){
          try{
            $db = $this->db;
            $getData = $db->prepare('SELECT id, login, is_admin, email, password_hash FROM '.$this->table.' WHERE login = :login');
            $getData->execute(['login' => $_POST['login']]);
            $req = $getData->fetch();
            if($req){
              if(password_verify($_POST['password'],$req['password_hash'])){
                $_SESSION['id_user'] = $req['id'];
                $_SESSION['login'] = $req['login'];
                $_SESSION['email'] = $req['email'];
                $_SESSION['is_admin'] = $req['is_admin'];
                $_SESSION['connected'] = 1;
                return true;
              }
            }
          } catch (Exception $e) {
            if(DEBUG_MODE) echo $e->getMessage();
          }
          return false;
        }
      }
      
    public static function logout(){
        session_destroy();
        unset($_SESSION);
        return self::is_connected();
      }
      
    public static function is_connected(){
        //if($_SESSION['connected']) return true;
        if(isset($_SESSION['connected'])) return $_SESSION['connected'];
        return false;
      }
      
    public static function is_admin(){
        if(self::is_connected() && isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1) return true;
        return false;
      }


    
    public function getByName($nom){
      if (!empty($nom)) {
        try {
          $db = $this->db;
          $userQuery = $db->prepare("SELECT * FROM ".$this->table." WHERE nom_utilisateur = :nom");
          $userQuery->execute(['nom' => $nom]);
          return $userQuery->fetch();
        } catch (Exception $e) {
          if (DEBUG_MODE) echo $e->getMessage();
        }
      }
      return false;
    }

    public function getByLogin($login){
      if (!empty($login)) {
        try {
          $db = $this->db;
          $userQuery = $db->prepare("SELECT * FROM ".$this->table." WHERE login = :login");
          $userQuery->execute(['login' => $login]);
          return $userQuery->fetch();
        } catch (Exception $e) {
          if (DEBUG_MODE) echo $e->getMessage();
        }
      }
      return false;
    }

    public function getByEmail($email){
      if (!empty($email)) {
        try {
          $db = $this->db;
          $userQuery = $db->prepare("SELECT * FROM ".$this->table." WHERE email = :email");
          $userQuery->execute(['email' => $email]);
          return $userQuery->fetch();
        } catch (Exception $e) {
          if (DEBUG_MODE) echo $e->getMessage();
        }
      }
      return false;
    }

    public function forgetPwd($email){
      $email = filter_var(filter_input(INPUT_POST,"email", FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
      if($email){
        try {
          $db = $this->db;
          $query=$db->prepare("SELECT * FROM utilisateur WHERE email=:email");
          $query->execute(["email"=>$email]);
          $req = $query->fetch();
          if($req){
            $token = bin2hex((random_bytes(16)));
            $valid = time() + 1200;
            $inserquery = $db->prepare('UPDATE utilisateur SET reset_token= :token, perim= :perim WHERE email = :email');
            $inserquery->execute(['token' => $token, 'perim' => $valid, 'email' => $email]);
            if($inserquery->rowCount()){
              $objet="Réinitialisation Mot de Passe";
              $url="reset.php?t=".$token;
              $message="<font face='arial'>Bonjour\n
              Cliquez ici pour réinitialiser votre mot de passe : ".$url."  \n
              Merci et bonne journée.
              </font>";
              $entetes="From: widad@example.comn";
              $entetes.="Content-Type: text/html; charset=iso-8859-1";
              if(mail($email,$objet,$message,$entetes))
                return true;
            }
          }
        }catch (Exception $e) {
          if (DEBUG_MODE) echo $e->getMessage();
        }
      }
      return false; 
    }    


  public function resetPass($pwd,$token){
    try {
      $db = $this->db;
      $req = $db->prepare('SELECT token, perim FROM user WHERE token = :token');
      $req->execute(["token"=>$token]);
      $verif = $req->fetch();
      if($verif){
        if($verif['perim']>time()){
              $reset = $db->prepare('UPDATE user SET password = :password, token = NULL, perim = NULL, actif=1  WHERE token = :token');
              $reset->execute(['password'=>password_hash($pwd, PASSWORD_BCRYPT)]);
              if($reset->rowCount()) return true;
        }
      }
    } catch (Exception $e) {
      if (DEBUG_MODE) echo $e->getMessage();
    }
    return false;
  }

}