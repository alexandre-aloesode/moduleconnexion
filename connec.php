<?php

    if(session_id() == ''){
        session_start();
     }

    if(isset($_GET['deco']) && $_GET['deco'] == 'deco'){
        session_destroy();
        header('Location: index.php');
    }

    $check = 0;
// Le $check me sert pour la connexion. si $check = 0 le user n'existe pas, 
// si = 1 le nom d'user et le mdp ne correspondent pas
// si =2 tout est bon et la connexion se fait
    $message;

    if(isset($_POST['connexion']))
    {
        include 'connecSQL.php';
        $request_connexion= "SELECT `login`, `password`,`id` FROM `utilisateurs`";
        $query_connexion = $mysqli->query($request_connexion);
        $result = $query_connexion->fetch_all();
        for($x = 0; isset($result[$x]); $x++){
            if($result[$x][0] == $_POST['pseudo']){
                $check ++;
                    if($result[$x][1] == $_POST['mdp']){
                        $check ++;
                        $_SESSION['userID'] = $result[$x][2];
// le $_SESSION['userID'] permet de récupérer l'ID du user au cas où il souhaite modifier son profil
// et pour lui afficher ses infos comme demandé dans l'énoncé.
// Ma requête sql demande login, mdp et id donc l'index 2 est bien l'id si $x trouve un user existant 
                    }
            }       
          }
        if($check == 0){
            $message = "Ce nom d'utilisateur n'existe pas.";
        } elseif($check == 1){
            $message = "Le nom d'utilisateur et le mot de passe ne correspondent pas.";
        } elseif($check == 2){
            $message = "Connexion réussie.";
            $_SESSION['user'] = $_POST['pseudo'];
        }
    } 
?>