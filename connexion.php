<?php
try{
    $connexion = new PDO("mysql:host=localhost;dbname=pointage;charset=utf8", "root", "");
    $connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connexion réussie!";
}catch(PDOException $e){
    die("erreur de connexion : " . $e->getMessage()); 
}

?>