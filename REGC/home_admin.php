<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Admin</title>
    <link rel="stylesheet" href="style.css"> <!-- Use the same style sheet as home.php -->
</head>
<body>

<header>
    <nav>
        <ul>
            <li><a href="home_admin.php">Home</a></li>
            <li><a href="property_admin.php">Property</a></li>
            <li><a href="consultation_admin.php">Consultation</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
</header>

<div class="logo-container">
    <img class="logo" src="RealEstate Logo.png" alt="Real Estate Logo">
</div>

<section id="welcome-section">
    <div class="container">
        <?php
        session_start();

        // Check if the 'users' session key is set
        if (isset($_SESSION['admins'])) {
            echo "<h2>Welcome, " . $_SESSION['admins']['firstName'] . " " . $_SESSION['admins']['lastName'] . "!</h2>";
        }
        ?>
    </div>
</section>

<footer>
    <div class="footer-content">
        <p>&copy; 2024 Real Estate Governance and Consultation</p>
    </div>
</footer>

</body>
</html>
