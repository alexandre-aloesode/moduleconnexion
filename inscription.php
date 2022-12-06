<?php


// variable user suivie de la requète pour vérifier que le nom de login n'existe pas déjà. 
// Si le nom existe déjà la requète renvoie la valeur 0 à $user
    $user = 1;
    $message;
    if(isset($_POST['inscription'])){
        include 'connecSQL.php';
        $request_check_user= "SELECT `login` FROM `utilisateurs`";
        $query_check_user = $mysqli->query($request_check_user);
        $result = $query_check_user->fetch_all();

        for($x = 0; isset($result[$x]); $x++ ){
            for($i = 0; isset($result[$x][$i]); $i++)
                if($result[$x][$i] == $_POST['pseudo']){
                    $user = 0;
                }
        } 
        
//création du compte si le user n'existe pas déjà
        if($_POST['mdp'] == $_POST['mdp_confirm'] && $user == 1)
        {
            $login = $_POST['pseudo'];
            $name = $_POST['prenom'];
            $surname = $_POST['nom'];
            $mdp = $_POST['mdp'];
            $request = "INSERT INTO `utilisateurs`(`login`, `prenom`, `nom`, `password`) 
            VALUES ('$login','$name','$surname','$mdp')";
            $query = $mysqli->query($request);
            header('Location: connexion.php');
        }

// conditions pour vérifier si le mdp est bien tapé, si le pseudo existe déjà, ou si le compte 
// a bien été crée
        if(isset($_POST['inscription']) && $user == 1 &&$_POST ['mdp'] == $_POST['mdp_confirm']){
            $message =  'Compte créé avec succès';
        } elseif(isset($_POST['inscription']) && $_POST['mdp'] !== $_POST['mdp_confirm']){
            $message =  'Les mots de passe ne correspondent pas';
        } elseif(isset($_POST['inscription']) && $user == 0){
            $message = 'Ce pseudo existe déjà';
        }
    }  
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="index.css" rel = "stylesheet">
    <link href="formulaires.css" rel = "stylesheet">
    <title>Inscription</title>
</head>
<body>
<div class="background">

    <?php    
        include 'header.php';
    ?>  

    <main>
        <h2>Veuillez remplir les champs suivants afin de créer votre compte</h2>
        <h3>
           <?php 
           if(isset($_POST['inscription'])) { 
                echo $message;
           }
            ?>
        </h3>
        <form method="post" class="formulaire">
            <input type="text" class="form_input" name="pseudo" placeholder="Pseudo">
            <input type="text" class="form_input" name="prenom" placeholder="Prénom">
            <input type="text" class="form_input" name="nom" placeholder="Nom">
            <input type="password" class="form_input" name="mdp" placeholder="Mot de passe">
            <input type="password" class="form_input" name="mdp_confirm" 
            placeholder="Confirmez votre mot de passe">
            <button type="submit" class="form_button" name="inscription">Créer votre compte</button>
        </form>
    </main>
</div>  
</body>
</html>