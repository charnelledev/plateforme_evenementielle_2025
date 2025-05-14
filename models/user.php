<?php
// Fichier : models/user.php

// Inclure la connexion à la base de données
require_once 'includes/database.php';

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $pdo;
    $query = "SELECT * FROM users";
    $stmt = $pdo->prepare($query);
    $stmt->execute();

    $users = [];
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $users[] = $row;
    }

    return $users;
}

// Fonction pour récupérer un utilisateur par son ID
function getUserById($id) {
    global $pdo;
    $query = "SELECT * FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
}

// Fonction pour ajouter un utilisateur
function addUser($nom, $email, $password, $role) {
    global $pdo;
    $password_hashed = password_hash($password, PASSWORD_BCRYPT);

    $query = "INSERT INTO users (nom, email, password, role) VALUES (:nom, :email, :password, :role)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password_hashed);
    $stmt->bindParam(':role', $role);

    return $stmt->execute();
}

// Fonction pour mettre à jour un utilisateur
function updateUser($id, $nom, $email, $role) {
    global $pdo;
    $query = "UPDATE users SET nom = :nom, email = :email, role = :role WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':role', $role);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

// Fonction pour supprimer un utilisateur
function deleteUser($id) {
    global $pdo;
    $query = "DELETE FROM users WHERE id = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    return $stmt->execute();
}

// Fonction pour vérifier si un utilisateur existe (pour l'authentification)
function userExists($email) {
    global $pdo;
    $query = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    return $stmt->rowCount() > 0;
}

// Fonction pour vérifier le mot de passe
function verifyPassword($email, $password) {
    global $pdo;
    $query = "SELECT password FROM users WHERE email = :email";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        return password_verify($password, $row['password']);
    }

    return false;
}
?>

