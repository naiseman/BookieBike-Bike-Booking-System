<?php
include('db_connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($connection, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user_type = mysqli_real_escape_string($connection, $_POST['user_type']);
    $matric_number = mysqli_real_escape_string($connection, $_POST['matric_number']);
    $contact_number = mysqli_real_escape_string($connection, $_POST['contact_number']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);

    // Server-side validation
    if (empty($username) || empty($password) || empty($user_type) || empty($matric_number) || empty($contact_number) || empty($name)) {
        $error_message = "Please fill in all fields.";
    } else {
        // Check if matric number is unique
        $matric_check_query = "SELECT * FROM users WHERE matric_number = '$matric_number'";
        $matric_check_result = mysqli_query($connection, $matric_check_query);

        if (mysqli_num_rows($matric_check_result) > 0) {
            $error_message = "Matric number is already registered.";
        } else {
            // Insert user data into the database
            $query = "INSERT INTO users (username, password, user_type, matric_number, contact_number, name)
                      VALUES ('$username', '$password', '$user_type', '$matric_number', '$contact_number', '$name')";

            if (mysqli_query($connection, $query)) {
                header("Location: registration_success.php?username=$username");
                exit();
            } else {
                $error_message = "Registration failed: " . mysqli_error($connection);
            }
        }
    }

    mysqli_close($connection);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
          body {
    background: linear-gradient(to right, #ffffff, #000000);
    
}
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 30px;
            width: 350px;
            text-align: center;
        }

        h1 {
            color: black;
            margin-bottom: 20px;
        }

        .error-message {
            color: #dc3545;
            margin-top: 10px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            color: #82E0AA;
        }

        input, select {
            margin-bottom: 15px;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #28B463;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #5D9B89;
        }

        p {
            margin-top: 15px;
            font-size: 14px;
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

        a {
            color: blue;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Register</h1>
        
        <?php
        // Display error message if registration failed
        if (isset($error_message)) {
            echo '<p class="error-message">' . $error_message . '</p>';
        }
        ?>
        <a href="index.html" class="back-button">&larr; Back</a>
        <form name="registrationForm" action="register.php" method="post" onsubmit="return validateRegistrationForm()">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="matric_number" placeholder="Matric Number/ StaffID" required>
            <input type="tel" name="contact_number" placeholder="Contact Number" required>
            <input type="text" name="name" placeholder="Name" required>

            <select name="user_type" id="user_type" required>
                <option value="user">Student</option>
                <option value="admin">Admin</option>
            </select>

            <input type="submit" value="Register">
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>

        <!-- Include the script for client-side validation -->
        <script src="validate.js"></script>
    </div>
</body>
</html>
