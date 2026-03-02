<?php
/**
 * Run this once to add sample animals: http://localhost/seed_animals.php
 */
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'config.php';

echo "<h2>Animal Shelter - Seed Animals</h2>";

$conn = getDBConnection();

// Check if animals table exists
$r = mysqli_query($conn, "SHOW TABLES LIKE 'animals'");
if (!$r || mysqli_num_rows($r) == 0) {
    die("<p style='color:red'>The 'animals' table does not exist. Run <a href='setup_database.php'>setup_database.php</a> first.</p>");
}

// Count existing animals
$r = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM animals");
$row = mysqli_fetch_assoc($r);
$count = (int)$row['cnt'];

if ($count > 0) {
    echo "<p>You already have $count animal(s) in the database.</p>";
    echo "<p><a href='animals.php'>View animals page</a></p>";
    mysqli_close($conn);
    exit;
}

// Insert sample animals
$samples = [
    ['Lucas', '1.5 Years', 'Male', 'Domestic Medium Hair'],
    ['Juno', '3 Years', 'Male', 'Golden Retriever Mix'],
    ['Henry', '4 Years', 'Male', 'Pitbull Mix'],
    ['Cleo', '2 Years', 'Female', 'Domestic Short Hair'],
    ['Diamond', '3 Years', 'Female', 'Rottweiler'],
    ['Mocha', '3 Months', 'Female', 'Domestic Short Hair'],
    ['Miracle', '3 Years', 'Female', 'Pitbull Mix'],
    ['Caramel', '2 Years', 'Male', 'Domestic Short Hair'],
];

$stmt = mysqli_prepare($conn, "INSERT INTO animals (name, age, sex, breed) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    die("<p style='color:red'>Error: " . mysqli_error($conn) . "</p><p>Your animals table may have different columns. Run setup_database.php first.</p>");
}

foreach ($samples as $a) {
    mysqli_stmt_bind_param($stmt, "ssss", $a[0], $a[1], $a[2], $a[3]);
    mysqli_stmt_execute($stmt);
}
mysqli_stmt_close($stmt);
mysqli_close($conn);

echo "<p style='color:green'><strong>Success!</strong> Added " . count($samples) . " animals.</p>";
echo "<p><a href='animals.php'>View animals page</a> | <a href='index.php'>Home</a></p>";
