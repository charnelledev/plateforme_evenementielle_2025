<?php
require_once 'includes/database.php';
require_once 'includes/header.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["mot_de_passe"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["role"] = $user["role"];
        $_SESSION["nom"] = $user["nom"];
        $_SESSION["image"] = $user["image"];

        header("Location: dashboard.php");
        exit;
    } else {
        $message = "Identifiants incorrects.";
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
            <h2 class="text-2xl font-bold mb-4 text-center text-blue-700">Connexion</h2>
            <?php if ($message): ?>
                <p class="text-red-500 text-sm text-center mb-2"><?= $message ?></p>
                <?php endif; ?>
                <form method="POST" class="space-y-4">
                    <input type="email" name="email" required placeholder="Email" class="w-full border rounded px-4 py-2">
                    <input type="password" name="password" required placeholder="Mot de passe" class="w-full border rounded px-4 py-2">
                    <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">Se connecter</button>
                </form>
                <p class="text-sm text-center mt-4">Pas encore de compte ? <a href="register.php" class="text-blue-600 hover:underline">S'inscrire</a></p>
            </div>
        </div>
        
        <?php require_once 'includes/footer.php'; ?>
        
    </body>
    </html>