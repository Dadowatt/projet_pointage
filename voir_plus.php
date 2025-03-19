<?php
require "connexion.php";
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pointages WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $pointage = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$pointage) {
        die("Pointage introuvable.");
    }
} else {
    die("ID du pointage manquant.");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Détails du Pointage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h2>Détails du Pointage</h2>
        <p><strong>ID : </strong><?= htmlspecialchars($pointage['id']); ?></p>
        <p><strong>Date : </strong><?= htmlspecialchars($pointage['date']); ?></p>
        <p><strong>Libellé : </strong><?= htmlspecialchars($pointage['libellé']); ?></p>
        <p><strong>Présences : </strong><?= htmlspecialchars($pointage['nbr_présence']); ?></p>

        <a href="index.php" class="btn btn-primary">Retour</a>
    </div>

</body>

</html>
