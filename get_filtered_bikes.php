<?php
include('db_connection.php');

// Get filter values
$location = isset($_GET['location']) ? $_GET['location'] : '';
$bike_detail = isset($_GET['bike_detail']) ? $_GET['bike_detail'] : '';

// Build the query based on filter values
$query = "SELECT * FROM bikes WHERE 1";

if ($location != '') {
    $query .= " AND bike_location = '$location'";
}


$result = mysqli_query($connection, $query);

// Display filtered bike listings
if (mysqli_num_rows($result) > 0) {
    echo '<ul>';
    while ($row = mysqli_fetch_assoc($result)) {
                // Display image URL
        echo '<br><img src="' . $row['image_url'] . '" alt="Bike Image" style="width: 200px; height: auto;">';
        echo '<li>';
        echo '<strong>Bike ' . $row['bike_id'] . '</strong> - Location: ' . $row['bike_location'];
        echo  '<br>Details: ' . $row['bike_detail'];
        echo '</li>';

    }
    echo '</ul>';
} else {
    echo '<p>No bikes available based on the selected filters.</p>';
}

mysqli_close($connection);
?>
