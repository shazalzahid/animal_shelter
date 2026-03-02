<?php
require_once 'config.php';

$conn = getDBConnection();

$username = 'admin';
$newPassword = 'admin123';

$hash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = mysqli_prepare(
    $conn,
    "INSERT INTO admin_users (username, password_hash)
     VALUES (?, ?)
     ON DUPLICATE KEY UPDATE password_hash = VALUES(password_hash)"
);
mysqli_stmt_bind_param($stmt, "ss", $username, $hash);
mysqli_stmt_execute($stmt);

mysqli_stmt_close($stmt);
mysqli_close($conn);

echo "Admin password reset. Username: admin, Password: " . htmlspecialchars($newPassword) . "<br><br>";
echo "<a href='admin/login.php'>Go to admin login</a>";
