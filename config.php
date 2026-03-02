<?php
/**
 * Database configuration for Furry Friends Animal Shelter
 * Update these values for your XAMPP/MySQL setup
 */
define('DB_HOST', 'localhost');
define('DB_NAME', 'animal_shelter');
define('DB_USER', 'root');
define('DB_PASS', 'mysql');

function getDBConnection() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if (mysqli_connect_errno()) {
        die("Database connection error: " . mysqli_connect_error());
    }
    $conn->set_charset("utf8mb4");
    return $conn;
}
