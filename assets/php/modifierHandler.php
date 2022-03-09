<?php

require_once 'connect.php';

$formErrors = [];

if(isset($_POST['submitMotDePasse'])){
    MmodificationUserMotDePasse();
}

// -----------------------------------------------------------------------------------------------------------

if(isset($_POST['submitNom'])){
    MmodificationUserNom();
}


// -------------------------------------------------------------------------------------------------------------

if(isset($_POST['submitSexe'])){
    MmodificationUserSexe();
}



?>