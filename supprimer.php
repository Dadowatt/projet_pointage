<?php
require "connexion.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pointages WHERE id = :id";
    $query = $connexion->prepare($sql);
    $query->bindParam(':id', $id, PDO::PARAM_INT);

    if ($query->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID du pointage manquant.";
}
?>

