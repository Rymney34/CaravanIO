<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish connection to MySQL database
    $mysqli = require __DIR__ . "/database1.php";

    // Retrieve the title of the listing to be deleted
    $title = $_POST['delete_title'];

    // Prepare SQL statement to prevent SQL injection for security
    $sql = "DELETE FROM listinginput WHERE title = ? AND user_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("si", $title, $_SESSION["user_id"]);


    if ($stmt->execute()) {
        // Display success message
        echo "Listing deleted successfully";
    } else {
        // Display error message if there is an error
        echo "Error deleting listing: " . $mysqli->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>
