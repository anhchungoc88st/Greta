<?php
require_once(DIR_PATH.'/models/class_annonces.php');
require_once(DIR_PATH.'controllers/class_validate.php');

class AnnoncesController {

    public $form;
    public $annonce;

   function __construct($formObj){
        $this->form = $formObj;
        $this->annonce = new Annonces();
    }

    function add(){

        $this->form->validate([
            'titre' => ['required', 'maxLength:100'],
            'description' => ['required', 'maxLength:500'],
            'duree_de_publication_en_mois' => ['required', 'maxLength:150', 'type:numeric'],
            'prix_vente_objet' => ['required', 'type:numeric'],
            'id_paiement' => ['required','type:numeric'],
            'id_etat' => ['required','type:numeric']
        ]);

        $_POST = $this->form->getDatas();
          
        if($this->form->ok()) {
            if($this->annonce->add()){
                header('Location: '.URL_SITE);
                exit;
            }
        } else {
            //var_dump($this->form->errors());
        }

    }

    function update(){

        $this->form->validate([
            'titre' => ['required', 'maxLength:100'],
            'description' => ['required', 'maxLength:500'],
            'prix_vente_objet' => ['required', 'type:numeric'],
            'id_etat' => ['required','type:numeric'],
            'id' => ['required','type:numeric']
        ]);

        $_POST = $this->form->getDatas();

        if($this->form->ok()) {
            if($this->annonce->update($_POST['id'])){
                header('Location: '.URL_SITE);
                exit;
            }
        } else {
            //var_dump($this->form->errors());
        }

    }

    /*function delete(){

        if($this->annonce->delete($id)) {
            header('Location: '.URL_SITE);  
        }
    }*/
}

?>