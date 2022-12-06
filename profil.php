<?php

    include 'connec.php';

// ci_dessous une requête php my admin qui me permet de récupérer les infos du profil pour les 
// utiliser dans la page profil.php pour afficher les infos du profil du user connecté
    include 'connecSQL.php';
    $request_fetch_user_info= "SELECT * FROM `utilisateurs` where id = '$_SESSION[userID]'";
    $query_fetch_user_info = $mysqli->query($request_fetch_user_info);
    $result_fetch_user_info = $query_fetch_user_info->fetch_all();

    $message_profil;

    if(isset($_POST['profil_change'])){  
// le 1er if vient vérifier si la personne a cliqué sur "modifier", le deuxieme vient vérifier
// si l'ancien mdp est valide (avec un else qui renvoie "ancien mdp invalide". Si les 2 conditions 
// sont vérifiées, on passe aux modifications des champs de profil
        if($_POST['mdp'] == $result_fetch_user_info[0][4]){
            if($_POST['profil_pseudo'] !== null 
            && $_POST['profil_pseudo'] !==  $result_fetch_user_info[0][1]){
                $update_user_profil = "UPDATE utilisateurs 
                SET login = '$_POST[profil_pseudo]' WHERE id= '$_SESSION[userID]'";
                $query_update_user_profil = $mysqli->query($update_user_profil);
                $message_profil = "informations modifiées.";
            }

            if($_POST['profil_prenom'] !== null 
            && $_POST['profil_prenom'] !==  $result_fetch_user_info[0][2]){   
            $update_user_profil = "UPDATE utilisateurs 
            SET prenom = '$_POST[profil_prenom]' WHERE id= '$_SESSION[userID]'";
            $query_update_user_profil = $mysqli->query($update_user_profil);
            $message_profil = "informations modifiées.";
            }

            if($_POST['profil_nom'] !== null 
            && $_POST['profil_nom'] !==  $result_fetch_user_info[0][3]){  
            $update_user_profil = "UPDATE utilisateurs 
            SET nom = '$_POST[profil_nom]' WHERE id= '$_SESSION[userID]'";
            $query_update_user_profil = $mysqli->query($update_user_profil);
            $message_profil = "informations modifiées.";
            }

            if($_POST['profil_new_mdp'] !== null && $_POST['profil_new_mdp'] == $_POST['new_mdp_confirm']){
                $update_user_profil = "UPDATE utilisateurs 
                SET password = '$_POST[profil_new_mdp]' WHERE id= '$_SESSION[userID]'";
                $query_update_user_profil = $mysqli->query($update_user_profil);
                $message_profil = "informations modifiées.";
            }
        } elseif($_POST['mdp'] !== $result_fetch_user_info[0][4] && isset($_POST['profil_change'])){
            $message_profil = 'Ancien mot de passe incorrect.';
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
    <link rel="stylesheet" href="formulaires.css">
    <title>Profil</title>
</head>
<body>
<div class="background">
<?php 
    include 'header.php';
?>
    <main>
        <h2>Veuillez remplir les champs que vous souhaitez modifier</h2>
        <h3>
           <?php 
                if(isset($_POST['profil_change'])) { 
                        echo $message_profil;
                }
            ?>
        </h3>
        <form method="post" class="formulaire">

            <label for="pseudo">Pseudo : </label>
            <input type="text" class="form_input" name="profil_pseudo" 
            value="<?php echo $result_fetch_user_info[0][1]?>">

            <label for="prenom">Prénom : </label>
            <input type="text" class="form_input" name="profil_prenom" 
            value="<?php echo $result_fetch_user_info[0][2]?>">

            <label for="nom">Nom : </label>
            <input type="text" class="form_input" name="profil_nom" 
            value="<?php echo $result_fetch_user_info[0][3]?>">
            
<!-- infos des values récupérées grâce à ma requête sql du haut de la page -->

            <label for="new_mdp">Nouveau mot de passe : </label>
            <input type="password" class="form_input" name="profil_new_mdp" >

            <label for="new_mdp_confirm">Confirmez votre nouveau mot de passe : </label>
            <input type="password" class="form_input" name="new_mdp_confirm">

            <label for="mdp">Tapez votre ancien mot de passe pour confirmer les changements : </label>
            <input type="password" class="form_input" name="mdp">

            <button type="submit" class="form_button" name="profil_change">Modifier</button>
        </form>
    </main>
</div>
</body>
</html>