<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=diary', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException) {
    echo 'A prblem occured with the database connection...';
}
