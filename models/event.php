<?php

// Connexion à la base de données
require_once 'includes/database.php'; // Connexion DB si pas déjà incluse ailleurs

function getEvents() {
    global $pdo;
    $sql = "SELECT events.*, users.nom AS nom_createur
            FROM events
            LEFT JOIN users ON events.id_createur = users.id
            ORDER BY date_event ASC";
    $resultat = $pdo->query($sql);
    return $resultat->fetchAll(PDO::FETCH_ASSOC);
}



// Fonction pour récupérer les événements d'un créateur par son ID
function getEventsByCreateur($createur_id) {
    global $pdo;

    // Préparer la requête pour récupérer les événements du créateur
    $sql = "SELECT * FROM events WHERE id_createur = :createur_id ORDER BY date_event DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':createur_id', $createur_id, PDO::PARAM_INT);
    $stmt->execute();

    // Retourner les événements associés au créateur
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour créer un événement
function createEvent($createur_id, $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event) {
    global $pdo;

    // Préparer la requête d'insertion
    $sql = "INSERT INTO events (titre, description, date_event, heure_event, lieu, capacite, image_event, id_createur) 
            VALUES (:titre, :description, :date_event, :heure_event, :lieu, :capacite, :image_event, :createur_id)";
    $stmt = $pdo->prepare($sql);

    // Bind les paramètres pour l'exécution
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date_event', $date_event);
    $stmt->bindParam(':heure_event', $heure_event);
    $stmt->bindParam(':lieu', $lieu);
    $stmt->bindParam(':capacite', $capacite);
    $stmt->bindParam(':image_event', $image_event);
    $stmt->bindParam(':createur_id', $createur_id, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}

// Fonction pour mettre à jour un événement
function updateEvent($event_id, $titre, $description, $date_event, $heure_event, $lieu, $capacite, $image_event) {
    global $pdo;

    // Préparer la requête de mise à jour
    $sql = "UPDATE events 
            SET titre = :titre, description = :description, date_event = :date_event, heure_event = :heure_event, 
                lieu = :lieu, capacite = :capacite, image_event = :image_event 
            WHERE id = :event_id";
    $stmt = $pdo->prepare($sql);

    // Bind les paramètres pour l'exécution
    $stmt->bindParam(':titre', $titre);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':date_event', $date_event);
    $stmt->bindParam(':heure_event', $heure_event);
    $stmt->bindParam(':lieu', $lieu);
    $stmt->bindParam(':capacite', $capacite);
    $stmt->bindParam(':image_event', $image_event);
    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        return true;
    } else {
        return false;
    }
}
// Fonction pour supprimer un événement
function deleteEvent($event_id) {
    global $pdo;
    $query = "DELETE FROM events WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $event_id, PDO::PARAM_INT);
    return $stmt->execute();
}

// Fonction pour récupérer un événement par son ID
function getEventById($event_id) {
    global $pdo;

    // Préparer la requête de sélection
    $sql = "SELECT * FROM events WHERE id = :event_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':event_id', $event_id, PDO::PARAM_INT);

    // Exécuter la requête
    $stmt->execute();

    // Vérifier si l'événement existe
    if ($stmt->rowCount() > 0) {
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        return null;
    }
}
?>
