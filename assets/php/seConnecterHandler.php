<?php

require_once 'connect.php';

if (isset($_POST['submit'])){


    $sql = "SELECT *
    FROM `lesptitsdevs` 
    WHERE mail = :mail_verify";

    $stm = PDOConnect($sql, [
        'mail_verify'=> $_POST['email']
    ]);

    $utilisateur = $stm->fetch(PDO::FETCH_ASSOC);

    if($utilisateur != false){
        $isVerify = password_verify($_POST['motDePasse'], $utilisateur['motDePasse']);

        if($isVerify == true){

            $_SESSION['user']['id'] = $utilisateur['id'];
            $_SESSION['user']['nom'] = $utilisateur['nom'];
            $_SESSION['user']['prenom'] = $utilisateur['prenom'];
            $_SESSION['user']['mail'] = $utilisateur['mail'];
            $_SESSION['user']['sexe'] = $utilisateur['sexe'];

            header('Location: card.html?nomUtilisateur='.$utilisateur['nom']);
            exit();
        }else{
            header('Location: erreur.html');
            exit();
        }
    }
}



?>