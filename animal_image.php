<?php
require_once __DIR__ . '/config.php';

$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    exit;
}

$conn = getDBConnection();
$stmt = mysqli_prepare($conn, "SELECT image_data, image_mime FROM animals WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = $result ? mysqli_fetch_assoc($result) : null;
mysqli_close($conn);

if (!$row || empty($row['image_data'])) {
    // Return a placeholder SVG when no image is stored
    header('Content-Type: image/svg+xml');
    echo '<?xml version="1.0"?><svg xmlns="http://www.w3.org/2000/svg" width="300" height="200" viewBox="0 0 300 200"><rect fill="#e5e7eb" width="300" height="200"/><text x="150" y="110" fill="#9ca3af" font-size="14" font-family="sans-serif" text-anchor="middle">No photo yet</text><text x="150" y="130" fill="#9ca3af" font-size="11" font-family="sans-serif" text-anchor="middle">Add via admin</text></svg>';
    exit;
}

$mime = !empty($row['image_mime']) ? $row['image_mime'] : 'image/jpeg';
header('Content-Type: ' . $mime);
echo $row['image_data'];
