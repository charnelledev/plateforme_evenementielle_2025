<?php
// models/inscription.php

require_once 'includes/database.php';

// Fonction pour récupérer toutes les inscriptions
function getInscriptions() {
    global $pdo;

    $sql = "
        SELECT inscriptions.id, users.nom AS user_nom, events.titre AS event_titre,
               inscriptions.statut, inscriptions.date_inscription
        FROM inscriptions
        JOIN users ON inscriptions.id_utilisateur = users.id
        JOIN events ON inscriptions.id_event = events.id
        ORDER BY inscriptions.date_inscription DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour récupérer les inscriptions d'un utilisateur par son ID
function getInscriptionsByUser($user_id) {
    global $pdo;

    // Préparer la requête pour récupérer les inscriptions de l'utilisateur
    $sql = "SELECT * FROM inscriptions WHERE id_utilisateur = ? ORDER BY date_inscription DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
    $stmt->execute();

    // Retourner les inscriptions de l'utilisateur
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Fonction pour inscrire un utilisateur à un événement
function addInscription($id_utilisateur, $id_event) {
    global $pdo;
    $query = "INSERT INTO inscriptions (id_utilisateur, id_event, statut) VALUES (:id_utilisateur, :id_event, 'en_attente')";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $stmt->bindParam(':id_event', $id_event, PDO::PARAM_INT);

    return $stmt->execute();
}

// Fonction pour mettre à jour l'état de l'inscription (confirmer ou annuler)
function updateInscription($id, $statut) {
    global $pdo;
    $query = "UPDATE inscriptions SET statut = :statut WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':statut', $statut);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

// Fonction pour supprimer une inscription
function deleteInscription($id) {
    global $pdo;
    $query = "DELETE FROM inscriptions WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

// Fonction pour vérifier si un utilisateur est déjà inscrit à un événement
function isUserInscribed($id_utilisateur, $id_event) {
    global $pdo;
    $query = "SELECT * FROM inscriptions WHERE id_utilisateur = :id_utilisateur AND id_event = :id_event";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id_utilisateur', $id_utilisateur, PDO::PARAM_INT);
    $stmt->bindParam(':id_event', $id_event, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}
?>
