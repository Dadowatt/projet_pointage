<?php
session_start();
require "connexion.php";
include "navbar.php";

$erreur = "";

// Si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $mot_de_passe = trim($_POST['mot_de_passe']);

    if (empty($email) || empty($mot_de_passe)) {
        $erreur = "Veuillez remplir tous les champs !";
    } else {
        try {
            // Rechercher l'utilisateur par email
            $requete = $connexion->prepare("SELECT * FROM employer WHERE email = ?");
            $requete->execute([$email]);
            $employe = $requete->fetch(PDO::FETCH_ASSOC);

            // Vérifier si l'utilisateur existe et si le mot de passe est correct
            if ($employe && password_verify($mot_de_passe, $employe['mot_de_passe'])) {
                // Enregistrer les informations en session
                $_SESSION['employe_id'] = $employe['id'];
                $_SESSION['nom'] = $employe['nom'];
                $_SESSION['prenom'] = $employe['prenom'];
                $_SESSION['email'] = $employe['email'];
                $_SESSION['poste'] = $employe['poste'];

                // Rediriger vers le dashboard
                header("Location: index.php");
                exit();
            } else {
                $erreur = "Email ou mot de passe incorrect !";
            }
        } catch (PDOException $e) {
            $erreur = "Erreur de connexion : " . $e->getMessage();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">Connexion</h2>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= $erreur ?></div>
    <?php endif; ?>

    <form action="" method="POST" class="bg-body-tertiary p-4 needs-validation mt-3 form-control mx-auto" novalidate style="width: 500px;">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>

        <div class="mb-3">
            <label for="mot_de_passe" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
        </div>

        <div class="mb-3 py-3">
            <button class="btn btn-primary w-100" type="submit">Se connecter</button>
        </div>

        <div class="mb-3 text-center mt-3">
            <a href="inscription.php">Créer un compte</a>
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
