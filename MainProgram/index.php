<?php
session_start();

$mysqli = require __DIR__ . "/database.php";

if (isset($_SESSION["user_id"])){
    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);
    $user = $result->fetch_assoc();
}

$sql = "SELECT * FROM listinginput ORDER BY id DESC LIMIT 5";
$result = $mysqli->query($sql);

if (!$result) {
    echo "Error in SQL query: " . $mysqli->error;
    exit; // Exit the script if there's an error
}

$recent_listings = $result->fetch_all(MYSQLI_ASSOC);
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/MainProgram/MainPage/style.css">
<!--    basics and allows our website size to variable-->
</head>
<script>
    function loadUserDescription(){}
</script>
<body>
<!--header -->
    <section id="header">
    <a href="index.php"><img src="/MainProgram/img/logo.jpg" width = "80" height="auto" class="logo"></a>
    <div>
    <ul id="navbar">
                <li><a class="active" href="index.php">Home</a></li>
                <li><a href="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><a href="/MainProgram/loginFormFolder/login.php">Sign Up/Sign in</a></li>
            </ul>
          

        </ul>
    </div>
       <script>
           let subMenu = document.getElementById("subMenu");

           function toggleMenu(){
               subMenu.classList.toggle("open-menu");
           }

       </script>
    </section>
<!--    page wrapper post slider-->


<div class="page-wrapper">
    <div class="post-slider">
        <h1 class="slider-title">Featured Caravans</h1>
        <!-- Slider navigation arrows -->
        <i class="fas fa-chevron-left prev"></i>
        <i class="fas fa-chevron-right next"></i>

        <div class="post-wrapper">
            <!-- Loop through latest listings and display them -->
            <?php foreach ($recent_listings as $row): ?>
                <div class="post">
                    <!-- Image -->
                    <img src="/MainProgram/addListing/uploads/<?= $row['image']; ?>" class="slider-image"> 
                   
                    <div class="post-info">
                        <!-- Title -->
                        <h4><a href="/MainProgram/CaravanSummary/caravansummmary.php?id=<?= $row['id']; ?>"><?= $row['title']; ?></a></h4>

                        <!-- Location and price -->
                        <p>Location: <?= $row['location']; ?></p>
                        <p>Price: £<?= $row['price']; ?>/Night</p>
                        <p>Sleeps: <?= $row['qty']; ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<!--information box about what we offer-->
    <div class="info-box">
    <h1>What We Offer</h1>
    <p>Here at Caravan.IO we offer many great caravans on offer at multiple differnt locations around the
        United Kingdom what makes us really special is the flexibility we offer our customers when choosing
        to rent with us and ease of booking by putting you as the customer in direct contact with the owner
        of the caravan. We also have a wide range of caravans avalible with unmatched prices, as we are a
        flexible platform you are able to conatct the renter directley and agree to your own terms and conditions
        such as price dates and how many cavans you would like to rent. Our aim is to also make it easy for people
        to rent out their unused caravans throughout the year and make an extra income when not being used we have
        made the process of listing caravans as simple enough to allow everyone to post with ease.
    </p>
</div>
<!--why us section-->
<div class="why-us">
    <h1>Why Choose Us?</h1>
    <div class="row">
    <div class="caravans">
        <i class="fa-solid fa-caravan"></i>
        <h2>Wide Range Of Caravans Availble</h2>
        <p>We have a very wide range of caravans on our website in multiple locations</p>
    </div>
        <div class="sterling">
            <i class="fa-solid fa-sterling-sign"></i>
            <h2>We Will Not be Beaten On Price</h2>
            <p>Unmatched Prices, dont belive us ? request a quote now.</p>
        </div>
        <div class="user-satisfaction">
            <i class="fa-solid fa-star"></i>
            <h2>Great Customer Satisfaction</h2>
            <p>99 percent of our customers would recomend us to a freind.</p>
        </div>
        <div class="users">
            <i class="fa-solid fa-users"></i>
            <h2>Satisfied Clients</h2>
            <p>Our customers vouch for impeccable service and ease of rental</p>
        </div>
</div>
</div>
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
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- slick carousel script -->
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<!--scrit for the featured items-->
<script>
    $('.post-wrapper').slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
        nextArrow: $('.next'),
        prevArrow: $('.prev'),
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    });
</script>
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