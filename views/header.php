<html>
<head>
    <title><?= TITRE_SITE; ?></title>
</head>
<body>
<nav>
    <ul>
        <li><a href="<?= URL_SITE; ?>">Accueil</a></li>
        <?php if(!is_connected()){ ?>
        <li><a href="<?= URL_SITE; ?>?p=register">S'inscrire</a></li>
        <li><a href="<?= URL_SITE; ?>?p=login">Connexion</a></li>
        <?php } else { ?> 
        <li><a href="<?= URL_SITE; ?>?p=profile">Mon profil</a></li>
        <li><a href="<?= URL_SITE; ?>?p=update-profile">Modifier profil</a></li>
        <li><a href="<?= URL_SITE; ?>?p=create-annonce">Créer annonce</li>
        <li><a href="<?= URL_SITE; ?>?p=liste-annonces">Mes annonces</li>
        <li><a href="<?= URL_SITE; ?>?logout=true">Se déconnecter</a></li>
        <?php } ?>
    </ul>    
</nav>