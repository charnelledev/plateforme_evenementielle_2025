<?php
// Fichier : events.php
session_start();
require_once 'includes/database.php';
require_once 'models/event.php';

// Vérifie si l'utilisateur est connecté (optionnel selon usage)
$is_logged_in = isset($_SESSION['user_id']);

$events = getEvents();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des événements</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'includes/header.php'; ?>

<div class="container mx-auto my-8 px-4">
    <h1 class="text-3xl font-bold mb-6 text-center">📅 Événements à venir</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php foreach ($events as $event): ?>
            <div class="bg-white rounded-xl shadow-md p-5 hover:shadow-xl transition duration-300">
                <h2 class="text-xl font-semibold text-indigo-600 mb-2"><?= htmlspecialchars($event['titre']) ?></h2>
                <p class="text-gray-700 mb-1"><strong>Date :</strong> <?= htmlspecialchars($event['date_event']) ?></p>
                <p class="text-gray-700 mb-1"><strong>Lieu :</strong> <?= htmlspecialchars($event['lieu']) ?></p>
                <p class="text-gray-600 text-sm mb-3"><?= nl2br(htmlspecialchars($event['description'])) ?></p>
                <p class="text-sm text-gray-500">Par : <?= htmlspecialchars($event['nom_createur']) ?></p>

                <?php if ($is_logged_in): ?>
                    <a href="inscrire.php?event_id=<?= $event['id'] ?>" class="mt-3 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                        S'inscrire
                    </a>
                <?php else: ?>
                    <a href="login.php" class="mt-3 inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Connectez-vous pour vous inscrire
                    </a>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
