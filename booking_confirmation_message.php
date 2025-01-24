<?php
session_start();
include('db_connection.php'); // Include your database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle the form submission (booking confirmation)
    $bikeId = $_POST['bike_id'];
    $bikeLocation = $_POST['bike_location'];
    $bookingDate = $_POST['booking_date'];
    $bookingTime = $_POST['booking_time'];
    $matricNumber = $_POST['matric_number'];

    // Check if the entered matric number exists in the users' database
    $checkUserQuery = "SELECT * FROM users WHERE matric_number = '$matricNumber'";
    $userResult = mysqli_query($connection, $checkUserQuery);

    if ($userResult && mysqli_num_rows($userResult) > 0) {
        // Add your logic to store the booking information in the database
        $insertQuery = "INSERT INTO bookings (bike_id, bike_location, booking_time, matric_number) VALUES ('$bikeId', '$bikeLocation', '$bookingDate $bookingTime', '$matricNumber')";

        if (mysqli_query($connection, $insertQuery)) {
            echo '<style>';
    echo 'body {';
    echo 'background: linear-gradient(135deg, #8e54e9, #ffffff);';
    echo 'color: #fff;';
    echo 'margin: 0;';
    echo 'padding: 0;';
    echo '}';
    echo '</style>';

    echo '<div style="padding: 100px; border-radius: 8px; text-align: center;">';
            echo '<b><h2>Booking Confirmed</b></h2>';
            echo '<b><p>Thank you for booking!</b></p>';
            echo '<b><p>Bike ID: ' . $bikeId . '</b></p>';
            echo '<b><p>Bike Location: ' . $bikeLocation . '</b></p>';
            echo '<b><p>Booking Date & Time: ' . $bookingDate . ' ' . $bookingTime . '</b></p>';
            echo '<b><p>Matric Number: ' . $matricNumber . '</b></p>';
            echo '<button onclick="goBack()" style="background: linear-gradient(135deg, #8e54e9, #4776e6); color: #fff; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;">Go Back</button>';
            echo '</div>';
    
            echo '<script>';
            echo 'function goBack() {';
            echo 'window.history.back();';
            echo '}';
            echo '</script>';

        } else {
            // Display an error message if the insertion fails
            echo '<h2>Error Confirming Booking</h2>';
            echo '<p>There was an error confirming your booking. Please try again.</p>';
            echo '<p>Error details: ' . mysqli_error($connection) . '</p>';
        }
    } else {
        // Display an error message if the matric number is not found
        echo '<h2>Error Confirming Booking</h2>';
        echo '<p>Matric number not found. Please check your matric number and try again.</p>';
        echo '<button onclick="goBack()">Go Back</button>';
        echo '</div>';

        echo '<script>';
        echo 'function goBack() {';
        echo 'window.history.back();';
        echo '}';
        echo '</script>';
    }
} else {
    // Retrieve bike_id and location from the URL
    $bikeId = $_GET['bike_id'];
    $bikeLocation = $_GET['bike_location'];

    // Fetch bike details from the bikes table based on the selected bike_id
    $bikeDetailsQuery = "SELECT * FROM bikes WHERE bike_id = '$bikeId'";
    $bikeDetailsResult = mysqli_query($connection, $bikeDetailsQuery);

    if ($bikeDetailsResult && mysqli_num_rows($bikeDetailsResult) > 0) {
        $bikeDetails = mysqli_fetch_assoc($bikeDetailsResult);
    } else {
        // Handle the case when the bike details cannot be retrieved
        echo '<h2>Error Fetching Bike Details</h2>';
        echo '<p>Unable to retrieve details for the selected bike.</p>';
        // Add additional error handling if needed
        exit(); // Terminate the script to avoid further execution
    }
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Booking Confirmation</title>
        <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Times New Roman', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(90deg, #ffd4dd, #ffffff, #bbaef7); /* Gradient background */
            color: #333;
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
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            color: #555;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
    background: linear-gradient(90deg, #8533fa, #f290ff);
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background 0.3s;
}

button:hover {
    background: linear-gradient(90deg, #c0392b, #8e44ad);
}


        a {
            display: block;
            margin-top: 10px;
            color: #333;
            text-decoration: none;
        }

        img {
            width: 100%;
            max-width: 300px;
            height: auto;
            margin-bottom: 10px;
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
    <a href="book_bike.php" class="back-button"><b>&larr; Back</b></a>
        <div class="container">
            <h2>Booking Confirmation</h2>
            <form method="post" action="">
                <!-- Display the image URL -->
                <img src="<?php echo $bikeDetails['image_url']; ?>" alt="Bike Image" style="max-width: 20%;">
                
                <!-- Hidden input fields for bike details -->
                <div class="form-group">
                    <label for="bike_id">Bike ID:</label>
                    <input type="text" id="bike_id" name="bike_id" value="<?php echo $bikeId; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="bike_location">Bike Location:</label>
                    <input type="text" id="bike_location" name="bike_location" value="<?php echo $bikeLocation; ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="booking_date">Booking Date:</label>
                    <input type="date" name="booking_date" required>
                </div>

                <div class="form-group">
                    <label for="booking_time">Booking Time:</label>
                    <input type="time" name="booking_time" required>
                </div>

                <div class="form-group">
                    <label for="matric_number">Matric Number:</label>
                    <input type="text" id="matric_number" name="matric_number" required>
                </div>

                <button type="submit">Confirm Booking</button>
                <button type="button" onclick="goBack()">Cancel</button>

<script>
    function goBack() {
        window.history.back();
    }
</script>
            </form>
        </div>
    </body>

    </html>

<?php
}
?>
