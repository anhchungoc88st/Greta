<?php

define('TITRE_SITE','BrainyUP');
define('URL_SITE','http://localhost/ident/');
define('LIMIT', 10);
define('DEBUG_MODE',true);
define('DIR_PATH',__DIR__.'/');

function connect() {
    $hostname = 'localhost';
    $dbname = 'ident';
    $username = 'root';
    $password = '';
  
    $id = "mysql:host=$hostname;dbname=$dbname";

    try{
      $dbh = new PDO($id, $username, $password);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
      return $dbh;
    } catch (Exception $e){
      if(DEBUG_MODE) echo $e->getMessage();
    }
}

?>