<?php
// Fichier : models/inscription.php

// Inclure la connexion à la base de données
require_once 'includes/db.php';

// Fonction pour récupérer toutes les inscriptions


// models/inscription.php

require_once 'includes/db.php';

function getInscriptions() {
    global $pdo;

    $sql = "
        SELECT inscriptions.id, utilisateurs.nom AS user_nom, events.titre AS event_titre,
               inscriptions.statut, inscriptions.date_inscription
        FROM inscriptions
        JOIN utilisateurs ON inscriptions.id_utilisateur = utilisateurs.id
        JOIN events ON inscriptions.id_event = events.id
        ORDER BY inscriptions.date_inscription DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// function getInscriptions() {
//     global $conn;
//     $query = "SELECT i.id, i.id_utilisateur, i.id_event, i.statut, i.date_inscription, e.titre AS event_titre, u.nom AS user_nom
//               FROM inscriptions i
//               JOIN events e ON i.id_event = e.id
//               JOIN users u ON i.id_utilisateur = u.id";
//     $result = mysqli_query($conn, $query);

//     if (!$result) {
//         die('Erreur dans la requête: ' . mysqli_error($conn));
//     }

//     $inscriptions = [];
//     while ($row = mysqli_fetch_assoc($result)) {
//         $inscriptions[] = $row;
//     }

//     return $inscriptions;
// }

// Fonction pour récupérer une inscription par son ID
function getInscriptionById($id) {
    global $conn;
    $query = "SELECT * FROM inscriptions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }

    return null;
}

// Fonction pour inscrire un utilisateur à un événement
function addInscription($id_utilisateur, $id_event) {
    global $conn;
    $query = "INSERT INTO inscriptions (id_utilisateur, id_event, statut) VALUES (?, ?, 'en_attente')";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id_utilisateur, $id_event);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour mettre à jour l'état de l'inscription (confirmer ou annuler)
function updateInscription($id, $statut) {
    global $conn;
    $query = "UPDATE inscriptions SET statut = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'si', $statut, $id);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour supprimer une inscription
function deleteInscription($id) {
    global $conn;
    $query = "DELETE FROM inscriptions WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour vérifier si un utilisateur est déjà inscrit à un événement
function isUserInscribed($id_utilisateur, $id_event) {
    global $conn;
    $query = "SELECT * FROM inscriptions WHERE id_utilisateur = ? AND id_event = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ii', $id_utilisateur, $id_event);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) > 0;
}
?>
