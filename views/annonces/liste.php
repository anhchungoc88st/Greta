<div class='row'>
    <h1 class='col-md-12 text-center border border-dark text-white bg-primary'>Mes Annonces</h1>
</div>
<div class='row'>
    <table class='table table-striped'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Date_creation</th>
                <th scope='col'>Titre</th>
                <th scope='col'>Description</th>
                <th scope='col'>duree_de_publication_en_mois</th>
                <th scope='col'>prix_vente_objet</th>
                <th scope='col'>cout_annonce</th>
                <th scope='col'>date_validation</th>
                <th scope='col'>date_fin_publication</th>
                <th scope='col'>#modepaiement</th>
                <th scope='col'>#etat</th>
                <th scope='col'>#utilisateur</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            //require_once
            //require_once('../../models/class_annonces.php');
            $a = new Annonces();
            $annonces = $a->getAllUser();
            if(isset($annonces) && is_array($annonces)){
            foreach ($annonces as $annonce){ ?>
                <tr>
                    <td><?= $annonce['id']; ?></td>
                    <td><? if(!empty($annonce['date_creation'])) echo htmlentities($annonce['date_creation']); ?></td>
                    <td><?= htmlentities($annonce['titre']); ?></td>
                    <td><?= htmlentities($annonce['description']); ?></td>
                    <td><?= htmlentities($annonce['duree_de_publication_en_mois']); ?></td>
                    <td><?= htmlentities($annonce['prix_vente_objet']); ?></td>
                    <td><?= htmlentities($annonce['cout_annonce']); ?></td>
                    <td><?php if(!empty($annonce['date_validation'])) echo htmlentities(date("d/m/Y",strtotime($annonce['date_validation']))); ?></td>
                   <td><?php if(!empty($annonce['date_fin_publication'])) echo htmlentities($annonce['date_fin_publication']) ?></td>
                    <td><?php if(!empty($annonce['id_mode_paiement'])) echo htmlentities($annonce['id_mode_paiement']) ?></td>
                    <td><?php if(!empty($annonce['id_etat'])) echo htmlentities($annonce['id_etat']) ?></td>
                    <td><?= htmlentities($annonce['id_utilisateur']) ?></td>
                    <td>
                        <a class='btn btn-primary' href='<?= URL_SITE; ?>?p=update-annonce&id=<?= $annonce['id']; ?>' role='button'>Modifier</a> 
                       <a class='btn btn-danger' href='delete-annonce.php?id=<?= $annonce['id'] ?>' role='button' onclick='return confirm("Voulez-vous supprimer?")'>Supprimer</a>
                    </td>
                </tr>
            <?php }
            }
            ?>
        </tbody>
    </table>
</div>
<div class='row'>
    <div class='col'>
        <a class='btn btn-success' href='<?= URL_SITE; ?>?p=create-annonce' role='button'>Ajouter annonce</a>
    </div>
</div>