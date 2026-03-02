<?php
/**
 * Database setup script - Run once to create database and tables
 * Access via: http://localhost/AnimalShelterWebsite%207/setup_database.php
 */
$host = "localhost";
$user = "root";
$pass = "";

$conn = mysqli_connect($host, $user, $pass);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "CREATE DATABASE IF NOT EXISTS animal_shelter CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";
if (mysqli_query($conn, $sql)) {
    echo "Database 'animal_shelter' created or already exists.<br>";
} else {
    die("Error creating database: " . mysqli_error($conn));
}

mysqli_select_db($conn, "animal_shelter");

// Applications table
$sql = "CREATE TABLE IF NOT EXISTS applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    phonenumber VARCHAR(50) NOT NULL,
    email VARCHAR(255) NOT NULL,
    address TEXT NOT NULL,
    householdnumbers VARCHAR(20) NOT NULL,
    pets VARCHAR(20) NOT NULL,
    petlist TEXT,
    other_info TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'applications' created or already exists.<br>";
} else {
    die("Error creating applications table: " . mysqli_error($conn));
}

// Animals table (no image_path - images stored in DB only)
$sql = "CREATE TABLE IF NOT EXISTS animals (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    age VARCHAR(50) NOT NULL,
    sex VARCHAR(20) NOT NULL,
    breed VARCHAR(255) NOT NULL,
    image_data LONGBLOB NULL,
    image_mime VARCHAR(50) NULL,
    description TEXT,
    available TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'animals' created or already exists.<br>";
} else {
    die("Error creating animals table: " . mysqli_error($conn));
}

// Migration: add image_data/image_mime if missing, remove legacy image_path
$r = mysqli_query($conn, "SHOW COLUMNS FROM animals LIKE 'image_data'");
if ($r && mysqli_num_rows($r) === 0) {
    mysqli_query($conn, "ALTER TABLE animals ADD COLUMN image_data LONGBLOB NULL");
    echo "Added 'image_data' column.<br>";
}
$r = mysqli_query($conn, "SHOW COLUMNS FROM animals LIKE 'image_mime'");
if ($r && mysqli_num_rows($r) === 0) {
    mysqli_query($conn, "ALTER TABLE animals ADD COLUMN image_mime VARCHAR(50) NULL");
    echo "Added 'image_mime' column.<br>";
}
$r = mysqli_query($conn, "SHOW COLUMNS FROM animals LIKE 'image_path'");
if ($r && mysqli_num_rows($r) > 0) {
    mysqli_query($conn, "ALTER TABLE animals DROP COLUMN image_path");
    echo "Removed legacy 'image_path' column.<br>";
}

// Admin users table
$sql = "CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
if (mysqli_query($conn, $sql)) {
    echo "Table 'admin_users' created or already exists.<br>";
} else {
    die("Error creating admin_users table: " . mysqli_error($conn));
}

// Seed sample animals if table is empty (no images - add via admin)
$r = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM animals");
$row = mysqli_fetch_assoc($r);
if ($row['cnt'] == 0) {
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
    foreach ($samples as $a) {
        mysqli_stmt_bind_param($stmt, "ssss", $a[0], $a[1], $a[2], $a[3]);
        mysqli_stmt_execute($stmt);
    }
    echo "Seeded " . count($samples) . " animals. Log in to admin to add photos.<br>";
}

// Default admin (username: admin, password: admin123)
$r = mysqli_query($conn, "SELECT COUNT(*) as cnt FROM admin_users");
$row = mysqli_fetch_assoc($r);
if ($row['cnt'] == 0) {
    $username = 'admin';
    $password_hash = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = mysqli_prepare($conn, "INSERT INTO admin_users (username, password_hash) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password_hash);
    mysqli_stmt_execute($stmt);
    echo "Default admin created (username: admin, password: admin123). Change this after first login!<br>";
}

mysqli_close($conn);
echo "<br><strong>Setup complete!</strong> <a href='index.php'>Go to website</a> | <a href='admin/login.php'>Admin login</a>";
