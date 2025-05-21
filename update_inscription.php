<?php
// Fichier : update_inscription.php

session_start();
require_once 'includes/database.php';

// Vérification si admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "ID non fourni.";
    exit();
}

$id = intval($_GET['id']);

// Traitement du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $statut = $_POST['statut'];

    $stmt = $pdo->prepare("UPDATE inscriptions SET statut = ? WHERE id = ?");
    $stmt->execute([$statut, $id]);

    header('Location: admin_panel.php');
    exit();
}

// Récupération des données actuelles
$stmt = $pdo->prepare("SELECT * FROM inscriptions WHERE id = ?");
$stmt->execute([$id]);
$inscription = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$inscription) {
    echo "Inscription introuvable.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier Inscription</title>
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-lg mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Modifier le statut de l'inscription</h1>
        <form method="POST">
            <label class="block mb-2 font-semibold">Statut :</label>
            <select name="statut" class="w-full border border-gray-300 p-2 rounded mb-4">
                <option value="en attente" <?= $inscription['statut'] == 'en attente' ? 'selected' : '' ?>>En attente</option>
                <option value="confirmée" <?= $inscription['statut'] == 'confirmée' ? 'selected' : '' ?>>Confirmée</option>
                <option value="annulée" <?= $inscription['statut'] == 'annulée' ? 'selected' : '' ?>>Annulée</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Mettre à jour</button>
            <a href="admin_panel.php" class="ml-4 text-gray-600 hover:underline">Annuler</a>
        </form>
    </div>
</body>
</html>
