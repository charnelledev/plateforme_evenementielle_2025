<?php
// Fichier : delete_inscription.php

session_start();
require_once 'includes/database.php';

// Vérifier si l'utilisateur est admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Vérifier que l'ID est bien passé en GET
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $pdo->prepare("DELETE FROM inscriptions WHERE id = ?");
    $stmt->execute([$id]);

    header('Location: admin_panel.php');
    exit();
} else {
    echo "ID non fourni.";
}
?>
