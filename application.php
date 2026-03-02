<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Adoption Application - Furry Friends</title>
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
        <h1>Adoption Application</h1>
        <?php if (isset($_GET['success'])): ?>
            <p class="success-msg">Application submitted successfully! We will contact you soon.</p>
        <?php endif; ?>
        <?php if (isset($_GET['error'])): ?>
            <p class="error-msg"><?php echo htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>
        <p class="page-intro">
            Please complete the form below so we can learn more about you, your household,
            and what you are looking for in a companion animal.
        </p>
        <form action="applicationsaved.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="phonenumber">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" required>
            <label for="email">E-mail Address:</label>
            <input type="email" id="email" name="email" required>
            <label for="address">Home Address:</label>
            <input type="text" id="address" name="address" required>
            <label for="householdnumbers">Number of Household Members:</label>
            <input type="text" id="householdnumbers" name="householdnumbers" required>
            <label for="pets">Number of Pets in the Household:</label>
            <input type="text" id="pets" name="pets" required>
            <label for="petlist">List the Pets in the Household:</label>
            <input type="text" id="petlist" name="petlist">
            <label for="other">Provide Us With Any Additional Information:</label>
            <textarea id="other" name="other" rows="4"></textarea>
            <div>
                <button type="submit">Submit application</button>
            </div>
        </form>
    </main>
    <footer>
        <h4>&copy; 2023 Furry Friends Animal Shelter</h4>
    </footer>
</div>
</body>
</html>
