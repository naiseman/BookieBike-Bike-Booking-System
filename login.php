<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Sanitize inputs to prevent SQL injection
    $username = mysqli_real_escape_string($connection, $username); // Change $conn to $connection
    $user_type = mysqli_real_escape_string($connection, $user_type); // Change $conn to $connection

    // Fetch user data from the database
    $query = "SELECT * FROM users WHERE username='$username' AND user_type='$user_type'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        $hashed_password = $row['password'];

        // Verify the entered password with the hashed password from the database
        if (password_verify($password, $hashed_password)) {
            // Authentication successful, set session variables and redirect
            session_start();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect to the appropriate page
            if ($row['user_type'] == 'admin') {
                header("Location: admin_dashboard.php"); // Replace with the actual admin page
            } else {
                header("Location: book_bike.php");
            }
            exit();
        } else {
            $error_message = "Incorrect password";
        }
    } else {
        $error_message = "User not found";
    }

    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
    background: linear-gradient(to bottom, #ffffff, #000000);
    
}

        body {
            background-color: #f4f4f4;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .container {
            background-color: #C0C0C0;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 350px;
            text-align: center;
        }

        h1 {
            color: #333;
        }

        .error-message {
            color: #ff0000;
            margin-top: 10px;
        }

        .login-form {
            margin-top: 20px;
        }

        input, select {
            margin-bottom: 10px;
            padding: 25px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: calc(100% - 20px);
        }

        input[type="submit"] {
            background-color: #16A085; /* Updated color */
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #138971;; /* Updated hover color */
        }

        p {
            margin-top: 10px;
        }
a{
    color:blue;

}
        .input-container {
    position: relative;
    margin-bottom: 10px; /* Adjusted margin to separate input containers */
}
.back-button {
            position: absolute;
            top: 20px;
            left: 20px;
            font-size: 18px;
            color: #333;
            cursor: pointer;
        }

        .back-button:hover {
            color: #000;
        }

.input-container i {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    left: 10px;
    color: blue; /* Added color to the icon for better visibility */
}

.input-container input,
.input-container select {
    padding-left: 115px; /* Adjusted padding-left for the icon */
    width: calc(100% - 0px); /* Adjusted width to accommodate the icon and extra padding */
}

.input-container input[type="password"] {
    padding-left: 115px; /* Adjusted padding-left for the icon */
}


    </style>

</head>
<body>
    <div class="container">
        <h1 class="mb-4">Login</h1>
        
        <?php
        // Display error message if login fails
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>

        <form action="login.php" method="post" class="login-form">
        <a href="index.html" class="back-button"><b>&larr; Back</b></a>
            <div class="input-container">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required class="form-control">
            </div>
            <div class="input-container">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required class="form-control">
                <i class="fas fa-eye" id="togglePassword"></i>
            </div>

            <!-- Added user_type selection with Bootstrap styles -->
            <div class="form-group">
                <label for="user_type">Login as:</label>
                <select name="user_type" id="user_type" required class="form-control">
                    <option value="user">Student</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success btn-block">Login</button>
        </form>
        <p class="mt-3">Don't have an account? <a href="register.php">Register here</a></p>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // JavaScript for password visibility toggle
        const passwordInput = document.querySelector('input[name="password"]');
        const togglePassword = document.getElementById('togglePassword');

        togglePassword.addEventListener('click', () => {
            const type = passwordInput.type === 'password' ? 'text' : 'password';
            passwordInput.type = type;
            togglePassword.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
