<?php
// Include database connection code
include('db_connection.php');

// Start the session (start only if not already started)
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Handle delete action
if (isset($_POST['delete_user'])) {
    $matric_number = $_POST['matric_number'];
    $delete_query = "DELETE FROM users WHERE matric_number = '$matric_number'";
    mysqli_query($connection, $delete_query);
}

// Handle add/update actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_user'])) {
        // Add new user
        $matric_number = $_POST['new_matric_number'];
        $name = $_POST['new_name'];
        $username = $_POST['new_username'];
        $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $contact_number = $_POST['new_contact_number'];
        $user_type = $_POST['new_user_type'];

        $insert_query = "INSERT INTO users (matric_number, name, username, password, contact_number, user_type) 
                        VALUES ('$matric_number', '$name', '$username', '$password', '$contact_number', '$user_type')";
        mysqli_query($connection, $insert_query);
    } elseif (isset($_POST['update_user'])) {
        // Update existing user
        $user_id = $_POST['user_id'];
        $new_matric_number = $_POST['updated_matric_number'];
        $new_name = $_POST['updated_name'];
        $new_username = $_POST['updated_username'];
        $new_password = password_hash($_POST['updated_password'], PASSWORD_DEFAULT);
        $new_contact_number = $_POST['updated_contact_number'];
        $new_user_type = $_POST['updated_user_type'];

        $update_query = "UPDATE users SET 
                        matric_number='$new_matric_number', 
                        name='$new_name', 
                        username='$new_username', 
                        password='$new_password', 
                        contact_number='$new_contact_number', 
                        user_type='$new_user_type' 
                        WHERE user_id = '$user_id'";
        mysqli_query($connection, $update_query);
    }
}

// Fetch users data
$query = "SELECT * FROM users";
$result = mysqli_query($connection, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
    body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        background: linear-gradient(#298cca, #ffffff, #ffffff);
        margin: 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        min-height: 100vh;
        animation: moveBackground 20s linear infinite;
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
        text-align: center;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    td, th {
        padding: 12px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #3498db;
        color: #fff;
    }

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
    }

    label {
        margin: 10px 0;
        display: block;
    }

    input, select {
        padding: 10px 20px;
        margin: 5px 0;
        box-sizing: border-box;
    }

    button {
        background-color: #3498db;
        color: #fff;
        border: none;
        padding: 12px 20px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    button:hover {
        background-color: #2078ab;
    }

    .actions a, .actions button {
        margin: 0 5px;
        padding: 8px 15px; /* Adjusted padding for consistency */
        text-decoration: none;
        color: #3498db;
    }

    .actions a:hover, .actions button:hover {
        text-decoration: underline;
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
</style>

</head>
<body>
    <!-- Back button -->
    <a href="admin_dashboard.php" class="back-button"><b>&larr; Back</a>
    <div class="container">
        <h2>User Management</h2>

        <!-- Add User Form -->
        <form method="post">
            <label for="new_matric_number">New Matric Number:</label>
            <input type="text" name="new_matric_number" required>
            <label for="new_name">New Name:</label>
            <input type="text" name="new_name" required>
            <label for="new_username">New Username:</label>
            <input type="text" name="new_username" required>
            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" required >
            <label for="new_contact_number">New Contact Number:</label>
            <input type="text" name="new_contact_number" required>
            <label for="new_user_type">New User Type:</label>
            <select name="new_user_type" required>
                <option value="user">Student</option>
                <option value="admin">Admin</option>
            </select>
    <button type="submit" name="add_user">Add User</button>

        </form>

        <!-- Display user data -->
        <table>
            <thead>
                <tr>
                    <th>Matric Number</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Contact Number</th>
                    <th>User Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['matric_number']}</td>";
                    echo "<td>{$row['name']}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['password']}</td>";
                    echo "<td>{$row['contact_number']}</td>";
                    echo "<td>{$row['user_type']}</td>";
                    echo '<td class="actions">
                            <a href="update_user.php?matric_number=' . $row['matric_number'] . '">Update</a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="matric_number" value="' . $row['matric_number'] . '">
                                <button type="submit" name="delete_user" style="color: red;">Delete</button>
                            </form>
                        </td>';
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
