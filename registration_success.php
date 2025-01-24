<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Success - BookieBike</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 300px;
            text-align: center;
        }

        h2 {
            color: #28B463; /* Green color for success */
            margin-bottom: 20px;
        }

        p {
            margin-top: 15px;
            font-size: 16px;
            color: #333;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Registration Successful</h2>
        <?php
        // Check if 'username' key exists in the $_GET array
        if (isset($_GET['username'])) {
            echo '<p>Welcome, ' . $_GET['username'] . '! Your registration was successful.</p>';
        } else {
            echo '<p>Welcome! Your registration was successful.</p>';
        }
        ?>
        <p>Proceed to <a href="login.php">Login</a>.</p>
    </div>
</body>
</html>
