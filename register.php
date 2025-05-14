<?php
require_once 'includes/database.php';
require_once 'includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = $_POST["nom"];
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $role = "user";

    // Gestion de l'image de profil
    $imageName = "default_user.jpg";
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === 0) {
        $ext = pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
        $imageName = uniqid() . "." . $ext;
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $imageName);
    }

    $stmt = $pdo->prepare("INSERT INTO users (nom, email, mot_de_passe, role, image) VALUES (?, ?, ?, ?, ?)");
    if ($stmt->execute([$nom, $email, $password, $role, $imageName])) {
        header("Location: login.php");
        exit;
    } else {
        $message = "Erreur lors de l’inscription.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                    <input type="file" name="image" accept="image/*" class="w-full text-sm text-gray-500">
            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Créer mon compte</button>
        </form>
        <p class="text-sm text-center mt-4">Déjà inscrit ? <a href="login.php" class="text-blue-600 hover:underline">Se connecter</a></p>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>

</body>
</html>