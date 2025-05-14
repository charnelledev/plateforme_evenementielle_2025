<?php
// Fichier : models/user.php

// Inclure la connexion à la base de données
require_once 'includes/db.php';

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $conn;
    $query = "SELECT * FROM users";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        die('Erreur dans la requête: ' . mysqli_error($conn));
    }

    $users = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }

    return $users;
}

// Fonction pour récupérer un utilisateur par son ID
function getUserById($id) {
    global $conn;
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return $row;
    }

    return null;
}

// Fonction pour ajouter un utilisateur
function addUser($nom, $email, $password, $role) {
    global $conn;
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (nom, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ssss', $nom, $email, $password_hashed, $role);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour mettre à jour un utilisateur
function updateUser($id, $nom, $email, $role) {
    global $conn;
    $query = "UPDATE users SET nom = ?, email = ?, role = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'sssi', $nom, $email, $role, $id);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour supprimer un utilisateur
function deleteUser($id) {
    global $conn;
    $query = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $id);

    return mysqli_stmt_execute($stmt);
}

// Fonction pour vérifier si un utilisateur existe (pour l'authentification)
function userExists($email) {
    global $conn;
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_num_rows($result) > 0;
}

// Fonction pour vérifier le mot de passe
function verifyPassword($email, $password) {
    global $conn;
    $query = "SELECT password FROM users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        return password_verify($password, $row['password']);
    }

    return false;
}
?>
