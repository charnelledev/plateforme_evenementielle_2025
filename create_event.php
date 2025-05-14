<?php
session_start();
require_once './includes/db.php';
require_once './includes/check_login.php';
require_once './models/event.php';

$event = null; // pour un événement existant ou nouveau

// Si un ID d'événement est passé, on va modifier l'événement
if (isset($_GET['id'])) {
    $event = getEventById($_GET['id']);
    // Vérifier si l'utilisateur est le créateur de l'événement
    if ($event['createur_id'] != $_SESSION['user_id']) {
        header("Location: dashboard.php");
        exit();
    }
}

// Gestion du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_event = $_POST['date_event'];
    $heure_event = $_POST['heure_event'];
    $lieu = $_POST['lieu'];
    $capacite = $_POST['capacite'];
    $image_event = $_FILES['image_event']['name'] ? $_FILES['image_event']['name'] : 'event_default.jpg'; // image par défaut

    // Télécharger l'image
    if ($_FILES['image_event']['name']) {
        move_uploaded_file($_FILES['image_event']['tmp_name'], 'uploads/' . $image_event);
    }

    if ($event) {
        // Modification de l'événement
        updateEvent($event['id'], $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event);
        header("Location: dashboard.php");
        exit();
    } else {
        // Création d'un nouvel événement
        createEvent($_SESSION['user_id'], $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event);
        header("Location: dashboard.php");
        exit();
    }
}

?>

<?php include './includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6"><?= $event ? 'Modifier l\'événement' : 'Créer un événement' ?></h1>

    <form method="POST" enctype="multipart/form-data" class="space-y-6">
        <div>
            <label for="titre" class="block text-sm font-medium text-gray-700">Titre</label>
            <input type="text" id="titre" name="titre" value="<?= $event ? htmlspecialchars($event['titre']) : '' ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
            <textarea id="description" name="description" rows="4" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg"><?= $event ? htmlspecialchars($event['description']) : '' ?></textarea>
        </div>

        <div>
            <label for="date_event" class="block text-sm font-medium text-gray-700">Date de l'événement</label>
            <input type="date" id="date_event" name="date_event" value="<?= $event ? $event['date_event'] : '' ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="heure_event" class="block text-sm font-medium text-gray-700">Heure de l'événement</label>
            <input type="time" id="heure_event" name="heure_event" value="<?= $event ? $event['heure_event'] : '' ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="lieu" class="block text-sm font-medium text-gray-700">Lieu</label>
            <input type="text" id="lieu" name="lieu" value="<?= $event ? htmlspecialchars($event['lieu']) : '' ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="capacite" class="block text-sm font-medium text-gray-700">Capacité</label>
            <input type="number" id="capacite" name="capacite" value="<?= $event ? $event['capacite'] : '' ?>" required class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <div>
            <label for="image_event" class="block text-sm font-medium text-gray-700">Image de l'événement</label>
            <input type="file" id="image_event" name="image_event" class="mt-1 block w-full p-2 border border-gray-300 rounded-lg">
        </div>

        <button type="submit" class="w-full py-2 px-4 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg shadow-md">
            <?= $event ? 'Modifier l\'événement' : 'Créer l\'événement' ?>
        </button>
    </form>
</div>

<?php include './includes/footer.php'; ?>
