<?php
// Include database connection code
include('db_connection.php');

// Start the session (start only if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Function to safely escape values before using in SQL queries
function escape($value) {
    global $connection;
    return mysqli_real_escape_string($connection, $value);
}

// Function to hash passwords
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fetch user data
$matric_number = $_GET['matric_number'];
$query = "SELECT * FROM users WHERE matric_number = '$matric_number'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);

// Handle update action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_matric_number = escape($_POST['updated_matric_number']);
    $new_name = escape($_POST['updated_name']);
    $new_username = escape($_POST['updated_username']);
    $new_password = hashPassword($_POST['updated_password']);
    $new_contact_number = escape($_POST['updated_contact_number']);
    $new_user_type = escape($_POST['updated_user_type']);

    $update_query = "UPDATE users SET 
                    matric_number='$new_matric_number', 
                    name='$new_name', 
                    username='$new_username', 
                    password='$new_password', 
                    contact_number='$new_contact_number', 
                    user_type='$new_user_type' 
                    WHERE matric_number = '$matric_number'";
    mysqli_query($connection, $update_query);

    // Redirect back to User Management page after updating
    header("Location: user_management.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        /* Add your custom CSS styles for improved user interface here */
        .container {
            text-align: center;
            margin-top: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-top: 20px;
        }

        label {
            margin-top: 10px;
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

        button {
            background-color: #3498db;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #2184b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Update User</h2>

        <!-- Update User Form -->
        <form method="post">
            <input type="text" name="updated_matric_number" value="<?php echo $row['matric_number']; ?>" required>
            <label for="updated_name">Name:</label>
            <input type="text" name="updated_name" value="<?php echo $row['name']; ?>" required>
            <label for="updated_username">Username:</label>
            <input type="text" name="updated_username" value="<?php echo $row['username']; ?>" required>
            <label for="updated_password">Password:</label>
            
            <input type="password" name="updated_password" required><i>(Please fill in your password if you do not want to change it)</i>
            <label for="updated_contact_number">Contact Number:</label>
            <input type="text" name="updated_contact_number" value="<?php echo $row['contact_number']; ?>" required>
            <label for="updated_user_type">User Type:</label>
            <select name="updated_user_type" required>
                <option value="user" <?php echo ($row['user_type'] == 'user') ? 'selected' : ''; ?>>Student</option>
                <option value="admin" <?php echo ($row['user_type'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
            </select>
            <button type="submit" name="update_user">Update User</button>
        </form>
    </div>
    <!-- Back button -->
    <a href="user_management.php">Back</a>
</body>
</html>
