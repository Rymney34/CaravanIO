<?php
session_start();

if (isset($_SESSION["user_id"])){
    $mysqli=require __DIR__."/database.php";

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";

    $result= $mysqli->query($sql);

    $user = $result->fetch_assoc();
}


// Check if the user is logged in
if (!isset($_SESSION["user_id"])) {
    // Redirect to login page or handle authentication
    header("Location: login.php");
    exit();
}

// Establish connection to MySQL database
$mysqli = require __DIR__ . "/database1.php";


// Check if a title is selected
if (isset($_GET['title'])) {
    $title = $_GET['title'];

    // Fetch details of the selected title from the database, filtering by user ID
    $sql = "SELECT * FROM listinginput WHERE title = '$title' AND user_id = {$_SESSION["user_id"]}";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Output the details as JSON
        echo json_encode($row);
        exit(); // Stop further execution after sending JSON response
    } else {
        echo "Listing not found";
        exit(); // Stop further execution if listing not found
    }
}

// Retrieve all listings from the database only if no title is selected
$sql = "SELECT title FROM listinginput WHERE user_id = {$_SESSION["user_id"]}";
$result = $mysqli->query($sql);

// Array to store all listing titles
$listings = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $listings[] = $row["title"];
    }
}

// Close the database connection
$mysqli->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Listing</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #FDF6F6;
            margin: 0;
            padding: 0;
        }

        /* Header styles */
        #header {
            background: #012035;
            color: white;
            padding: 5px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 5px 15px #949393;
        }

        #header img {
            border-radius: 50%;
        }

        #navbar {
            display: flex;
            align-items: center;
        }

        #navbar li {
            list-style: none;
            margin-right: 20px;
        }

        #navbar li a {
            text-decoration: none;
            font-size: 16px;
            font-weight: 600;
            color: white;
            transition: all 0.3s ease;
        }

        #navbar li a:hover {
            color: #B76E79;
        }

        /* Sub-menu styles */
        .sub-menu-wrap {
            position: fixed;
            top: 70px;
            right: 20px;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s;
        }

        .sub-menu-wrap.open-menu {
            max-height: 450px;
        }

        .sub-menu {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .sub-menu hr {
            margin: 15px 0;
            border: none;
            border-top: 1px solid #ddd;
        }

        .sub-menu-link {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
            margin: 10px 0;
            transition: all 0.3s ease;
        }

        .sub-menu-link img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .sub-menu-link:hover {
            transform: translateX(5px);
        }

        .sub-menu-link:hover p {
            font-weight: bold;
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

        footer{
    width: 100%;
    position: relative;
    background-color: #012035;
    height: 160px;
    bottom: 0;
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

        /*hovering over the navigation bar at the top causes red unline and whilst its active also causes a red underline*/
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
        .sub-menu-wrap{
            display: flex;
            align-items: center;
            text-decoration: none;
            color: black;
            margin: 12px 0;
        }
        #deletebtn {
    background-color: #B76E79;
    color: white;
    border: none;
    border-radius: 5px;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
    margin-top: 10px; /* Add margin-top for spacing */
}

#deletebtn:hover {
    background-color: #8e4f5f;
}

        
    </style>
 <script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
</head>
<body>
    <!-- Header Section -->
    <!-- Header Section -->
    <section id="header">
   
        <a href="/MainProgram/MainPage/mainLoged.php"><img src="/MainProgram/img/logo.jpg" width="80" height="auto" class="logo"></a>
        <div>
        <ul id="navbar">
                <li><a class="active" href="/MainProgram/MainPage/mainLoged.php">Home</a></li>
                <li><a href="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><img src="/MainProgram/img/userprofile2.png" onclick="toggleMenu()" width="35" height="auto"></li>
            </ul>

            <div class ="sub-menu-wrap" id = "subMenu">
            <div class = "sub-menu">
                <div class = "user-info">
                    <img src="/MainProgram/img/userprofile2.png"  width="35" height="auto">
                    <h2><?= htmlspecialchars($user["first_name"])?></h2>
                </div>
                <hr>

             
<!--                    edit profile option on drop down and the arrow next to it -->
                
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

           function toggleMenu(){
               subMenu.classList.toggle("open-menu");
           }

       </script>
    </section>


    <!-- Main Content Section -->
    <div id="myform">
        <!-- Caravan Summary Form -->
        <h1>Edit a Listing</h1>
        <form action="update_listing.php" method="post" enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <!-- Dropdown menu for selecting the listing title -->
            <select id="title" name="title">
                <?php foreach ($listings as $listing) { ?>
                    <option value="<?php echo $listing; ?>"><?php echo $listing; ?></option>
                <?php } ?>
            </select><br><br>
            <label for="price">Price:</label><br>
            £<input type="number" id="price" name="price"><br><br>
            <label for="description">Description:</label><br>
            <textarea id="description" name="description" rows="4" cols="50"></textarea><br><br>
            <label for="contact">Contact details:</label><br>
            <textarea id="contact" name="contact" rows="1" cols="50"></textarea><br><br>
            <label for="qty">Sleeps:</label><br>
            <input type="number" id="qty" name="qty"><br><br>
            <label for="location">Location:</label><br>
            <textarea id="location" name="location" rows="1" cols="50"></textarea><br><br>
            <label for="image_input">Upload Image (Click me to Upload Image):</label><br>
            <input type="file" id="image_input" onchange="previewImage(this)" accept="image/*" style="display: none;" name="image">
            <div id="upload" onclick="document.getElementById('image_input').click()">
            </div>
            <img id="picture22" src="#" alt="Preview Image">
            <input type="submit" value="Submit">
            <button type="button" id="deletebtn">Delete</button>
        </form>
    </div>

    <!-- Footer Section -->
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


  <!-- JavaScript for Previewing Image -->
<script>
    // Function to preview the uploaded image
    function previewImage(input) {
        var imgElement = document.getElementById('picture22');
        var file = input.files[0];
        var reader = new FileReader();

        reader.onload = function (e) {
            imgElement.src = e.target.result;
            imgElement.style.display = 'block'; // Display the image once loaded
        }

        reader.readAsDataURL(file);
    }
</script>

<!-- JavaScript for toggling sub-menu -->
<script>
    let subMenu = document.getElementById("subMenu");

    function toggleMenu() {
        subMenu.classList.toggle("open-menu");
    }
</script>

<!-- JavaScript for allowing line breaks in textareas -->
<script>
    var textareas = document.querySelectorAll('textarea');

    textareas.forEach(function (textarea) {
        textarea.addEventListener('keydown', function (e) {
            if (e.keyCode === 13 && !e.shiftKey) {
                e.preventDefault();
                var start = this.selectionStart;
                var end = this.selectionEnd;
                var value = this.value;
                this.value = value.substring(0, start) + "\n" + value.substring(end);
                this.selectionStart = this.selectionEnd = start + 1;
            }
        });
    });
</script>


    <!-- JavaScript for handling form autofill -->
<script>
    // JavaScript code to handle form autofill based on dropdown selection
    document.getElementById('title').addEventListener('change', function() {
        // Get the selected title
        var selectedTitle = this.value;

        // Fetch the details of the selected title from the server using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'EditListing.php?title=' + selectedTitle, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    // Parse the JSON response
                    var data = JSON.parse(xhr.responseText);

                    // Fill out the form fields with the retrieved data
                    document.getElementById('price').value = data.price;
                    document.getElementById('description').value = data.description;
                    document.getElementById('contact').value = data.contact;
                    document.getElementById('qty').value = data.qty;
                    document.getElementById('location').value = data.location;

                    // Optionally, update the image preview as well
                    document.getElementById('picture22').src = data.image_path;
                    document.getElementById('picture22').style.display = 'block';
                } else {
                    // Handle error
                    console.error('Error fetching listing details');
                }
            }
        };
        xhr.send();

        // JavaScript for handling deletion
        document.getElementById('deletebtn').addEventListener('click', function() {
            var titleToDelete = document.getElementById('title').value; // Get the selected title

            // Confirm deletion with the user
            if (confirm('Are you sure you want to delete this listing?')) {
                // Send an AJAX request to delete_listing.php
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '/MainProgram/deleteListing/delete_listing.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            // if succesful user is redirected
                            header("Location: /MainProgram/viewCaravans/viewcaravans.php");
                        } else {
                            // Handling the error
                            alert('Error deleting listing');
                        }
                    }
                };
                xhr.send('delete_title=' + encodeURIComponent(titleToDelete)); // Send the selected title as a parameter
            }
        });
    });

    // Automatically fill form fields if there's only one listing available
    if (<?= count($listings) ?> === 1) {
        // Get the title of the only listing
        var singleTitle = '<?php echo $listings[0]; ?>';

        // Trigger change event on the dropdown to auto-populate form fields
        document.getElementById('title').value = singleTitle;
        document.getElementById('title').dispatchEvent(new Event('change'));
    }

</script>
