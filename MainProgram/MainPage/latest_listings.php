<?php
// Include or require the database connection script
$mysqli = require __DIR__ . "/database.php";

// Define the SQL query to select the latest 5 listings
$sql = "SELECT * FROM listinginput ORDER BY id DESC LIMIT 5";

// Execute the SQL query
$result = $mysqli->query($sql);

// Check query was successful
if (!$result) {
    // If there's an error, return an error message as JSON
    echo json_encode(['error' => 'Error in SQL query: ' . $mysqli->error]);
    exit;
}

// Fetch all rows from the result set as an associative array
$latest_listings = $result->fetch_all(MYSQLI_ASSOC);

// set the array as a JSON and output it
echo json_encode($latest_listings);
?>
