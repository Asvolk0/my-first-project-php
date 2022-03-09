<?php

require_once 'connect.php';

$formErrors = [];

if(isset($_POST['submit'])){
    $formErrors = validationForm();
    
    //Si notre form est valide alors on ajoute l'utilisateur
    if($formErrors['isFormValid'] == true){
        setUser();
    }
}

function setUser(){
    // requete sql pour envoyer des données dans la bdd lesPtitsDevs
    $requeteInscription = "INSERT INTO `lesptitsdevs` (`nom`, `prenom`, `sexe`, `mail`, `motDePasse`) 
    VALUES (:lastname, :prenom, :sex, :email, :password)";

    // execute la variable $preparationRequete, et envoie les valeurs grace au name des inputs
    $stm = PDOConnect($requeteInscription, [
        'lastname'=> $_POST['nom'],
        'prenom'=> $_POST['prenom'],
        // pour les booléen
        'sex'=> (int) isset($_POST['sexe']),
        'email'=> $_POST['email'],
        // pour cripter les mdp
        'password'=> password_hash($_POST['motDePasse'], PASSWORD_BCRYPT)
    ]);

    header('Location: ../../seConnecter.html');
    exit();
}

function recupValue(){
    $recupUtilisateur = "SELECT `nom`, `prenom`, `sexe` FROM `lesptitsdevs` ORDER BY `sexe` ASC";

    $stm = PDOConnect($recupUtilisateur);

    return $stm->fetchAll(PDO::FETCH_ASSOC);
}

function getMsgErrorForm($formErrors, $index){
    if(isset($formErrors[$index])){
        return $formErrors[$index];
    }else{
        return '';
    }
}

function validationForm():array {
    //Initialisation du tableau
    /**
     * Par defaut nous avons un cas passant
     * cad le formulaire est ok et pas de msg d'erreur
     */
    $errorForm = [
        'isFormValid' => true,
        'errMsgLastname' => null,
        'errMsgMail' => null,
    ];
    
    // test mail

    //Requete pour compter le nombre de mail existant pour celui du POST
    $sql = "SELECT count(id) as 'nbMail' FROM `lesptitsdevs` WHERE mail = :post_mail";
    $stm = PDOConnect($sql,[
        ':post_mail' => $_POST['email'],
    ]);
    $nbMail = $stm->fetch(PDO::FETCH_ASSOC);

    if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) == false){
        $errorForm['isFormValid'] = false;
        $errorForm['errMsgMail'] = 'Le format du courriel est invalide';
    }elseif($nbMail['nbMail'] > 0){
        //Si le nombre de mail est sup à 0
        $errorForm['isFormValid'] = false;
        $errorForm['errMsgMail'] = 'Ce courriel est déjà existant';
    }

    return $errorForm;
}

function changeColorStatusGenre($valueColor){
    if($valueColor != 1){
        $changeDeClass = 'colorHomme';
    }else{
        $changeDeClass = 'colorFemme';
    }

    return [
        'couleurChange' => $changeDeClass
    ];
}
?>