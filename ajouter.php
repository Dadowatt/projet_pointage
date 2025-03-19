<?php
require "connexion.php";
include "navbar.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST['libelle']) || empty($_POST['libelle'])) {
        $error = "Veuillez sélectionner au moins une action.";
    } else {
        $libelle = implode(',', $_POST['libelle']);
        $date = date('Y-m-d');
        $nbr_presence = intval($_POST['nbr_presence']);

        if ($nbr_presence <= 0) {
            $error = "Le nombre de présences doit être un nombre positif.";
        } else {

            $sql = "INSERT INTO pointages (libellé, date, nbr_présence) VALUES (:libelle, :date, :nbr_presence)";
            $stmt = $connexion->prepare($sql);
            $stmt->execute([
                ':libelle' => $libelle,
                ':date' => $date,
                ':nbr_presence' => $nbr_presence
            ]);
            header("Location: index.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Pointage</title>
</head>
<body>
    <div class="container mt-5">
        <h2>Ajouter un Pointage</h2>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label><strong>Actions :</strong></label><br>
                <input type="checkbox" name="libelle[]" value="Arrivée"> Arrivée
                <input type="checkbox" name="libelle[]" value="Pause"> Pause
                <input type="checkbox" name="libelle[]" value="Départ"> Départ
            </div>

            <div class="mb-3">
                <label for="nbr_presence" class="form-label">Nombre de Présences :</label>
                <input type="number" name="nbr_presence" id="nbr_presence" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Enregistrer</button>
            <a href="index.php" class="btn btn-secondary">Retour</a>
        </form>
    </div>
</body>
</html>
