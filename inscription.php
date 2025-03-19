<?php

require "connexion.php";
include "navbar.php";
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération et nettoyage des données
    $nom = htmlspecialchars(trim($_POST['nom']));
    $prenom = htmlspecialchars(trim($_POST['prenom']));
    $adresse = htmlspecialchars(trim($_POST['adresse']));
    $email = htmlspecialchars(trim($_POST['email']));
    $telephone = htmlspecialchars(trim($_POST['telephone']));
    $poste = htmlspecialchars(trim($_POST['poste']));
    $mot_de_passe = trim($_POST['mot_de_passe']);

    // Liste des champs requis
    $champs_requis = ['nom', 'prenom', 'adresse', 'email', 'telephone', 'poste', 'mot_de_passe'];

    foreach ($champs_requis as $champ) {
        if (empty($_POST[$champ])) {
            $erreur = "Tous les champs requis doivent être remplis !";
            break;
        }
    }

    // Validation spécifique de l'email
    if (empty($erreur) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreur = "Adresse email invalide !";
    }

    // Si aucune erreur, on procède à l'insertion
    if (empty($erreur)) {
        try {
            // Hachage du mot de passe
            $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Préparer l'insertion
            $requete = $connexion->prepare("INSERT INTO employer (nom, prenom, adresse, email, telephone, poste, mot_de_passe) VALUES (?, ?, ?, ?, ?, ?, ?)");

            // Exécuter la requête
            if ($requete->execute([$nom, $prenom, $adresse, $email, $telephone, $poste, $mot_de_passe_hash])) {
                $_SESSION['message'] = "Inscription réussie ! Connectez-vous.";
                header("Location: login.php");
                exit();
            }
        } catch (PDOException $e) {
            $erreur = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container border mt-5 bg-body-tertiary">
        <h2 class="text-center mt-3">Inscription</h2>

        <?php if (!empty($erreur)): ?>
            <div class="alert alert-danger"> <?= $erreur ?> </div>
        <?php endif; ?>

        <form action="" method="POST" class="row g-3 needs-validation mt-3" novalidate>
            <div class="col-md-4">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom" name="nom" required>
            </div>
            <div class="col-md-4">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" class="form-control" id="prenom" name="prenom" required>
            </div>
            <div class="col-md-4">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" required>
            </div>
            <div class="col-md-4">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="col-md-4">
                <label for="telephone" class="form-label">Téléphone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" required>
            </div>
            <div class="col-md-4">
                <label for="poste" class="form-label">Poste</label>
                <input type="text" class="form-control" id="poste" name="poste" required>
            </div>
            <div class="col-md-6">
                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
            </div>

            <div class="col-12">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
                    <label class="form-check-label" for="invalidCheck">J'accepte les termes et conditions</label>
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary" type="submit">S'inscrire</button>
            </div>
        </form>
    </div>

    <script>
        (() => {
            'use strict';
            const forms = document.querySelectorAll('.needs-validation');

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        })();
    </script>
</body>
</html>
