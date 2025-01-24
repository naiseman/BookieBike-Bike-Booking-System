<?php
include('db_connection.php');
session_start();

function getAllBikes($connection) {
    $query = "SELECT * FROM bikes";
    $result = mysqli_query($connection, $query);
    return $result;
}

function createBike($connection, $bike_location, $image_url, $is_available, $bike_detail) {
    $query = "INSERT INTO bikes (bike_location, image_url, is_available, bike_detail) 
              VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($connection, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssss", $bike_location, $image_url, $is_available, $bike_detail);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            return "Bike created successfully.";
        } else {
            if (mysqli_errno($connection) == 1062) {
                return "Error creating bike: Duplicate entry. Please try again.";
            } else {
                return "Error creating bike: " . mysqli_error($connection);
            }
        }
    } else {
        return "Error creating bike: " . mysqli_error($connection);
    }
}

function updateBike($connection, $bike_id, $bike_location, $image_url, $is_available, $bike_detail) {
    $query = "UPDATE bikes 
              SET bike_location='$bike_location', image_url='$image_url', is_available='$is_available', bike_detail='$bike_detail' 
              WHERE bike_id=$bike_id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return "Bike updated successfully.";
    } else {
        return "Error updating bike: " . mysqli_error($connection);
    }
}

function deleteBike($connection, $bike_id) {
    $query = "DELETE FROM bikes WHERE bike_id=$bike_id";
    $result = mysqli_query($connection, $query);

    if ($result) {
        return "Bike deleted successfully.";
    } else {
        return "Error deleting bike: " . mysqli_error($connection);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['create_bike'])) {
        $bike_location = $_POST['bike_location'];
        $image_url = $_POST['image_url'];
        $is_available = isset($_POST['is_available']) ? 'Yes' : 'No';
        $bike_detail = $_POST['bike_detail'];

        $resultMessage = createBike($connection, $bike_location, $image_url, $is_available, $bike_detail);
    } elseif (isset($_POST['update_bike'])) {
        $bike_id = $_POST['bike_id'];
        $update_bike_location = $_POST['update_bike_location'];
        $update_image_url = $_POST['update_image_url'];
        $update_is_available = isset($_POST['update_is_available']) ? 'Yes' : 'No';
        $update_bike_detail = $_POST['update_bike_detail'];

        $resultMessage = updateBike($connection, $bike_id, $update_bike_location, $update_image_url, $update_is_available, $update_bike_detail);
    } elseif (isset($_POST['delete_bike'])) {
        $bike_id = $_POST['bike_id'];

        $resultMessage = deleteBike($connection, $bike_id);
    }
}
// Function to get all bikes with pagination
function getBikesWithPagination($connection, $limit, $offset) {
    $query = "SELECT * FROM bikes LIMIT $limit OFFSET $offset";
    $result = mysqli_query($connection, $query);
    return $result;
}

// Function to count total number of bikes
function countTotalBikes($connection) {
    $query = "SELECT COUNT(*) as total FROM bikes";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

$limit = 5; // Number of bikes per page
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$totalBikes = countTotalBikes($connection);
$totalPages = ceil($totalBikes / $limit);

$bikesResult = getBikesWithPagination($connection, $limit, $offset);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bike Management - BookieBike</title>
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
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 80%;
        margin: 20px auto;
        text-align: center;
        position: relative;
    }

    h2, h3 {
        color: #3498db;
    }

    /* Form styles */
    form {
    display: flex;
    flex-direction: column;
    align-items: left;
    margin-top: 20px;
    max-width: 400px; /* Set a maximum width for better readability */
    margin: 20px auto; /* Center the form */
}

.form-group {
    margin-bottom: 15px;
}

label {
    margin-bottom: 8px;
    display: block;
    color: #333;
}

select, input[type="text"] {
    width: 100%; /* Full width input fields */
    padding: 8px;
    margin: 5px 0;
    box-sizing: border-box;
}



    input[type="checkbox"] {
        margin-top: 10px;
    }

    input[type="submit"] {
    background-color: #56ab2f;
    color: #fff;
    border: none;
    padding: 10px 20px; /* Adjusted padding for better size */
    border-radius: 4px;
    cursor: pointer;
    box-sizing: border-box;
}

