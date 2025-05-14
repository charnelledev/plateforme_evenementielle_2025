<?php
require_once 'includes/database.php';
require_once 'models/event.php'; // Assure-toi que cette fonction est bien définie dans ton modèle

// Vérifie si l'ID de l'événement est passé dans l'URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];
    $event = getEventById($event_id); // Récupère les données de l'événement par ID
} else {
    // Redirige si aucun ID n'est passé
    header('Location: dashboard.php');
    exit();
}

// Vérifie si le formulaire a été soumis pour mettre à jour l'événement
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupère les données du formulaire
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $date_event = $_POST['date_event'];
    $heure_event = $_POST['heure_event'];
    $lieu = $_POST['lieu'];
    $capacite = $_POST['capacite'];
    $image_event = $_FILES['image_event']['name'];

    // Gérer l'upload de l'image (si une nouvelle image est téléchargée)
    if (!empty($image_event)) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image_event);
        move_uploaded_file($_FILES['image_event']['tmp_name'], $target_file);
    } else {
        // Si l'image n'est pas modifiée, garder l'ancienne image
        $image_event = $event['image_event'];
    }

    // Mettre à jour l'événement
    if (updateEvent($event_id, $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event)) {
        // Rediriger vers le dashboard après la mise à jour
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Une erreur s'est produite lors de la mise à jour de l'événement.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'événement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Modifier l'événement</h1>

        <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>

        <form action="edit_event.php?id=<?php echo $event['id']; ?>" method="POST" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700">Titre de l'événement</label>
                <input type="text" name="titre" id="titre" value="<?php echo htmlspecialchars($event['titre']); ?>" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full p-2 border border-gray-300 rounded"><?php echo htmlspecialchars($event['description']); ?></textarea>
            </div>

            <div>
                <label for="date_event" class="block text-sm font-medium text-gray-700">Date de l'événement</label>
                <input type="date" name="date_event" id="date_event" value="<?php echo htmlspecialchars($event['date_event']); ?>" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label for="heure_event" class="block text-sm font-medium text-gray-700">Heure de l'événement</label>
                <input type="time" name="heure_event" id="heure_event" value="<?php echo htmlspecialchars($event['heure_event']); ?>" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label for="lieu" class="block text-sm font-medium text-gray-700">Lieu de l'événement</label>
                <input type="text" name="lieu" id="lieu" value="<?php echo htmlspecialchars($event['lieu']); ?>" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label for="capacite" class="block text-sm font-medium text-gray-700">Capacité</label>
                <input type="number" name="capacite" id="capacite" value="<?php echo htmlspecialchars($event['capacite']); ?>" class="w-full p-2 border border-gray-300 rounded">
            </div>

            <div>
                <label for="image_event" class="block text-sm font-medium text-gray-700">Image de l'événement</label>
                <input type="file" name="image_event" id="image_event" class="w-full p-2 border border-gray-300 rounded">
                <p class="text-gray-500 text-sm mt-1">L'image actuelle est : <?php echo $event['image_event']; ?></p>
            </div>

            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Mettre à jour l'événement</button>
        </form>
    </div>
</body>
</html>
