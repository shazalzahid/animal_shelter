<?php
require_once 'config.php';
$animals = [];
$dbError = '';
$conn = getDBConnection();
$result = mysqli_query($conn, "SELECT * FROM animals WHERE available = 1 ORDER BY name");
if ($result) {
    $animals = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    $dbError = mysqli_error($conn);
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Animals - Furry Friends</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="site-wrapper">
    <header>
        <nav>
            <ul>
                <img src="logo.png" class="logo" alt="logo">
                <li><a href="index.php">Home</a></li>
                <li><a href="story.php">Our Story</a></li>
                <li><a href="animals.php">Animals</a></li>
                <li><a href="application.php">Adoption</a></li>
                <li><a href="help.php">Help</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <h1>Animals Available</h1>
        <?php if (!empty($dbError)): ?>
        <p class="error-msg">Database error: <?php echo htmlspecialchars($dbError); ?>. Run <a href="setup_database.php">setup_database.php</a> first, then <a href="seed_animals.php">seed_animals.php</a>.</p>
        <?php endif; ?>
        <div class="animals">
            <?php foreach ($animals as $animal): ?>
            <div class="images">
                <img src="animal_image.php?id=<?php echo (int)$animal['id']; ?>" alt="<?php echo htmlspecialchars($animal['name']); ?>">
                <p><?php echo htmlspecialchars($animal['name'] . ', ' . $animal['age'] . ', ' . $animal['sex'] . ', ' . $animal['breed']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($animals)): ?>
        <p>No animals available at the moment. Check back soon!</p>
        <?php endif; ?>
    </main>
    <footer>
        <h4>&copy; 2023 Furry Friends Animal Shelter</h4>
    </footer>
</div>
</body>
</html>
