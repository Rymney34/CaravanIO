<?php
global $mysqli;
session_start();

// Include database connection
require_once 'database1.php';

// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect the user to the login page or display an error message indicating they need to log in

    header("Location: login.php");
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST['title'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $contact = $_POST['contact'];
    $qty = $_POST['qty'];
    $location = $_POST['location'];

    // Check if the logged-in user is the owner of the listing being updated
    $sql = "SELECT user_id FROM listinginput WHERE title = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $stmt->bind_result($listingUserId);
    $stmt->fetch();
    $stmt->close();


    if ($listingUserId != $_SESSION["user_id"]) {
       
        header("Location: unauthorized.php");
        exit();
    }

    // File upload handling
    $upload_path = "uploads/";
    $target_file = $upload_path . basename($_FILES["image"]["name"]);

    // Check if a file was uploaded
    if (!empty($_FILES["image"]["tmp_name"]) && file_exists($_FILES["image"]["tmp_name"])) {
        // File details
        $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["image"]["tmp_name"]);

        // Check if it's a valid image file
        if ($check !== false) {
            // File size check
            if ($_FILES["image"]["size"] > 500000) {
                echo "Sorry, your file is too large.";
            } elseif (!in_array($image_file_type, ["jpg", "png", "jpeg", "gif"])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            } else {
                // Move uploaded file to destination
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                    // Update listing in the database with image path
                    $sql = "UPDATE listinginput SET price=?, description=?, contact=?, qty=?, location=?, image=?, user_id=? WHERE title=?";
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ssssssis", $price, $description, $contact, $qty, $location, $target_file, $_SESSION["user_id"], $title);

                    if ($stmt->execute()) {
                        header("Location: /MainProgram/viewCaravans/viewcaravans.php");
                    } else {
                        echo "Error updating listing: " . $mysqli->error;
                    }
                    // Close statement after execution
                    $stmt->close();
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            echo "File is not an image.";
        }
    } else {
        // If no image is uploaded, update the listing without changing the image path
        $sql = "UPDATE listinginput SET price=?, description=?, contact=?, qty=?, location=? WHERE title=?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("ssssss", $price, $description, $contact, $qty, $location, $title);

        if ($stmt->execute()) {
            header("Location: /MainProgram/viewCaravans/viewcaravans.php");
        } else {
            echo "Error updating listing: " . $mysqli->error;
        }
        // Close statement
        $stmt->close();
    }
}

// Close the database connection
$mysqli->close();
?>
