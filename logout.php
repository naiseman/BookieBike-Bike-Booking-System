<?php
// Start the session
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if not logged in
    header("Location: index.html");
    exit();
}

// Check if the logout form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Destroy the session
    session_destroy();

    // Display a success message using JavaScript
    echo '<script>alert("You have successfully logged out."); window.location.href = "index.html";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout - BookieBike</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Logout Confirmation</h2>

        <p>Are you sure you want to logout?</p>

        <form method="post">
            <input type="submit" value="Logout">
        </form>
    </div>
</body>
</html>
