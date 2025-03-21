<?php
session_start();
require "connexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $adresse = trim($_POST['adresse']);
    $email = trim($_POST['email']);
    $telephone = trim($_POST['telephone']);
    $poste = trim($_POST['poste']);
    $mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);

    $check = $connexion->prepare("SELECT id FROM employer WHERE email = :email");
    $check->execute([':email' => $email]);
    if ($check->rowCount() > 0) {
        $_SESSION['error'] = "Cet email est déjà utilisé. Veuillez en choisir un autre.";
        header("Location: inscription.php");
        exit();
    }

    $sql = "INSERT INTO employer (nom, prenom, adresse, email, telephone, poste, mot_de_passe) 
            VALUES (:nom, :prenom, :adresse, :email, :telephone, :poste, :mot_de_passe)";
    $stmt = $connexion->prepare($sql);

    if ($stmt->execute([
        ':nom' => $nom,
        ':prenom' => $prenom,
        ':adresse' => $adresse,
        ':email' => $email,
        ':telephone' => $telephone,
        ':poste' => $poste,
        ':mot_de_passe' => $mot_de_passe
    ])) {
        header("Location: login.php?inscription=success");
        exit();
    } else {
        $_SESSION['error'] = "Une erreur est survenue lors de l'inscription.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Inscription</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">

        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <h2 class="text-center text-primary">Créer un compte</h2>

        <div class="container border mt-4 py-3 w-75 bg-body-tertiary">
<form method="post" class="row g-3 needs-validation text-primary-emphasis" novalidate>
  <div class="col-md-4">
    <label for="validationCustom01" class="form-label">Nom</label>
    <input type="text" name="nom" class="form-control" id="validationCustom01" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Prénom</label>
    <input type="text" name="prenom" class="form-control" id="validationCustom02" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Adresse</label>
    <input type="text" name="adresse" class="form-control" id="validationCustom02" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Email</label>
    <input type="email" name="email" class="form-control" id="validationCustom02" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Téléphone</label>
    <input type="text" name="telephone" class="form-control" id="validationCustom02" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  <div class="col-md-4">
    <label for="validationCustom02" class="form-label">Poste</label>
    <input type="text" name="poste" class="form-control" id="validationCustom02" required>
    <div class="valid-feedback">
      Looks good!
    </div>
  </div>
  
  <div class="col-md-6">
    <label for="validationCustom03" class="form-label">Mot de passe</label>
    <input type="password" name="mot_de_passe" class="form-control" id="validationCustom03" required>
    <div class="invalid-feedback">
      Please provide a valid city.
    </div>
  </div>
  <div class="col-12">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
  </div>
  <div class="col-12">
  <button type="submit" class="btn btn-primary">S'inscrire</button>
  <a href="login.php" class="btn btn-secondary">Se connecter</a>
  </div>
</form>
</div>
    </div>

    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  const forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})()
    </script>
</body>

</html>

<?php session_write_close(); ?>

