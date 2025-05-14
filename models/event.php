<?php
// Fichier : models/event.php

// Connexion à la base de données
require_once '../includes/db.php';

// Fonction pour créer un événement
function createEvent($createur_id, $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event) {
    global $conn;

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO events (titre, description, date_event, heure_event, lieu, capacite, image_event, id_createur) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssi", $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event, $createur_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour mettre à jour un événement
function updateEvent($event_id, $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event) {
    global $conn;

    // Préparer la requête de mise à jour
    $stmt = $conn->prepare("UPDATE events 
                            SET titre = ?, description = ?, date_event = ?, heure_event = ?, lieu = ?, capacite = ?, image_event = ? 
                            WHERE id = ?");
    $stmt->bind_param("sssssssi", $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event, $event_id);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour récupérer un événement par son ID
function getEventById($event_id) {
    global $conn;

    // Préparer la requête de sélection
    $stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->bind_param("i", $event_id);

    // Exécuter la requête
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier si l'événement existe
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }
}
?>
