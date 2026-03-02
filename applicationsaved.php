<?php
require_once 'config.php';

$errors = [];
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: application.php?error=' . urlencode('Invalid request.'));
    exit;
}

$name = trim($_POST['name'] ?? '');
$phonenumber = trim($_POST['phonenumber'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$householdnumbers = trim($_POST['householdnumbers'] ?? '');
$pets = trim($_POST['pets'] ?? '');
$petlist = trim($_POST['petlist'] ?? '');
$other_info = trim($_POST['other'] ?? '');

if (empty($name)) $errors[] = 'Name is required.';
if (empty($phonenumber)) $errors[] = 'Phone number is required.';
if (empty($email)) $errors[] = 'Email is required.';
if (empty($address)) $errors[] = 'Address is required.';
if (empty($householdnumbers)) $errors[] = 'Number of household members is required.';
if (empty($pets)) $errors[] = 'Number of pets is required.';

if (!empty($errors)) {
    header('Location: application.php?error=' . urlencode(implode(' ', $errors)));
    exit;
}

$conn = getDBConnection();
$stmt = mysqli_prepare($conn, "INSERT INTO applications (name, phonenumber, email, address, householdnumbers, pets, petlist, other_info) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
mysqli_stmt_bind_param($stmt, "ssssssss", $name, $phonenumber, $email, $address, $householdnumbers, $pets, $petlist, $other_info);
$ok = mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

if ($ok) {
    header('Location: application.php?success=1');
} else {
    header('Location: application.php?error=' . urlencode('Could not save application. Please try again.'));
}
exit;
