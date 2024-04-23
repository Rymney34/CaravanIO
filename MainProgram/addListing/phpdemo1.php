<?php
session_start();
if (isset($_SESSION["user_id"])){
    $mysqli=require __DIR__."/database.php";

    $sql = "SELECT * FROM user WHERE user_id = {$_SESSION["user_id"]}";

    $result= $mysqli->query($sql);

    $user = $result->fetch_assoc();
}
$errors = [];
$success_message = ""; // Initialize success message variable if we want to add one

function validateInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $targetDirectory = "uploads/";
    $targetFile = $targetDirectory . basename($_FILES["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if any field is empty
    if (empty($_POST['title']) || empty($_POST['price']) || empty($_POST['description']) || empty($_POST['contact']) || empty($_POST['qty']) || empty($_POST['location'])) {
        $errors["empty"] = "All fields are required.";
    } else {
        // Validate image file
        if(isset($_POST["submit"])) {
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                $uploadOk = 1;
            } else {
                $errors["image"] = "File is not an image.";
                $uploadOk = 0;
            }
        }

        if ($_FILES["image"]["size"] > 500000) {
            $errors["image"] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            $errors["image"] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $errors["image"] = "Sorry, your file was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                // Change success message
                $success_message = "Your caravan has been successfully listed.";
                $imageFileName = basename($_FILES["image"]["name"]);

                // Establish database connection
                $conn = new mysqli('localhost', 'root', '', 'assignment');
                if ($conn->connect_error) {
                    die('Connection Failed : ' . $conn->connect_error);
                }

                // Prepare SQL statement
                $stmt = $conn->prepare("INSERT INTO listinginput (title, price, description, contact, qty, location, image, user_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->bind_param("ssssissi", $title, $price, $description, $contact, $qty, $location, $imageFileName, $_SESSION["user_id"]);

                // Set parameters and execute
                $title = validateInput($_POST['title']);
                $price = validateInput($_POST['price']);
                $description = validateInput($_POST['description']);
                $contact = validateInput($_POST['contact']);
                $qty = validateInput($_POST['qty']);
                $location = validateInput($_POST['location']);

                $stmt->execute();

                $stmt->close();
                $conn->close();

                // Redirect to summary page after successful listing
                header("Location: /MainProgram/CaravanSummary/caravansummary.php?title=" . urlencode($title));
                exit();
            } else {
                $errors["image"] = "Sorry, there was an error uploading your file.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listing Caravan</title>
    <style>
         body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #FDF6F6;
            margin: 0;
            padding: 0;
        }

        /* Header styles */
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
        /*next arrow location*/
        .prev {
            position: absolute;
            top: 50%;
            right: 95%;
            font-size: 2em ;
            cursor: pointer;
        }
        /*next arrow location*/
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
            margin-top: 5%;
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
            border: 2px solid transparent;
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

    </style>
</head>
<script src="https://kit.fontawesome.com/cef40a4c0b.js" crossorigin="anonymous"></script>
<body>

   <!-- Header Section -->
   <section id="header">
        <a href="/MainProgram/MainPage/mainLoged.php"><img src="/MainProgram/img/logo.jpg" width = "80" height="auto" class="logo"></a>
        <div>
            <ul id="navbar">
                <li><a class="active" href ="/MainProgram/MainPage/mainLoged.php">Home</a></li>
                <li><a href ="/MainProgram/viewCaravans/viewcaravans.php">View Caravans</a></li>
                <li><a href ="/MainProgram/aboutUs/aboutus.php">About Us</a></li>
                <li><img src="/MainProgram/img/userprofile2.png" onclick="toggleMenu()" width="35" height="auto"></a> </li>
            </ul>

            <div class ="sub-menu-wrap" id = "subMenu">
            <div class = "sub-menu">
                <div class = "user-info">
                    <img src="/MainProgram/img/userprofile2.png"  width="35" height="auto">
                   <h2><?= htmlspecialchars($user["first_name"])?></h2>
                </div>
                <hr>

                
                <a href="phpdemo1.php" class="sub-menu-link">
                    <img src="/MainProgram/img/add.png" width="17" height="auto">
                    <p>Add Listing </p>
                    <span>></span>
                    <!--                    edit add listing  option on drop down and the arrow next to it -->
                </a>
                <a href="/MainProgram/editListing/EditListing.php" class="sub-menu-link">
                    <img src="/MainProgram/img/edit.png" width="17" height="auto">
                    <p>Edit Listing</p>
                    <span>></span>
                    <!--                    edit edit listing option on drop down and the arrow next to it -->
                </a>
                
                <a href="/MainProgram/MainPage/logout.php" class="sub-menu-link">
                    <img src="/MainProgram/img/logout.png" width="17" height="auto">
                    <p>Log Out</p>
                    <span>></span>
                    <!--                    edit log out option on drop down and the arrow next to it -->
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
<div id="myform">
    <h1>List a Caravan</h1>
    <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
        <div class="error-message">
            <?php foreach ($errors as $error): ?>
                <p><?php echo $error; ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" id="myyform" method="post" enctype="multipart/form-data">

        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title"><br><br>

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
        <input type="file" id="image_input" name="image" onchange="previewImage(this)" accept="image/*" style="display: none;">

        <div id="upload" onclick="document.getElementById('image_input').click()">
            Click here to upload image
        </div>
        <img id="picture22" src="#" alt="Preview Image">
        <input type="submit" id="mysubmit" name="submit" value="Submit">
    </form>
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

</body>
</html>