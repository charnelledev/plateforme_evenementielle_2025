<?php
// Vérification de la session utilisateur
session_start();

// Si l'utilisateur n'est pas connecté, redirige vers la page de login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
