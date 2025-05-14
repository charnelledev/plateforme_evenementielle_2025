<?php
// Inclure les fichiers nécessaires
require_once 'includes/database.php';
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Récupérer l'utilisateur actuellement connecté
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur existe
if (!$user) {
    echo "Utilisateur non trouvé!";
    exit();
}

// Traitement du formulaire de modification
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les nouvelles valeurs
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_confirm = $_POST['password_confirm'];
    $photo_profil = $_FILES['photo_profil'];

    // Vérification si le mot de passe est modifié
    if ($password !== "" && $password !== $password_confirm) {
        $error = "Les mots de passe ne correspondent pas!";
    } else {
        // Hashage du mot de passe si modifié
        if ($password !== "") {
            $password = password_hash($password, PASSWORD_BCRYPT);
        } else {
            $password = $user['password'];  // garder le mot de passe existant
        }

        // Gestion de la photo de profil
        if ($photo_profil['error'] === 0) {
            // Vérifier si le fichier est une image valide
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($photo_profil['type'], $allowed_types)) {
                // Générer un nom unique pour la photo et déplacer le fichier
                $photo_name = 'profil_' . $user_id . '.' . pathinfo($photo_profil['name'], PATHINFO_EXTENSION);
                $photo_path = 'uploads/' . $photo_name;

                if (move_uploaded_file($photo_profil['tmp_name'], $photo_path)) {
                    // Si l'upload a réussi, mettre à jour le chemin de la photo dans la base de données
                    $sql = "UPDATE users SET nom = :nom, email = :email, password = :password, photo_profil = :photo_profil WHERE id = :id";
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nom', $nom);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':photo_profil', $photo_path);
                    $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
                }
            } else {
                $error = "Seuls les fichiers image sont autorisés (jpeg, png, gif).";
            }
        } else {
            // Si aucune photo n'a été téléchargée, ne pas modifier la photo
            $sql = "UPDATE users SET nom = :nom, email = :email, password = :password WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':id', $user_id, PDO::PARAM_INT);
        }

        if ($stmt->execute()) {
            // Message de succès
            $success = "Profil mis à jour avec succès!";
            $_SESSION['nom'] = $nom; // Mettre à jour la session
        } else {
            $error = "Erreur lors de la mise à jour du profil!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier le Profil</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="max-w-3xl mx-auto my-12 p-8 bg-white shadow-lg rounded-lg">
        <h2 class="text-2xl font-semibold text-center">Modifier mon Profil</h2>

        <?php if (isset($success)) { ?>
            <div class="bg-green-500 text-white p-3 rounded mt-4">
                <?= $success; ?>
            </div>
        <?php } ?>

        <?php if (isset($error)) { ?>
            <div class="bg-red-500 text-white p-3 rounded mt-4">
                <?= $error; ?>
            </div>
        <?php } ?>

        <form action="edit_profil.php" method="POST" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="nom" class="block text-sm font-medium text-gray-700">Nom</label>
                <input type="text" id="nom" name="nom" value="<?= htmlspecialchars($user['nom']); ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" value="<?= htmlspecialchars($user['email']); ?>" class="mt-1 block w-full p-2 border border-gray-300 rounded" required>
            </div>

            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Nouveau Mot de Passe</label>
                <input type="password" id="password" name="password" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="password_confirm" class="block text-sm font-medium text-gray-700">Confirmer le Mot de Passe</label>
                <input type="password" id="password_confirm" name="password_confirm" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <label for="photo_profil" class="block text-sm font-medium text-gray-700">Changer la Photo de Profil</label>
                <input type="file" id="photo_profil" name="photo_profil" class="mt-1 block w-full p-2 border border-gray-300 rounded">
            </div>

            <div class="mb-4">
                <button type="submit" class="w-full py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Mettre à Jour</button>
                <?php
                 ?>
            </div>
        </form>
    </div>
</body>
</html>
