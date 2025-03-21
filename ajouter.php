<?php
require "connexion.php";
include "navbar.php";
session_start();

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
            if (!isset($_SESSION['employe_id'])) {
                die("Erreur : employé non identifié !");
            }

            $sql = "INSERT INTO pointages (libellé, date, nbr_présence, employer_id) 
                    VALUES (:libelle, :date, :nbr_presence, :employer_id)";
            $query = $connexion->prepare($sql);
            $query->execute([
                ':libelle' => $libelle,
                ':date' => $date,
                ':nbr_presence' => $nbr_presence,
                ':employer_id' => $_SESSION['employe_id']
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <?php if (isset($error)): ?>
            <div class="alert alert-danger">
                <?= htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="form-control mx-auto py-4 bg-body-tertiary" style="width: 450px;">
            <h2 class="text-center">Ajouter un Pointage</h2>

            <div class="mb-3">
                <label class="mt-2"><strong>Actions :</strong></label><br>
                <input class="mt-2" type="checkbox" name="libelle[]" value="Arrivée"> Arrivée
                <input class="mt-2" type="checkbox" name="libelle[]" value="Pause"> Pause
                <input class="mt-2" type="checkbox" name="libelle[]" value="Départ"> Départ
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
