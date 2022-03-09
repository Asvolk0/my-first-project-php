<?php 

session_start();

function PDOConnect($sql, $parametre = []){
    // cherche la bdd (avec son nom, mon id et mon mdp)
    $pdoConnect= new PDO( 
        'mysql:host=localhost;dbname=faireduphp;charset=UTF8',
        'root'
    );

    // message d'erreur
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // prepare la requete sql dans la variable $preparationRequete ,grace au pdo
    $preparationRequete = $pdoConnect->prepare($sql);

    $preparationRequete->execute($parametre);

    return $preparationRequete;
}

?>