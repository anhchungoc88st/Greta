<?php

require_once(DIR_PATH.'/models/class_categories.php');

class CategoriesController{
    private $form;
    private $categorie;

    function __construct($formObj){
        $this->form = $formObj;
        $this->categorie = new Categories();
    }

    function addCat(){
        $this->form->validate([
            'nom_categorie'=> ['required', 'maxLength:60', 'type:string']
            ]);
        if($this->form->ok()) {
            if($this->categorie->add()){
                    header('Location: '.URL_SITE);
                    exit;
                }
            } 
        }

    function updateCat(){
        $this->form->validate([
            'nom_categorie'=> ['required', 'maxLength:60', 'type:string'],
            'id' => ['required', 'type:numeric'],
            ]);
            if($this->form->ok()) {
                if($this->categorie->update($_POST['id'])){
                        header('Location: '.URL_SITE);
                        exit;
                    }
                }
        }

    function deleteCat(){
        $this->form->validate([
            'id' => ['required', 'type:numeric']
            ]);
            if($this->form->ok()) {

                if($this->categorie->delete($_POST['id'])){
                    header('Location: '.URL_SITE);
                    exit;
                } 
            }
    }

}

?>