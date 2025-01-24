<?php
include('db_connection.php');
session_start();

// Pagination settings
$resultsPerPage = 10;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $resultsPerPage;

// Fetch bikes with pagination
$query = "SELECT * FROM bikes WHERE is_available = 'Yes' LIMIT $offset, $resultsPerPage";
$result = mysqli_query($connection, $query);

// Check if the query execution was successful
if ($result) {
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Booking Page</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css">
    <style>
        /* Add your custom CSS styles for improved user interface here */
        body {
    font-family: 'Arial', sans-serif;
    background: linear-gradient(90deg, #6485ee, #ffffff, #6488f0);
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
    animation: moveBackground 20s linear infinite; /* Animation for moving background */
    background-size: 100% 100%;
}

@keyframes moveBackground {
    0% {
        background-position: 0% 0%;
    }
    100% {
        background-position: 100% 0%;
    }
}

header {
    background: linear-gradient(90deg, #3498db, #1a5276); /* Adjust gradient for header */
    color: #fff;
    padding: 10px;
    text-align: center;
    width: 100%;
    position: relative;
}

        header h1 {
            margin: 0;
        }

        .logout-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 14px;
            color: #fff;
            cursor: pointer;
        }

        .container {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            width: 50%;
            margin: 20px auto;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        form label,
        form select {
            margin: 10px 0;
        }

        #filteredBikes ul {
            list-style: none;
            padding: 0;
        }

        #filteredBikes li {
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 10px;
        }

        #filteredBikes img {
            width: 25%;
            height: auto;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .boilerplate-button {
    background: linear-gradient(90deg, #3498db, #2078ab); /* Adjust gradient for button */
    color: #fff;
    border: 2px solid #2980b9; /* Add a border */
    padding: 15px 30px;
    border-radius: 8px;
    cursor: pointer;
    transition: background-color 0.3s, border-color 0.3s, color 0.3s;
}

.boilerplate-button:hover {
    background: linear-gradient(90deg, #2078ab, #1a65ac); /* Change gradient on hover */
    border-color: #1a65ac; /* Change border color on hover */
    color: #fff;
}


        a {
            color: #3498db;
            text-decoration: none;
            align: center;
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

        a:hover {
            text-decoration: underline;
        }
        select {
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fff;
    color: #333;
    cursor: pointer;
    outline: none;
    width: 200px; /* Set the width as needed */
}

/* Style for the select drop-down arrow */
select::-ms-expand {
    display: none;
}

select:focus {
    border-color: #3498db;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}
    </style>
</head>

<body>
    <header>
        <h1>Bike Booking</h1>
        <h3>Bikes are Available from 8am to 10pm Everyday (1 hour per booking)</h3>
        <label for="location">Filter by Location:</label>
    <select id="location" name="location">
        <option value="">All Locations</option>
        <option value="Inasis MAS">Inasis MAS</option>
        <option value="Dewan TNB">Dewan TNB</option>
        <option value="UPC Tradewinds">UPC Tradewinds</option>
        <option value="Vmall">Vmall</option>
        <option value="Uinn">Uinn</option>
        <option value="Inasis Maybank">Inasis Maybank</option>
        <option value="Pejabat Inasis Petronas">Pejabat Inasis Petronas</option>
        <option value="Kafe Inasis Petronas">Kafe Inasis Petronas</option>
        <option value="Pejabat Inasis Grantt">Pejabat Inasis Grantt</option>
        <option value="Tempat Letak Kereta Inasis Sime Darby">Tempat Letak Kereta Inasis Sime Darby</option>
        <option value="Pejabat Inasis TM">Pejabat Inasis TM</option>
        <option value="Tempat Letak Kereta Inasis TM">Tempat Letak Kereta Inasis TM</option>
        <option value="Pejabat Inasis MISC & BSN">Pejabat Inasis MISC & BSN</option>
        <option value="Kafe Inasis YAB & Muamalat">Kafe Inasis YAB & Muamalat</option>
        <option value="Pejabat Inasis Bank Rakyat">Pejabat Inasis Bank Rakyat</option>
        <option value="Pejabat Inasis Bank SME">Pejabat Inasis Bank SME</option>
        <option value="UPC Kachi">UPC Kachi</option>
    </select>
    
<button type="button" onclick="applyFilters()" class="boilerplate-button">Apply Filters</button>

            

        <div class="logout-button">
            <form action="logout.php" method="post">
                <input type="submit" value="Logout" class="boilerplate-button">
               
   
</form>
        </div>
    </header>
    <a href="index.html" class="back-button"><b>&larr; Back</b></a>
    <div class="container">
        <div id="filteredBikes">
            <?php
            if (mysqli_num_rows($result) > 0) {
                echo '<ul>';
                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch additional details from the bike_details table
                    $bikeId = $row['bike_id'];
                    $bikeDetailsQuery = "SELECT bike_detail FROM bikes WHERE bike_id = '$bikeId' AND is_available = 'Yes'";
                    $bikeDetailsResult = mysqli_query($connection, $bikeDetailsQuery);

                    // Check if details are found
                    if ($bikeDetailsResult && mysqli_num_rows($bikeDetailsResult) > 0) {
                        $bikeDetails = mysqli_fetch_assoc($bikeDetailsResult);

                        // Display bike details
                        echo '<li>';
                        echo '<img src="' . $row['image_url'] . '" alt="Bike Image">';
                        echo '<p><strong>Bike ' . $row['bike_id'] . '</strong> - Location: ' . $row['bike_location'] . '</p>';
                        echo '<p>Details: ' . $bikeDetails['bike_detail'] . '</p>';
                        echo '<button onclick="bookNow(' . $row['bike_id'] . ', \'' . $row['bike_location'] . '\')" class="boilerplate-button">Book Now</button>';
                        echo '</li>';
                    } else {
                        // Display without additional details if not found
                        echo '<li>';
                        echo '<img src="' . $row['image_url'] . '" alt="Bike Image">';
                        echo '<p><strong>Bike ' . $row['bike_id'] . '</strong> - Location: ' . $row['bike_location'] . '</p>';
                        echo '<button onclick="bookNow(' . $row['bike_id'] . ', \'' . $row['bike_location'] . '\')" class="boilerplate-button">Book Now</button>';
                        echo '</li>';
                    }
                }
                echo '</ul>';
            } else {
                echo '<p>No bikes available.</p>';
            }
            ?>
        </div>

        <!-- Pagination links -->
        <div class="pagination">
            <?php
            // Count total number of bikes
            $totalBikesQuery = "SELECT COUNT(*) AS total FROM bikes WHERE is_available = 'Yes'";
            $totalBikesResult = mysqli_query($connection, $totalBikesQuery);
            $totalBikes = mysqli_fetch_assoc($totalBikesResult)['total'];

            // Calculate total pages
            $totalPages = ceil($totalBikes / $resultsPerPage);

            // Display pagination links
            for ($i = 1; $i <= $totalPages; $i++) {
                echo '<a href="?page=' . $i . '">' . $i . '&nbsp;</a>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <script>
    function applyFilters() {
        var location = document.getElementById("location").value;


    console.log("Location:", location);


    // Display loading spinner during the AJAX request
    $('#loadingSpinner').show();

    $.ajax({
        url: 'get_filtered_bikes.php',
        type: 'GET',
        data: {
            location: location,
             // Include the search parameter
        },
        success: function (response) {
            $('#filteredBikes').html(response);
        },
        error: function (error) {
            console.log(error);
            // Handle error here
        },
        complete: function () {
            // Hide loading spinner after the AJAX request is complete
            $('#loadingSpinner').hide();
        }
    });
}


        function bookNow(bikeId, location) {
            window.location.href = 'booking_confirmation_message.php?bike_id=' + bikeId + '&bike_location=' + location;
        }
    </script>
</body>

</html>

<?php
// Close the if statement for checking query success
} else {
    echo "Error executing the query: " . mysqli_error($connection);
}
?>
