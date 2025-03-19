<?php
require "connexion.php";
include "navbar.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pointages WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $pointage = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pointage) {
        die("Pointage non trouvé.");
    }
} else {
    die("ID du pointage manquant.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $libelle = isset($_POST['libelle']) ? implode(',', $_POST['libelle']) : '';
    $nbr_presence = intval($_POST['nbr_presence']);

    $sql = "UPDATE pointages SET libellé = :libelle, nbr_présence = :nbr_presence WHERE id = :id";
    $stmt = $connexion->prepare($sql);
    $stmt->execute([
        ':libelle' => $libelle,
        ':nbr_presence' => $nbr_presence,
        ':id' => $id
    ]);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Pointage</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Modifier un Pointage</h2>

        <form method="POST">
            <div class="mb-3">
                <label><strong>Actions :</strong></label><br>
                <input type="checkbox" name="libelle[]" value="Arrivée" <?= in_array('Arrivée', explode(',', $pointage['libellé'])) ? 'checked' : ''; ?>> Arrivée
                <input type="checkbox" name="libelle[]" value="Départ" <?= in_array('Départ', explode(',', $pointage['libellé'])) ? 'checked' : ''; ?>> Départ
                <input type="checkbox" name="libelle[]" value="Pause" <?= in_array('Pause', explode(',', $pointage['libellé'])) ? 'checked' : ''; ?>> Pause
            </div>

            <div class="mb-3">
                <label for="nbr_presence" class="form-label">Nombre de Présences :</label>
                <input type="number" name="nbr_presence" id="nbr_presence" class="form-control" value="<?= htmlspecialchars($pointage['nbr_présence']); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>
</html>
