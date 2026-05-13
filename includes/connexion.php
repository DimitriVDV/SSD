<?php
$host    = 'localhost';
$dbname  = 'ssd';
$user    = 'root';
$pass    = '';
$charset = 'utf8mb4';

// DSN : Data Source Name
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// Options recommandees
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    // Lance une PDOException en cas d'erreur
    PDO::ATTR_DEFAULT_FETCH_MODE  => PDO::FETCH_ASSOC,
    // fetch() retourne un tableau associatif par defaut
    PDO::ATTR_EMULATE_PREPARES    => false,
    // Utiliser les vrais prepared statements du serveur
];


try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    // En production : logger l'erreur, pas l'afficher
    die('Connexion impossible : ' . $e->getMessage());
}