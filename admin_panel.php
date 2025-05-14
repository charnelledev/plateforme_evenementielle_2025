<?php
// Fichier : admin_panel.php

session_start();

// Inclure la connexion à la base de données et les fonctions nécessaires
require_once 'includes/db.php';
require_once 'models/user.php';
require_once 'models/inscription.php';
require_once 'models/event.php';

// Vérifier si l'utilisateur est connecté et s'il est admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: login.php');
    exit();
}

// Fonction pour récupérer les utilisateurs
$users = getUsers();

// Fonction pour récupérer les inscriptions
$inscriptions = getInscriptions();

// Fonction pour récupérer les événements
$events = getEvents();

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau Admin</title>
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- Ajouter ici le lien vers votre fichier CSS personnalisé ou Tailwind -->
</head>
<body>

    <?php include 'includes/header.php'; ?>

    <!-- Panneau admin -->
    <div class="container mx-auto my-6">
        <h1 class="text-3xl font-semibold mb-4">Panneau Administrateur</h1>

        <!-- Gestion des inscriptions -->
<section>
    <h2 class="text-2xl font-semibold mb-2">Gestion des Inscriptions</h2>
    <table class="min-w-full bg-white border border-gray-200">
        <thead>
            <tr class="bg-gray-100 text-sm text-gray-700 uppercase">
                <th class="px-4 py-2 text-left">Utilisateur</th>
                <th class="px-4 py-2 text-left">Événement</th>
                <th class="px-4 py-2 text-left">Statut</th>
                <th class="px-4 py-2 text-left">Date</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($inscriptions as $inscription): ?>
            <tr class="border-t text-sm">
                <td class="px-4 py-2"><?= htmlspecialchars($inscription['user_nom']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($inscription['event_titre']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($inscription['statut']) ?></td>
                <td class="px-4 py-2"><?= htmlspecialchars($inscription['date_inscription']) ?></td>
                <td class="px-4 py-2 space-x-2">
                    <a href="update_inscription.php?id=<?= $inscription['id'] ?>" class="text-blue-600 hover:underline">Modifier</a>
                    <a href="delete_inscription.php?id=<?= $inscription['id'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Supprimer cette inscription ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</section>


        <!-- Gestion des événements -->
        <section class="mb-8">
            <h2 class="text-2xl font-semibold mb-2">Gestion des Événements</h2>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Titre</th>
                        <th class="px-4 py-2 text-left">Date</th>
                        <th class="px-4 py-2 text-left">Lieu</th>
                        <th class="px-4 py-2 text-left">Créateur</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($events as $event): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($event['titre']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($event['date_event']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($event['lieu']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($event['id_createur']) ?></td>
                            <td class="px-4 py-2">
                                <a href="edit_event.php?id=<?= $event['id'] ?>" class="text-blue-500">Modifier</a>
                                | 
                                <a href="delete_event.php?id=<?= $event['id'] ?>" class="text-red-500">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

        <!-- Gestion des inscriptions -->
        <section>
            <h2 class="text-2xl font-semibold mb-2">Gestion des Inscriptions</h2>
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-4 py-2 text-left">Utilisateur</th>
                        <th class="px-4 py-2 text-left">Événement</th>
                        <th class="px-4 py-2 text-left">Statut</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($inscriptions as $inscription): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($inscription['id_utilisateur']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($inscription['id_event']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($inscription['statut']) ?></td>
                            <td class="px-4 py-2">
                                <a href="update_inscription.php?id=<?= $inscription['id'] ?>" class="text-blue-500">Modifier</a>
                                | 
                                <a href="delete_inscription.php?id=<?= $inscription['id'] ?>" class="text-red-500">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>

    </div>

    <?php include 'includes/footer.php'; ?>

</body>
</html>
