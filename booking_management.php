<?php
// Include database connection code
include('db_connection.php');

// Start the session
session_start();

// Function to safely escape values before using in SQL queries
function escape($value) {
    global $connection;
    return mysqli_real_escape_string($connection, $value);
}

// Handle delete action
if (isset($_POST['delete_booking'])) {
    $booking_id = escape($_POST['booking_id']);
    $delete_query = "DELETE FROM bookings WHERE booking_id = '$booking_id'";
    mysqli_query($connection, $delete_query);
}

// Handle add/update actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_booking'])) {
        // Add new booking
        $matric_number = escape($_POST['matric_number']);
        $bike_id = escape($_POST['bike_id']);
        $bike_location = escape($_POST['bike_location']);
        $booking_time = escape($_POST['booking_time']);

        $insert_query = "INSERT INTO bookings (matric_number, bike_id, bike_location, booking_time) 
                         VALUES ('$matric_number', '$bike_id', '$bike_location', '$booking_time')";
        mysqli_query($connection, $insert_query);
    } elseif (isset($_POST['update_booking'])) {
        // Update existing booking
        $booking_id = escape($_POST['booking_id']);
        $matric_number = escape($_POST['updated_matric_number']);
        $bike_id = escape($_POST['updated_bike_id']);
        $bike_location = escape($_POST['updated_bike_location']);
        $booking_time = escape($_POST['updated_booking_time']);

        $update_query = "UPDATE bookings 
                         SET user_id='$matric_number', bike_id='$bike_id', bike_location='$bike_location', booking_date='$booking_time'
                         WHERE booking_id = '$booking_id'";
        mysqli_query($connection, $update_query);
    }
}

// Fetch bookings data
$query = "SELECT * FROM bookings";
$result = mysqli_query($connection, $query);

// Define bike locations
$bike_locations = [
    'Inasis MAS',
    'Dewan TNB',
    'UPC Tradewinds',
    'Vmall',
    'Uinn',
    'Inasis Maybank',
    'Pejabat Inasis Petronas',
    'Kafe Inasis Petronas',
    'Pejabat Inasis Grantt',
    'Tempat Letak Kereta Inasis Sime Darby',
    'Pejabat Inasis TM',
    'Tempat Letak Kereta Inasis TM',
    'Pejabat Inasis MISC & BSN',
    'Kafe Inasis YAB & Muamalat',
    'Pejabat Inasis Bank Rakyat',
    'Pejabat Inasis Bank SME',
    'UPC Kachi'
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management Page</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        background: linear-gradient(#298cca, #0062a7, #ffffff);
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
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 80%;
            margin: 20px auto;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
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

        select, input[type="text"] {
            padding: 10px 20px;
            margin: 5px 0;
            box-sizing: border-box;
        }

        button {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #2078ab;
        }

        a {
            color: #3498db;
            text-decoration: none;
            font-weight: bold;
            position: right;
            top: 20px;
            left: 20px;
        }

        a:hover {
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
    <a href="admin_dashboard.php" class="back-button">&larr; Back</a>
    <div class="container">
        <h2>Booking Management</h2>

        <!-- Add/Update Booking Form -->
        <form method="post">
            <label for="matric_number">Matric Number:</label>
            <input type="text" name="matric_number" required>
            <label for="bike_id">Bike ID:</label>
            <input type="text" name="bike_id" required>
            <label for="bike_location">Bike Location:</label>
            <select name="bike_location" required>
                <?php
                foreach ($bike_locations as $location) {
                    echo "<option value=\"$location\">$location</option>";
                }
                ?>
            </select>
            <label for="booking_time">Booking Date and Time:</label>
    <div>
        <input type="date" name="booking_date" required>
        <input type="time" name="booking_time" required>
    </div>
            <br><button type="submit" name="add_booking">Add Booking</button>
        </form>

        <!-- Display booking data -->
        <table>
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>Student Matric Number</th>
                    <th>Bike ID</th>
                    <th>Bike Location</th>
                    <th>Booking Date and Time</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>{$row['booking_id']}</td>";
                    echo "<td>{$row['matric_number']}</td>";
                    echo "<td>{$row['bike_id']}</td>";
                    echo "<td>{$row['bike_location']}</td>";
                    echo "<td>{$row['booking_time']}</td>";
                    echo '<td>
                            <a href="update_booking.php?booking_id=' . $row['booking_id'] . '">Update</a>
                            <form method="post" style="display:inline;">
                                <input type="hidden" name="booking_id" value="' . $row['booking_id'] . '">
                                <button type="submit" name="delete_booking">Delete</button>
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
