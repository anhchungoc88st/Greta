<?php

// génère la limite d'une requête SQL, ex : LIMIT 10 OFFSET 10
function generate_sql_limit($limit=LIMIT,$page=1){
    if(!is_numeric($limit)) $limit = LIMIT;
    $t = ' LIMIT '.$limit;
    if(is_numeric($page) && $page > 1){
      $offset = $limit*($page-1);
      $t.= ' OFFSET '.$offset;
    }
    return $t;
  }

//vérifie si une date est au format jj/mm/aaaa
function is_date_fr($value){
    if(DateTime::createFromFormat('d/m/Y',$value)) return true;
    return false;
}

function is_date_en($value){
    if(DateTime::createFromFormat('Y-m-d',$value)) return true;
    return false;
}

//vérifie que c'est une adresse mail valide
function is_email($email){
    if(filter_var($email,FILTER_VALIDATE_EMAIL)) return true;
    return false;
}

//vérifie que c'est un numéro de téléphone de type entier composé de 10 chiffres
function is_phone_number($number){
    if(preg_match('/^0[0-9]{9}$/',$number)) return true;
    return false;
}

//vérifie que c'est un code postal de 5 chiffres. format : 06000
function is_zip_code($code){
    if(preg_match('/^[0-9]{5}$/',$code)) return true;
    return false;
}

//fonction qui transforme une date au format jj/mm/aaaa en date universelle au format aaaa-mm-jj
function date_fr_to_en($date){
    if(is_date_fr($date)){
        $date = preg_replace('/^(\d{2})\/(\d{2})\/(\d{4})$/','$3-$2-$1',$date);
        return $date;
    }
    return false;
}

//fonction qui transforme une date au format aaaa-mm-jj en date au format jj/mm/aaaa
function date_en_to_fr($date){
    if(is_date_en($date)){
        //$date = preg_replace('/^(\d{4})-(\d{2})-(\d{2})$/','$3/$2/$1',$date));
        $date = date('d/m/Y',strtotime($date));
        return $date;
    }
    return false;
}

//fonction qui vérifie que l'utilisateur a entré 2 fois le même mot de passe
function password_check($pwd,$pwd_b){
    if($pwd == $pwd_b) return true;
    return false;
}

// fonction qui vérifie qui le mot de passe est assez forme (au moins 8 caractères dont au moins 1 chiffre, 1 minuscule, 1 majuscule et 1 caractère spécial)
function is_strong_password($pwd){
    if(preg_match("/^(?=.*\d)(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[\W]).{8,}$/", $pwd)) return true;
    return false;
}

function getFormErrors(){
    $html='';
    if(!empty($_SESSION['form_errors'])){
        $html.='<div class="form-errors">';
        if(is_array($_SESSION['form_errors'])) {
                foreach($_SESSION['form_errors'] as $k => $v){
                    $html.='<p>'.htmlentities($v).'</p>';
                }
        } else $html.='<p>'.$_SESSION['form_errors'].'</p>';
        $html.='</div>';
        unset($_SESSION['form_errors']);
        return $html;
    }
}

?>