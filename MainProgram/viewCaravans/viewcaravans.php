<?php
session_start();
$mysqli = require __DIR__."/database.php";

if (isset($_SESSION["user_id"])) {
    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="viewCaravans.css">
    <!--    basics and allows our website size to variable-->
</head>
<script>
    function loadUserDescription(){}
</script>
<body>
<?php if (isset($_SESSION["user_id"])): ?>
    <!--header -->
    <section id="header">
        <a href="/MainProgram/MainPage/mainLoged.php"><img src="/MainProgram/img/logo.jpg" width="80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href="/MainProgram/MainPage/mainLoged.php">Home</a></li>
                <li><a href="viewcaravans.php">View Caravans</a></li>
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
                        <!-- edit profile option on drop down and the arrow next to it -->
                    </a>
                    <a href="/MainProgram/editListing/EditListing.php" class="sub-menu-link">
                        <img src="/MainProgram/img/edit.png" width="17" height="auto">
                        <p>Edit Listing</p>
                        <span>></span>
                        <!-- edit profile option on drop down and the arrow next to it -->
                    </a>
                    <a href="/MainProgram/MainPage/logout.php" class="sub-menu-link">
                        <img src="/MainProgram/img/logout.png" width="17" height="auto">
                        <p>Log Out</p>
                        <span>></span>
                        <!-- edit profile option on drop down and the arrow next to it -->
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
        <a href="/MainProgram/index.php"><img src="/MainProgram/img/logo.jpg" width = "80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="/MainProgram/index.php" href ="/MainProgram/index.php">Home</a></li>
                <li><a href ="viewcaravans.php">View Caravans</a></li>
                <li><a href ="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><a href="/MainProgram/loginFormFolder/login.php">Sign Up/Sign in</a></li>
            </ul>
        </div>
    </section>
<?php  endif; ?>
<!--php if statment to see if user is logged in
it will display the header suitible for them if
they are not logged in it will display header
that will ask them to sign up -->
<main>
    <div class="view-caravan-base">
        <h1>Featured Caravans</h1>
        <?php
        $sql = "SELECT * FROM listinginput";
        $result = $mysqli->query($sql);

        if ($result && $result->num_rows > 0) {
            $count = 0;
            echo "<div class='first-row'>";
            while ($row = $result->fetch_assoc()) {
                $count++;

                $caravan_title = htmlspecialchars($row['title']);
                $sleeps = htmlspecialchars($row['qty']);
                $location = htmlspecialchars($row['location']);
                $price = htmlspecialchars($row['price']);
                $id = htmlspecialchars($row['id']);

                ?>
                <div class="first-box">
                    <a href="/MainProgram/CaravanSummary/caravansummmary.php?id=<?= $id ?>">
                        <div class="image">
                            <?php
                            if (!empty($row['image'])) {
                                // Dynamic image path
                                $imagePath = "/MainProgram/addListing/uploads/" . $row['image'];
                                echo '<img src="' . $imagePath . '" />';
                            } else {
                                // If no image data exists, display a placeholder image
                                echo '<img src="/MainProgram/uploads/placeholder.jpg" />';
                            }
                            ?>
                        </div>
                        <div class="caravan-info">
                            <div class="caravan-title">
                                <b><?= $caravan_title ?></b>
                            </div>
                            <div class="qty-sleeps">
                                <p>Sleeps: <span><?= $sleeps ?></span></p>
                            </div>
                            <div class="caravan-location">
                                <p>Location: <span><?= $location ?></span></p>
                            </div>
                            <div class="caravan-price">
                                <p>Price: <span>£<?= $price ?></span> per night</p>
                            </div>
                        </div>
                    </a>
                </div>
                <?php
                // If two listings have been displayed, end the row and start a new one
                if ($count % 3 == 0) {
                    echo "</div><div class='first-row'>";
                }
            }
            // Close the last row if the total number of listings is odd
            if ($count % 3 != 0) {
                echo "</div>";
            }
        } else {
            // Display a message if there no caravans
            echo "<p>No caravans found.</p>";
        }
        ?>
    </div>
</main>



<!--footer-->
<footer>
    <div class="footer-row">
        <div class="col">
            <img src="/MainProgram/img/logo.jpg" class = "logo">
            <p>For all of your caravan needs please do not hesitate<br>
                to contact our carvan owners as they would love <br>
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

<!--    AJax functionality in all browsers so it can refresh-->
<script>
    if(window.XMLHttpRequest) {
        xmlhttp= new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
</script>


<script src="hello.js"></script>

</body>
</html>