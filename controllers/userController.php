<?php

require_once(DIR_PATH.'models/class_users.php');

class UserController {

    public $form;
    public $user;

   function __construct($formObj){
        $this->form = $formObj;
        $this->user = new User();
    }

    function register(){

        $this->form->validate([
            'login' => ['required', 'maxLength:150'],
            'prenom' => ['required', 'maxLength:150'],
            'nom' => ['required', 'maxLength:150'],
            'email' => ['required', 'maxLength:150','type:email'],
            'tel' => ['type:phone'],
            'postal' => ['type:zipcode'],
            'sexe' => ['required', 'type:numeric', 'maxValue:2'],
            'password' => ['required', 'maxLength:150','type:password'],
            'password_verify' => ['samePassword'], //compare avec le data['password'] existant (intervient toujours APRES un data data['password'])
            'naissance' => ['required','type:date-en'],
            'adresse' => ['exists'], // vérifie juste que le champ existe
            'ville' => ['exists'] // vérifie juste que le champ existe
        ]);

        $_POST = $this->form->getDatas();
          
        if($this->form->ok()) {
            if(!$this->user->getByEmail($_POST['email'])){
                if(!$this->user->getByLogin($_POST['login'])){
                    if($this->user->add()){
                        $this->user->login();
                        header('Location: '.URL_SITE);
                        exit;
                    }
                } else $_SESSION['form_errors'] = array("Un utilisateur existe déjà avec ce login");
            } else $_SESSION['form_errors'] = array("Un utilisateur existe déjà avec cette adresse mail");
        } else {
            //var_dump($this->form->errors());
        }

    }


    function update(){

        $this->form->validate([
            'login' => ['required', 'maxLength:150'],
            'prenom' => ['required', 'maxLength:150'],
            'nom' => ['required', 'maxLength:150'],
            'email' => ['required', 'maxLength:150','type:email'],
            'tel' => ['type:phone'],
            'postal' => ['type:zipcode'],
            'sexe' => ['required', 'type:numeric', 'maxValue:2'],
            'naissance' => ['required','type:date-en'],
            'adresse' => ['exists'], // vérifie juste que le champ existe
            'ville' => ['exists'] // vérifie juste que le champ existe
        ]);

        $_POST = $this->form->getDatas();
          
        if($this->form->ok()) {
            if($_SESSION['email'] == $_POST['email'] || !$this->user->getByEmail($_POST['email'])){
                if($_SESSION['login'] == $_POST['login'] || !$this->user->getByLogin($_POST['login'])){
                    if($this->user->update($_SESSION['id_user'])){
                        header('Location: '.URL_SITE);
                        exit;
                    }
                } else $_SESSION['form_errors'] = array("Un utilisateur existe déjà avec ce login");
            } else $_SESSION['form_errors'] = array("Un utilisateur existe déjà avec cette adresse mail");
        } else {
            //var_dump($this->form->errors());
        }

    }

    function login(){

        $this->form->validate([
            'login' => ['required', 'minLength:3', 'maxLength:150'],
            'password' => ['required', 'maxLength:150']
        ]);

        $_POST = $this->form->getDatas();
          
        if($this->form->ok()) {
            if($this->user->login()){
                header('Location: '.URL_SITE);
                exit;
            } else $_SESSION['form_errors'] = array("Identifiants incorrects");
        } else {
            //var_dump($this->form->errors());
        }

    }    
}