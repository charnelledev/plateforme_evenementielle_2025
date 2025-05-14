<?php
require_once 'includes/database.php';
require_once 'models/event.php'; // Assure-toi que la fonction deleteEvent() est bien définie dans ton modèle

// Vérifie si l'ID de l'événement est passé dans l'URL
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Supprimer l'événement
    if (deleteEvent($event_id)) {
        // Rediriger vers le dashboard après la suppression
        header('Location: dashboard.php');
        exit();
    } else {
        $error_message = "Une erreur s'est produite lors de la suppression de l'événement.";
    }
} else {
    // Si l'ID n'est pas passé dans l'URL, redirige
    header('Location: dashboard.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supprimer l'événement</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-4">Supprimer l'événement</h1>

        <?php if (isset($error_message)) { echo "<p class='text-red-500'>$error_message</p>"; } ?>

        <p>Êtes-vous sûr de vouloir supprimer cet événement ?</p>
        <form action="delete_event.php?id=<?php echo $event_id; ?>" method="POST" class="space-y-4">
            <button type="submit" class="bg-red-500 text-white p-2 rounded">Supprimer</button>
            <a href="dashboard.php" class="bg-gray-500 text-white p-2 rounded">Annuler</a>
        </form>
    </div>
</body>
</html>
