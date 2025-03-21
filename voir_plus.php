<?php
require "connexion.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT p.*, e.nom, e.prenom 
            FROM pointages p
            JOIN employer e ON p.employer_id = e.id
            WHERE p.id = :id";
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
    <title>Détails du Pointage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="card shadow-lg">
            <div class="card-header text-center bg-primary text-white">
                <h2>Détails du Pointage</h2>
            </div>
            <div class="card-body">
                <p><strong>Employé : </strong><?= htmlspecialchars($pointage['nom'] . ' ' . $pointage['prenom']); ?></p>
                <p><strong>Date : </strong><?= htmlspecialchars($pointage['date']); ?></p>
                <p><strong>Libellé : </strong><?= htmlspecialchars($pointage['libellé']); ?></p>
                <p><strong>Présences : </strong><?= htmlspecialchars($pointage['nbr_présence']); ?></p>
            </div>
            <div class="card-footer text-start">
                <a href="index.php" class="btn btn-primary">Retour</a>
            </div>
        </div>
    </div>
</body>

</html>
