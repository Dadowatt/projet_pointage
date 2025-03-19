<?php
require "connexion.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM pointages WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        header("Location: index.php");
        exit();
    } else {
        echo "Erreur lors de la suppression.";
    }
} else {
    echo "ID du pointage manquant.";
}
?>

