<?php
// Include database connection code
include('db_connection.php');

// Start the session
session_start();

// Handle update action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $new_matric_number = $_POST['updated_matric_number'];
    $new_bike_id = $_POST['updated_bike_id'];
    $new_bike_location = $_POST['bike_location'];
    $new_booking_time = $_POST['updated_booking_time'];

    $update_query = "UPDATE bookings 
                     SET matric_number='$new_matric_number', bike_id='$new_bike_id', bike_location='$new_bike_location', booking_time='$new_booking_time'
                     WHERE booking_id = '$booking_id'";
    mysqli_query($connection, $update_query);

    // Redirect back to Booking Management page after updating
    header("Location: booking_management.php");
    exit();
}

// Fetch booking data
$booking_id = $_GET['booking_id'];
$query = "SELECT * FROM bookings WHERE booking_id = '$booking_id'";
$result = mysqli_query($connection, $query);
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Booking Page</title>
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

        input,
        select {
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
<a href="booking_management.php" class="back-button">&larr; Back</a>
    <div class="container">
        <h2>Update Booking</h2>

        <!-- Update Booking Form -->
        <form method="post">
            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
            <label for="updated_matric_number">New Matric_Number:</label>
            <input type="text" name="updated_matric_number" value="<?php echo $row['matric_number']; ?>" required>
            <label for="updated_bike_id">New Bike ID:</label>
            <input type="text" name="updated_bike_id" value="<?php echo $row['bike_id']; ?>" required>
            <label for="bike_location">Updated Location:</label>
            <select name="bike_location" required>
                <?php
                // Populate dropdown with bike locations
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

                foreach ($bike_locations as $location) {
                    $selected = ($location === $row['bike_location']) ? 'selected' : '';
                    echo "<option value=\"$location\" $selected>$location</option>";
                }
                ?>
            </select>
            <label for="updated_booking_time">New Booking Date and Time:</label>
            <input type="datetime-local" name="updated_booking_time" value="<?php echo date('Y-m-d\TH:i', strtotime($row['booking_time'])); ?>" required>
            <button type="submit" name="update_booking">Update</button>
        </form>

    </div>

</body>

</html>
