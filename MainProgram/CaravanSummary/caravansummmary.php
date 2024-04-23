<?php
session_start();

$mysqli = require __DIR__."/database.php";

// Fetch caravan details
$caravan_id = $_GET['id'];
$sql = "SELECT * FROM listinginput WHERE id = $caravan_id";
$result = $mysqli->query($sql);

// Check if the query was successful and data was found
if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $caravan_title = htmlspecialchars($row['title']);
    $sleeps = htmlspecialchars($row['qty']);
    $location = htmlspecialchars($row['location']);
    $price = htmlspecialchars($row['price']);
    $description = htmlspecialchars($row['description']);
    $contact = htmlspecialchars($row['contact']);
    $id = htmlspecialchars($row['id']);
} else {
    // If no caravan found, handle the error
    echo "Caravan not found!";
}

// Fetch user data if user is logged in
$user = null;
if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="caravansummary.css">
    <script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caravan Summary</title>
</head>
<body>
<?php if (isset($_SESSION["user_id"])): ?>
    <!-- Header for logged-in users -->
    <section id="header">
        <a href="/MainProgram/MainPage/mainLoged.php"><img src="/MainProgram/img/logo.jpg" width="80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="/MainProgram/MainPage/mainLoged.php">Home</a></li>
                <li><a href="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><img src="/MainProgram/img/userprofile2.png" onclick="toggleMenu()" width="35" height="auto"></li>
            </ul>

            <!-- Header buttons in a div list -->
            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="/MainProgram/img/userprofile2.png" width="35" height="auto">
                        <h2><?= isset($user["first_name"]) ? htmlspecialchars($user["first_name"]) : "Guest" ?></h2>
                    </div>
                    <hr>

                    <a href="/MainProgram/addListing/phpdemo1.php" class="sub-menu-link">
                        <img src="/MainProgram/img/add.png" width="17" height="auto">
                        <p>Add Listing</p>
                        <span>></span>
                        <!-- edit add listing option on drop down and the arrow next to it -->
                    </a>
                    <a href="/MainProgram/editListing/EditListing.php" class="sub-menu-link">
                        <img src="/MainProgram/img/edit.png" width="17" height="auto">
                        <p>Edit Listing</p>
                        <span>></span>
                        <!-- edit edit listing option on drop down and the arrow next to it -->
                    </a>
                    <a href="/MainProgram/MainPage/logout.php" class="sub-menu-link">
                        <img src="/MainProgram/img/logout.png" width="17" height="auto">
                        <p>Log Out</p>
                        <span>></span>
                        <!-- edit logout option on drop down and the arrow next to it -->
                    </a>
                </div>
            </div>
        </div>
        <script>
            let subMenu = document.getElementById("subMenu");

            function toggleMenu() {
                subMenu.classList.toggle("open-menu");
            }
        </script>
    </section>
<?php else: ?>
    <!-- Header for guests -->
    <section id="header">
        <a href="/MainProgram/index.php"><img src="/MainProgram/img/logo.jpg" width="80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="/MainProgram/index.php">Home</a></li>
                <li><a href="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><a href="/MainProgram/loginFormFolder/login.php">Sign Up/Sign in</a></li>
            </ul>
        </div>
    </section>
<?php endif; ?>

<h1>Caravan Summary</h1>
<!-- Caravan details in summary page -->
<div id="Caravandetails" class="caravan_summary">

    <div class="summaryimage">
        <?php
        if (!empty($row['image'])) {
            // Dynamic image path
            $imagePath = "/MainProgram/addListing/uploads/" . $row['image'];
            
            echo '<img src="' . $imagePath . '" />';
        } else {
            // If no image data exists, display a placeholder image
            echo '<img src="uploads/placeholder.jpg" />';
        }
        ?>
    </div>

    <div class="details">

        <div class="title">
            <h2><?= $caravan_title ?></h2>
        </div>

        <div class="price">
            <h2> <?php echo "Price: £ ". $price ?></h2>
        </div>

        <div class="Description">
            <h3><?= $description ?></h3>
        </div>

        <div class="Contact">
            <h3><?php echo "Contact details: ".$contact ?></h3>
        </div>

        <div class="Sleeps">
            <h3><?php echo "Sleeps: ". $sleeps ?></h3>
        </div>

        <div class="Location">
            <h3><?php echo "Location: ".$location ?></h3>
        </div>

    </div>
</div>

<footer>
    <div class="footer-row">
        <div class="col">
            <img src="/MainProgram/img/logo.jpg" class="logo">
            <p>For all of your caravan needs please do not hesitate<br>
                to contact our caravan owners as they would love <br>
                to help you with arranging your perfect holiday.</p>
        </div>
        <div class="contact">
            <h2> Our Contact Details:</h2>
            <p>
                123 Cardiff Road &nbsp;&nbsp;&nbsp; Phone Number: 0712345678<br>
                Cardiff &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Email: Caravan.io@gmail.com <br>
                CF12 1AA <br>
            </p>
        </div>
        <div class="col">
            <h2>Social Media:</h2>
            <i class="fa-brands fa-facebook">Caravan.io</i><br>
            <i class="fa-brands fa-x-twitter">Caravan.io</i><br>
            <i class="fa-brands fa-instagram">Caravan.io</i>
        </div>
        <div class="col"></div>
    </div>
</footer>

</body>
</html>
