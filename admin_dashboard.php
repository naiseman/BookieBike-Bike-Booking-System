<!-- admin_dashboard.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
    background: linear-gradient(135deg, #ffffff, #6f7bff); /* Lighter gradient purple background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    animation: moveBackground 20s linear infinite; /* Animation for moving background */
    background-size: 200% 100%;
}

@keyframes moveBackground {
    0% {
        background-position: 0% 0%;
    }
    100% {
        background-position: 100% 0%;
    }
}


        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 25px;
            width: 350px;
            text-align: center;
        }

        h2 {
            color: #333;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin: 10px 0;
        }

        li a {
            display: block;
            padding: 10px;
            background: linear-gradient(135deg, #e1bee7, #9575cd); /* Gradient button color */
            color: #fff;
            text-decoration: none;
            border-radius: 4px;
        }

        li a:hover {
            background: linear-gradient(135deg, #ce93d8, #7e57c2); /* Gradient button color on hover */
        }

        form {
            margin-top: 20px;
        }

        input[type="submit"] {
            background: linear-gradient(#fd3e40, #ef7c5f,#f1959b); /* Gradient button color */
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: linear-gradient(#ef7c5f, #fd3e40); /* Gradient button color on hover */
        }

        /* Placeholder icon style (replace with your actual icon) */
        .icon {
            font-size: 48px;
            color: #fff;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
    <div class="icon">👤</div> <!-- Placeholder icon (replace with your actual icon) -->
        <h2>Welcome to the Admin Dashboard</h2>

        <ul>
            <li><a href="bike_management.php">Bike Management</a></li>
            <li><a href="user_management.php">User Management</a></li>
            <li><a href="booking_management.php">Booking Management</a></li>
        </ul>

        <!-- Add any other content or functionality specific to the admin dashboard -->

        <form action="logout.php" method="post">
            <input type="submit" value="Logout">
        </form>
    </div>
</body>
</html>
