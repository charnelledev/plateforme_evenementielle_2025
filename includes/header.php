<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Plateforme Événementielle 2025</title>
    <link href="/evenement_2025/assets/css/tailwind.css" rel="stylesheet">
    <link href="src/output.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <header class="bg-white shadow">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/evenement_2025/index.php" class="text-2xl font-bold text-blue-700">Événements 2025</a>
            <nav class="space-x-4">
                <a href="index.php" class="text-gray-700 hover:text-blue-600 font-medium">Accueil</a>
                
                <?php if ($isLoggedIn): ?>
                    <a href="dashboard.php" class="text-gray-700 hover:text-blue-600 font-medium">Tableau de bord</a>
                    <?php if ($isAdmin): ?>
                        <a href="admin_panel.php" class="text-gray-700 hover:text-red-600 font-medium">Admin</a>
                    <?php endif; ?>
                    <a href="logout.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Déconnexion</a>
                <?php else: ?>
                    <a href="login.php" class="text-gray-700 hover:text-blue-600 font-medium">Connexion</a>
                    <a href="register.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Inscription</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
