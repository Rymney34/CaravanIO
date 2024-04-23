<?php
session_start();
if (isset($_SESSION["user_id"])){
    $mysqli=require __DIR__."/database.php";

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";

    $result= $mysqli->query($sql);

    $user = $result->fetch_assoc();

    
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About us</title>

    <style>
  

   
    body {
   
    background-color: #FDF6F6;
    margin: 0;
    padding: 0;
}


#header{
    display: flex;
    align-items: center ;
    justify-content: space-between;
    padding: 5px 20px;
    background:#012035 ;
    box-shadow: 0 5px 15px #949393;
    z-index: 1;
    position: sticky;
    top: 0;
    left: 0;
}

/*header background color and spacing etc*/
#navbar {
    display: flex;
    align-items: center ;
    justify-content: center;
}
#navbar li{
    list-style: none;
    padding: 0 20px;
}
#navbar li a {
    text-decoration: none;
    font-size: 16px;
    font-weight: 600;
    color: white ;
}
/*this is the header list , and the options for them*/
#navbar li a:hover,
#navbar li a:active {
    -webkit-text-decoration-line:  underline;
    text-decoration: underline #B76E79 15%;
    text-underline-style: thick;
    transition: 0.3s;
}


#header img {
    border-radius: 50%;

}
.sub-menu-wrap {
    margin-top: 3%;
    position: absolute;
    right: 5%;
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.5s;
}
/*position and proterties of submenu*/
.sub-menu-wrap.open-menu{
max-height: 450px;

}
/*size of sub menu*/
.sub-menu {
    background: white;
    top: 12%;
    padding: 5px 20px 5px 20px;
    border-radius: 10%;
    border: #012035 1px solid;
/*drop down menu background color and position*/

}
.user-info {
    display: flex;
    align-items: center;


}/*drop down */

.user-info img {
    border-radius: 50%;

} /*change image for drop down */
.user-info h2{
padding: 15px;


}  /* change text in drop down menu*/
.sub-menu hr {

}
/*adjust the line in the drop down menu */
.sub-menu-link{
    display: flex;
    align-items: center;
    text-decoration: none;
    color: black;
    margin: 12px 0;
}
/*allows us to change the sub menu words allignment and color */
.sub-menu-link p {
    width: 100%;

}
/*control of the arrow in the drop down */
.sub-menu-link img {
    padding: 2%;
    align-items: center;
}
/*image properties in drop down*/
.sub-menu-link img{
    width: 35px;
    background: lightgrey;
    border-radius: 50%;
    padding: 5px;
    margin-right: 10%;
}
/*changes sub menu icon properties*/
.sub-menu-link span {
    font-size: 22px;
    transition: 0.5s;
}
/*changes arrow in drop down properties*/
.sub-menu-link:hover span {
    transform: translateX(5px);
}
/*hover properties for arrows*/
.sub-menu-link:hover p {
    font-weight: 600;
}
/* post slider on home page*/
.page-wrapper a:hover{
    color: #FDF6F6;
}
.page-wrapper{
    width: 100%;
}
.post-slider{
    text-align: center;
    position: relative;
}
.post-wrapper
{
    width: 85%;
    height: 350px;
    margin: 0px auto;
    overflow: hidden;
    padding: 10px 0 10px 0 ;
}
.post {
    background-color: #B76E79;
    align-items: center;
    display: inline-block;
    width: 400px;
    height: auto;
    margin: 0px 20px;
    border-radius: 5px;
    box-shadow: 1rem 1rem 1rem -1rem grey;

}
/*for every featured post*/
.next {
    position: absolute;
    top: 50%;
    left: 95%;
    font-size: 2em ;
    cursor: pointer;
}

.prev {
    position: absolute;
    top: 50%;
    right: 95%;
    font-size: 2em ;
    cursor: pointer;
}

.next:hover,
.prev:hover{
    transition: 0.5s;
    font-size: 3em;
}
/* Main content styles */
#myform {
    background: white;
    border-radius: 10px;
    margin: 20px auto;
    max-width: 600px;
    padding: 20px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

h1 {
    color: #012035;
    margin-bottom: 20px;
    text-align: center;
}

label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
}

input[type="text"],
input[type="currency"],
textarea {
    width: 100%;
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-sizing: border-box;
    
}

textarea {
    resize: vertical;
    
}

input[type="submit"] {
    background-color: #B76E79;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

input[type="submit"]:hover {
    background-color: #8e4f5f;
}

/* Footer styles */
.footer-titles{
font-size: 20px;
border-bottom: 2px solid #B76E79;
padding-bottom: 10px;
}


footer{
    width: 100%;
    position: relative;
    margin-top: 0.1vh;
    background-color: #012035;
    height: 160px;


}
/*this is for the icon size*/
.footer-row .logo{
    height: auto ;
    width: 60px;
    border-radius: 50%;
    margin-top: 2%;
}
/*logo in footer*/
footer p {
    padding:0 0 0 10px ;
    margin-top: 0 ;
    color: #FDF6F6;

}
footer h2{
    color: #FDF6F6;
    align-items: center;
    margin-top: 30px;
    padding: 0 0 0 10px;
    text-decoration: underline 2px #B76E79 ;
}
.footer-row{
    width: 98%;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    justify-content: space-between;
    margin-top: 2.5%;
}
.col{
    flex-basis: 33%;
    
}
.col i{
    color: #FDF6F6;
    padding: 0 0 0 10px;
    margin: auto;
}
.col h2{
    position: relative;
    margin-top: 30px;
}
.col i ,
.col h2{
    padding-left: 180px;
}


/* Image preview styles */
#upload {
    height: 200px;
    width: 200px;
    border: 2px solid transparent; /* Remove dotted border */
    display: flex;
    justify-content: center;
    align-items: center;
    margin: 0 auto 20px;
    cursor: pointer;
}

