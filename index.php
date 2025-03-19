<?php
require "connexion.php";

$sql = "SELECT * FROM pointages";
$query = $connexion->query($sql);
$pointages = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Pointage</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
            flex-direction: column;
        }

        .main-container {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .c-middle{
            overflow-y: scroll;
        }

        .sidebar {
            width: 250px;
            background-color: #343a40;
            color: white;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #495057;
            border-radius: 8px;
        }

        .content {
            flex: 1;
            padding: 20px;
            overflow-y: auto;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#"><i class="bi bi-clock-fill me-1"></i> Pointage</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Accueil</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Profil</a></li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-container">

        <div class="sidebar">
            <h4 class="text-center">Menu</h4>
            <a href="#">🏠 Dashboard</a>
            <a href="#">➕ Ajouter un pointage</a>
            <a href="#">📋 Liste des pointages</a>
            <a href="logout.php" class="mt-auto">🚪 Déconnexion</a>
        </div>

        <div class="container c-middle mt-5">
            <h2 class="mb-4">Mes Pointages</h2>
            <a href="ajouter.php" class="btn btn-success mb-3">➕ Ajouter un Pointage</a>

            <?php foreach ($pointages as $pointage): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Pointage du <?= htmlspecialchars($pointage['date']); ?></h5>
                        <p class="card-text"><strong>Libellé : </strong><?= htmlspecialchars($pointage['libellé']); ?></p>
                        <p class="card-text"><strong>Présences : </strong><?= htmlspecialchars($pointage['nbr_présence']); ?></p>

                        <a href="voir_plus.php?id=<?= $pointage['id']; ?>" class="btn btn-info">Voir plus</a>
                        <a href="modifier.php?id=<?= $pointage['id']; ?>" class="btn btn-warning">Modifier</a>
                        <a href="supprimer.php?id=<?= $pointage['id']; ?>" class="btn btn-danger" onclick="return confirm('Confirmer la suppression ?');">Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
