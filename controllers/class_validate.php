<?php

require_once('helpers.php');

class Validate
{

  private $data;
  private $sanitized_data = [];
  private $allowed_func;
  private $errors = [];
  private $logs = [];

  public function __construct($data)
  {
    $this->data = $data;
    $this->allowed_func = array("required","minLength","maxLength","minValue","maxValue","samePassword","exists","type"); // fonctions existentes & autorisées
  }

  public function getDatas($sanitize=true){
    if($sanitize){
      $this->sanitizeDatas();
      return $this->sanitized_data;
    }
    $this->data;
  }

  public function sanitizeDatas(){
    if(!empty($this->sanitized_data) && is_array($this->sanitized_data)){
      foreach($this->sanitized_data as $k => $v){
        $this->sanitized_data[$k] = htmlentities($v);
      }
    }
  }

  public function validate($rules)
  {
    $this->logs[] = "func validate";
    if(is_array($rules)){ //toujours vérifier le type, sinon tu pourris tes logs avec le foreach qui suit
      foreach($rules as $key => $value) {
        if(is_array($value)){ //même raison que précédent
          foreach($value as $rule) {
          $arr = explode(':', $rule);
          $fun = $arr[0];
          if(in_array($fun,$this->allowed_func)){ //on vérifie que c'est une fonction existente et autorisée
            $this->sanitized_data[$key] = isset($this->data[$key]) ? $this->data[$key] : '';
            $param = isset($arr[1]) ? $arr[1] : null;
            if(isset($this->data[$key]) || $arr[0] === 'required' || $arr[0] === 'samePassword') {
              $param ? $this->$fun($key, $param) : $this->$fun($key);
            }else{
              $this->logs[] = "- error: '".$key."' not finded in data";
              $this->errors[$key] = $key." champ introuvable";
            }
          }else $this->logs[] = "- error: '".$fun."' ins't a function allowed";
          }
        }else $this->logs[] = "- error: 'value' must be an array";
      } 
    } else $this->logs[] = "- error: 'rules' must be an array";
  }

  /**
   * Get the value of success
   */
  public function ok()
  {
    $count = count($this->errors);
    if($count > 0) $this->saveErrorsInSession();
    else $this->destroyErrorsInSession();
    return $count <= 0;
  }

  /**
   * Get the value of errors
   */
  public function errors()
  {
    return $this->errors;
  }

  public function saveErrorsInSession(){
    if(isset($_SESSION)){
      $_SESSION['form_errors'] = $this->errors(); //s'il y a des erreurs on les met dans la session
    }
  }

  public function destroyErrorsInSession(){
    if(isset($_SESSION['form_errors'])) unset($_SESSION['form_errors']); //s'il y avait des erreurs enregistrées alors que maintenant il n'y a plus d'erreur alors on les supprime
  }
  
  /**
   * Display logs
   */
  public function logs()
  {
    if(isset($this->logs[0])){
      foreach($this->logs as $log){
        echo '<br>'.$log;
      }
    } else echo'No logs';
  }

  // Rule Methods
  private function required($key)
  {
	  $this->logs[] = "func required - key: ".$key." / data:".$this->data[$key];
    if (!isset($this->data[$key]) || is_null($this->data[$key]) || $this->data[$key] == ''){
      $this->errors[$key] = $key." est requis.";
    }
  }

  /**
   * Don't do nothing, just an error if doesn't exists in data (do by $this->validate() method)
   */
  public function exists(){

  }

  private function minLength($key, $length)
  {
	  $this->logs[] = "func minLength - key: ".$key." / length: ".$length." / data:".$this->data[$key];
    if (strlen((string) $this->data[$key]) < $length) {
      $this->errors[$key] = $key." doit contenir au minimum ".$length." caractères.";
    }
  }

  private function maxLength($key, $length)
  {
	  $this->logs[] = "func maxLength - key: ".$key." / length: ".$length." / data:".$this->data[$key];
    if (strlen((string) $this->data[$key]) > $length) {
      $this->errors[$key] = $key." ne doit ne pas dépasser ".$length." caractères.";
    }
  }

  private function minValue($key, $length)
  {
	  $this->logs[] = "func minValue - key: ".$key." / length: ".$length." / data:".$this->data[$key];
    if ($this->data[$key] < $length) {
      $this->errors[$key] = $key." doit être au minimum à ".$length.".";
    }
  }

  private function maxValue($key, $length)
  {
	  $this->logs[] = "func maxValue - key: ".$key." / length: ".$length." / data:".$this->data[$key];
    if ($this->data[$key] > $length) {
      $this->errors[$key] = $key." doit être au minimum à ".$length.".";
    }
  }

  private function samePassword($key)
  {
	  $this->logs[] = "func samePassword - pwd_a: ".$this->data["password"]." / pwd_b: ".$this->data[$key];
    if(!isset($this->data["password"]) || $this->data["password"] != $this->data[$key]) {
      $this->errors[] = "Les 2 mots de passe ne sont pas identiques.";
    }
  }
  
  private function type($key, $type){
    $this->logs[] = "func type - key: ".$key." / type: ".$type." / data:".$this->data[$key];
    if(!isset($this->data[$key])) $this->logs[] = "- error: ".$key." not finded in data object";
    elseif($type == "string"){
      if(!is_string($this->data[$key])) $this->errors[$key] = $key." doit être une chaîne de caractères";
    }
    elseif($type == "numeric"){
      if(!is_numeric($this->data[$key])) $this->errors[$key] = $key." doit être de type numéric";
    }
    elseif($type == "int"){
      if(!is_int($this->data[$key])) $this->errors[$key] = $key." doit être un entier";
    }
    elseif($type == "float"){
      if(!is_float($this->data[$key])) $this->errors[$key] = $key." doit être de type float";
    }
    elseif($type == "alphabetic"){
      if(!ctype_alpha($this->data[$key])) $this->errors[$key] = $key." doit être une chaîne de caractères uniquement composée de lettres majuscules et/ou minuscules";
    }
    elseif($type == "email"){
      if(!is_email($this->data[$key])) $this->errors[$key] = "L'adresse mail est invalide, elle doit être sous la forme xxxx@xxx.xx";
    }
    elseif($type == "phone"){
      if(!is_phone_number($this->data[$key])) $this->errors[$key] = "Le numéro de téléphone doit être sous la forme : 0603056120)";
    }
    elseif($type == "date-fr"){
      if(!is_date_fr($this->data[$key])) $this->errors[$key] = "La date doit être sous la forme : jj/mm/aaaa";
    }
    elseif($type == "date-en"){
      if(!is_date_en($this->data[$key])) $this->errors[$key] = "La date doit être sous la forme : aaaa-mm-jj";
    }
    elseif($type == "password"){
      if(!is_strong_password($this->data[$key])) $this->errors[$key] = "Le mot de passe doit comporter au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial";
    }
    elseif($type == "zipcode"){
      if(!is_zip_code($this->data[$key])) $this->errors[$key] = "Le code postal doit être valide (sous la forme : 000000)";
    }
    
  }
}

?>