input[type="submit"]:hover {
    background-color: #3e8e15;
}


    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th, td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    th {
        background-color: #3498db;
        color: white;
    }

    .pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }

    .pagination a {
        padding: 10px;
        margin: 5px;
        text-decoration: none;
        border: 1px solid #3498db;
        color: #3498db;
        border-radius: 4px;
    }

    .pagination a.active {
        background-color: #3498db;
        color: #fff;
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

    .container {
        margin-top: 20px;
    }
</style>

</head>
<body>
<a href="admin_dashboard.php" class="back-button"><b>&larr; Back</b></a>
    <div class="container">
        <h2>Bike Management</h2>

        <!-- Display bikes in a table -->
        <?php
        $limit = 5; // Number of bikes per page
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $totalBikes = countTotalBikes($connection);
        $totalPages = ceil($totalBikes / $limit);

        $bikesResult = getBikesWithPagination($connection, $limit, $offset);
        ?>

        <?php if (mysqli_num_rows($bikesResult) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Bike ID</th>
                        <th>Location</th>
                        <th>Available</th>
                        <th>Bike Detail</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($bike = mysqli_fetch_assoc($bikesResult)): ?>
                        <tr>
                            <td><?= $bike['bike_id']; ?></td>
                            <td><?= $bike['bike_location']; ?></td>
                            <td><?= $bike['is_available']; ?></td>
                            <td><?= $bike['bike_detail']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <!-- Pagination links -->
            <div class="pagination">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?page=<?= $i; ?>" class="<?= ($i == $page) ? 'active' : ''; ?>"><?= $i; ?></a>
                <?php endfor; ?>
            </div>
        <?php else: ?>
            <p>No bikes available.</p>
        <?php endif; ?>

        <!-- Add bike form -->
        <br><br><br><h3>Create a New Bike</h3>
        <form action="bike_management.php" method="post">
            <label for="bike_location">
                Location:
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
                        echo "<option value=\"$location\">$location</option>";
                    }
                    ?>
                </select>
            </label>

            <label for="image_url">
                Image URL: <input type="text" name="image_url" required>
            </label>

            <label for="is_available">
                Is Available: <input type="checkbox" name="is_available" checked>
            </label>

            <label for="bike_detail">
                Bike Detail: <textarea name="bike_detail" rows="4" cols="50"></textarea>
            </label>

            <div>
    <input type="submit" name="create_bike" value="Create Bike">
</div>

        </form>

        <!-- Update and Delete bike forms -->
       <br><br><br> <h3>Update/Delete Bike</h3>
        <form action="bike_management.php" method="post">
            <label for="bike_id">
                Bike ID: <input type="text" name="bike_id" required>
            </label>

            <label for="update_bike_location">
                Updated Location:
                <select name="update_bike_location" required>
                    <?php
                    // Populate dropdown with bike locations
                    foreach ($bike_locations as $location) {
                        echo "<option value=\"$location\">$location</option>";
                    }
                    ?>
                </select>
            </label>
            <label for="update_image_url">
                Updated Image URL: <input type="text" name="update_image_url" placeholder="Leave blank if not updating">
            </label>

            <label for="update_is_available">
                Updated Is Available: <input type="checkbox" name="update_is_available" checked>
            </label>

            <label for="update_bike_detail">
                Updated Bike Detail: <textarea name="update_bike_detail" rows="4" cols="50" placeholder="Leave blank if not updating"></textarea>
            </label>
            <div>
                <input type="submit" name="update_bike" value="Update Bike">&nbsp;&nbsp;<input type="submit" name="delete_bike" value="Delete Bike"></div>
        </form>

        <?php
        // Display result message
        if (isset($resultMessage)) {
            echo '<p>' . $resultMessage . '</p>';
        }
        ?>
    </div>
</body>
</html>