#picture22 {
    max-width: 100%;
    height: auto;
    display: none;
    margin: 0 auto;
    border: 2px solid #012035;
    border-radius: 10px;
}

#aboutus {
    font-size: 200%;
    margin-left: 2.2%;
    border-style: solid;
    padding: 1%;
    border-color: #B76E79;
    background-color: #B76E79 ;
    width: 20%;
    position: static;
    border-radius: 5px; 
    
    
}
#paragraph {
    padding: 10px;
    position: relative;
    border-radius: 5px;
    font-size: 100%;
    border-style: solid;
    border-color: #B76E79;
    background-color: #B76E79;
    margin-left: 2.2%;
    margin-top: 3%;
    font-style: normal;
    width: 95%;
    font-family: Arial, Helvetica, sans-serif;
}
</style>

<script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
</head>
<body>
<?php if (isset($_SESSION["user_id"])): ?>
<section id="header">
        <a href="/MainProgram/MainPage/mainLoged.php"><img src="/MainProgram/img/logo.jpg" width = "80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href ="/MainProgram/MainPage/mainLoged.php">Home</a></li>
                <li><a href ="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href ="aboutus.php">About Us</a></li>
                <li><img src="/MainProgram/img/userprofile2.png" onclick="toggleMenu()" width="35" height="auto"></a> </li>
            </ul>

            <div class ="sub-menu-wrap" id = "subMenu">
            <div class = "sub-menu">
                <div class = "user-info">
                    <img src="/MainProgram/img/userprofile2.png"  width="35" height="auto">
                    <h2><?= htmlspecialchars($user["first_name"])?></h2>
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
                        <!-- edit listing option on drop down and the arrow next to it -->
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

           function toggleMenu(){
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
                <li><a class="active" href ="/MainProgram/index.php">Home</a></li>
                <li><a href ="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href ="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><a href="/MainProgram/loginFormFolder/login.php">Sign Up/Sign in</a></li>
            </ul>
        </div>
    </section>
<?php  endif; ?>
    <h1 id="aboutus">About us</h1>
    <div id="paragraph">
    <p>Welcome to Caravan IO, your premier destination for unforgettable
    Caravan adventures. At Caravan IO, we specialize in providing top-of-
    the-line caravan rentals for your travel needs, all type from brand new
    to used caravans. Whether youre embarking on a weekend road trip or
    to a month-long execursion, we've got the perfect caravan to suit your
    journey. 
<br>
<br>
    Omar Elsharoud: <br>
    Chief designer and developer always had a interest for software engineering and caravan 
    camping so I suggested the idea to a group of freinds and we all decided why not create a
    caravan rental website that allows us to rent caravans from owners and it will act as a
    marketplace, so here we are after months of development working on the front end, the 
    backend , making the home page the login and signup code and full website functionality
    and tweaking other bits of code here and there as a team we have finally  managed to 
    create a full working caravan rental website that enables users to list their caravans and
    publicise their contact details for people looking to rent caravans , so the caravan owners 
    can make a quick buck from their unused caravans. <br> <br>

    Owais: <br>
    Carrying on from Omar I was one of the 3 friends Omar decided to form a group with. Same as Omar ive always
    had a strong interest in software engineering from a very young age. This group assaigment helped me a lot
    in the coding aspect but also working as a group. I had many responsibilites such as coding the front and
    backend for the Create and Edit listings pages, Caravan Summary page and setting up a database that is able
    to handle any new listings coming in. I had to also try to create the functionality of allowing seperate users
    to edit and create their own listings. This was a huge challenge but very much a challenge that taught me a lot.
    My role was not easy it took time and effort but with percevernce we all got their at the end to esablisish a 
    fully functional website that users would be happy with. <br> <br>

    Timothy: <br>
    Junior Developer have a passion for software engineering, traveling and camping, espcialy caravan camping.
    I pitched the idea of creating a caravan rental website with friends. Together, we embraced the concept, we recognised
    its potential to connect caravan owners with renters through a convenient online marketplace. Following months of collaborative
    effort, we've brought this vision to life. Now, users can effortlessly list their caravans for rent and share their contact
    information, empowering owners to earn extra income, with help of Caravan IO , Thank you for being with us. <br> <br>

    Jamal: <br>
    As an avid software developer, i constantly push new ideas and innovations, contributing to projects, i particularly
    enjoy developing software to assist companies with managing front and back-end systems. My contributions have been enhancing
    the existing framework of our caravan website. As well as assisting with additional information and offering guidance regarding
    our websites framework and functions, collaborating with my team has allowed us to innovate the way rental systems work. And has
    allowed me to appreciate caravan rental and any upcoming projects, and project this in the form of written information regarding
    our goals and upcoming features.
        </p>

    </div>

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
    
</body>
</html>
