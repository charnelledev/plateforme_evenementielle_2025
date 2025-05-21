<?php
session_start();
require_once 'includes/database.php';
require_once 'models/inscription.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Récupérer l'id de l'événement
if (!isset($_GET['id_event']) || empty($_GET['id_event'])) {
    echo "ID de l'événement manquant.";
    exit();
}

$id_event = (int) $_GET['id_event'];

// Vérifier si l'utilisateur est déjà inscrit
if (isUserInscribed($user_id, $id_event)) {
    echo "Vous êtes déjà inscrit à cet événement.";
    exit();
}

// Ajouter l'inscription
if (addInscription($user_id, $id_event)) {
    echo "Inscription réussie !";
    // Optionnel : redirection vers tableau de bord ou liste événements
    // header('Location: dashboard.php');
    // exit();
} else {
    echo "Erreur lors de l'inscription, veuillez réessayer.";
}
?>
