<?php
// logout.php

session_start();

// Supprimer toutes les variables de session
$_SESSION = [];

// Détruire la session
session_destroy();

// Rediriger vers la page de connexion ou d'accueil
header('Location: login.php');
exit();
