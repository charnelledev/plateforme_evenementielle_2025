<?php
require_once 'includes/database.php';
require_once 'includes/header.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Récupérer les données du formulaire
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "user";

    // Vérification de l'email unique
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);

    if ($stmt->rowCount() > 0) {
        // L'email existe déjà, afficher un message d'erreur
        $message = "L'email est déjà utilisé.";
    } else {
        // Gestion de l'image de profil
        $imageName = "default_user.jpg";
        if (isset($_FILES["image_profil"]) && $_FILES["image_profil"]["error"] === 0) {
            $imageTmpName = $_FILES["image_profil"]["tmp_name"];
            $imageExtension = strtolower(pathinfo($_FILES["image_profil"]["name"], PATHINFO_EXTENSION));
            $allowedExtensions = ["jpg", "jpeg", "png", "gif"];
            
            if (in_array($imageExtension, $allowedExtensions)) {
                // Créer un nom unique pour l'image
                $imageName = uniqid() . "." . $imageExtension;
                // Déplacer l'image vers le dossier 'uploads'
                move_uploaded_file($imageTmpName, "uploads/" . $imageName);
            } else {
                $message = "Seules les images JPG, JPEG, PNG, GIF sont autorisées.";
            }
        }

        // Insérer les données dans la base de données
        $stmt = $pdo->prepare("INSERT INTO users (nom, email, password, role, image_profil) VALUES (?, ?, ?, ?, ?)");
        if ($stmt->execute([$nom, $email, $password, $role, $imageName])) {
            // Rediriger vers la page de connexion après inscription
            header("Location: login.php");
            exit;
        } else {
            $message = "Erreur lors de l’inscription.";
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
    <link href="./src/output.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto px-4 py-10">
        <div class="max-w-md mx-auto bg-white p-6 rounded-xl shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Inscription</h2>
            <?php if ($message): ?>
                <p class="text-red-500 text-sm text-center mb-2"><?= $message ?></p>
            <?php endif; ?>
            <form method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="text" name="nom" required placeholder="Nom complet" class="w-full border rounded px-4 py-2">
                <input type="email" name="email" required placeholder="Email" class="w-full border rounded px-4 py-2">
                <input type="password" name="password" required placeholder="Mot de passe" class="w-full border rounded px-4 py-2">
                <input type="file" name="image_profil" accept="image/*" class="w-full text-sm text-gray-500">
                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Créer mon compte</button>
            </form>
            <p class="text-sm text-center mt-4">Déjà inscrit ? <a href="login.php" class="text-blue-600 hover:underline">Se connecter</a></p>
        </div>
    </div>

    <?php require_once 'includes/footer.php'; ?>
</body>
</html>
