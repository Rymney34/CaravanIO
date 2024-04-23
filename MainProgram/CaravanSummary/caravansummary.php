<?php

session_start();

if (isset($_SESSION["user_id"])) {
    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    if ($result) {
        $user = $result->fetch_assoc();
    } else {
        echo "Error: " . $mysqli->error;
        exit(); // Terminate script
    }
} else {
    echo "User not logged in, Please login or register to continue";
    exit(); // Terminate script
}

// Establish database connection
$conn = new mysqli('localhost', 'root', '', 'assignment');
if ($conn->connect_error) {
    die('Connection Failed : ' . $conn->connect_error);
}

// Retrieve data from the database based on the title passed through the URL
if (isset($_GET['title'])) {
    $title = $_GET['title'];
    $sql = "SELECT * FROM listinginput WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $title);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Display data
        while ($row = $result->fetch_assoc()) {
            echo "<!DOCTYPE html>";
            echo "<html lang='en'>";
            echo "<head>";
            echo "<link rel='stylesheet' href='caravansummary.css'>";
            echo "<script src='https://kit.fontawesome.com/cef40a4c0b.js' crossorigin='anonymous'></script>";
            echo "<meta charset='UTF-8'>";
            echo "<meta http-equiv='X-UA-Compatible' content='IE=edge'>";
            echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
            echo "<title>Caravan Summary</title>";
            echo "</head>";
            echo "<body>";
            echo "<!-- Header section -->";
            echo "<section id='header'>";
            echo "<a href='/MainProgram/MainPage/mainLoged.php'><img src='/MainProgram/img/logo.jpg' width='80' height='auto' class='logo'></a>";
            echo "<div>";
            echo "<ul id='navbar'>";
            echo "<li><a class='active' href='/MainProgram/MainPage/mainLoged.php'>Home</a></li>";
            echo "<li><a href='/MainProgram/viewCaravans/viewcaravans.php'>View Caravans</a></li>";
            echo "<li><a href='/MainProgram/aboutUs/aboutus.php'>About Us</a></li>";
            echo "<li><img src='/MainProgram/img/userprofile2.png' onclick='toggleMenu()' width='35' height='auto'></li>";
            echo "</ul>";
            echo "<div class='sub-menu-wrap' id='subMenu'>";
            echo "<div class='sub-menu'>";
            echo "<div class='user-info'>";
            echo "<img src='/MainProgram/img/userprofile2.png' width='35' height='auto'>";
            echo "<h2>" . htmlspecialchars($user['first_name']) . "</h2>";
            echo "</div>";
            echo "<hr>";
            echo "<a href='/MainProgram/addListing/phpdemo1.php' class='sub-menu-link'>";
            echo "<img src='/MainProgram/img/add.png' width='17' height='auto'>";
            echo "<p>Add Listing</p>";
            echo "<span>></span>";
            echo "</a>";
            echo "<a href='/MainProgram/editListing/EditListing.php' class='sub-menu-link'>";
            echo "<img src='/MainProgram/img/edit.png' width='17' height='auto'>";
            echo "<p>Edit Listing</p>";
            echo "<span>></span>";
            echo "</a>";
            echo "<a href='/MainProgram/MainPage/logout.php' class='sub-menu-link'>";
            echo "<img src='/MainProgram/img/logout.png' width='17' height='auto'>";
            echo "<p>Log Out</p>";
            echo "<span>></span>";
            echo "</a>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<script>";
            echo "let subMenu = document.getElementById('subMenu');";
            echo "function toggleMenu(){";
            echo "subMenu.classList.toggle('open-menu');";
            echo "}";
            echo "</script>";
            echo "</section>";
            echo "<h1>Caravan Summary</h1>";
            echo "<!-- Caravan details in summary page -->";
            echo "<div id='Caravandetails' class='caravan_summary'>";
            echo "<div class='summaryimage'>";
                echo "<img src='/MainProgram/addListing/uploads/" . $row['image'] . "' width='100%' id='mainimg'>";
            echo "</div>";
            echo "<div class='details'>";
            echo "<div class='title'>";
            echo "<h2>" . $row['title'] . "</h2>";
            echo "</div>";
            echo "<div class='price'>";
            echo "<h2>Price: £" . $row['price'] . "</h2>";
            echo "</div>";
            echo "<div class='Description'>";
            echo "<h3>" . $row['description'] . "</h3>";
            echo "</div>";
            echo "<div class='Contact'>";
            echo "<h3>Contact details: " . $row['contact'] . "</h3>";
            echo "</div>";
            echo "<div class='Sleeps'>";
            echo "<h3>Sleeps: " . $row['qty'] . " People</h3>";
            echo "</div>";
            echo "<div class='Location'>";
            echo "<h3>Location: " . $row['location'] . "</h3>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "<footer>";
            echo "<div class='footer-row'>";
            echo "<div class='col'>";
            echo "<img src='/MainProgram/img/logo.jpg' class='logo'>";
            echo "<p>For all of your caravan needs please do not hesitate<br>";
            echo "to contact our carvan owners as they would love <br>";
            echo "to help you with arranging your perfect holiday.</p>";
            echo "</div>";
            echo "<div class='contact'>";
            echo "<h2> Our Contact Details:</h2>";
            echo "<p>";
            echo "123 Cardiff Road &nbsp;&nbsp;&nbsp; Phone Number: 0712345678<br>";
            echo "Cardiff &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
            echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email: Caravan.io@gmail.com <br>";
            echo "CF12 1AA <br>";
            echo "</p>";
            echo "</div>";
            echo "<div class='col'>";
            echo "<h2>Social Media:</h2>";
            echo "<i class='fa-brands fa-facebook'>Caravan.io</i><br>";
            echo "<i class='fa-brands fa-x-twitter'>Caravan.io</i><br>";
            echo "<i class='fa-brands fa-instagram'>Caravan.io</i>";
            echo "</div>";
            echo "<div class='col'></div>";
            echo "</div>";
            echo "</footer>";
            echo "</body>";
            echo "</html>";
        }
    } else {
        echo "No caravan found with the given title.";
    }

    $stmt->close();
} else {
    echo "No title provided.";
}

$conn->close();
?>
