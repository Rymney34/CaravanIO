<?php
// if(empty($_POST["first_name"])){
//     die("First name is required");
// }

// if (empty($_POST["last_name"])) {
//     die("Last name is required");
// }

// if (empty($_POST["email"])) {
//     die("Email is required");
// }


// if (empty($_POST["username"])) {
//     die("Username is required");
// }

// if (empty($_POST["password"])) {
//     die("Password is required");
// }


$mysqli = require __DIR__ . "/database.php";

//to check if email exists and handling
$sql_check_email = "SELECT * FROM user WHERE email = ?";
$stmt_check_email = $mysqli->prepare($sql_check_email);
$stmt_check_email->bind_param("s", $_POST["email"]);
$stmt_check_email->execute();
$result_check_email = $stmt_check_email->get_result();

if ($result_check_email->num_rows > 0) {
    die("Credentials already exist");
    ?>
    <!-- <script> alert("GG") </script> -->
    <?php
}
//to hash the password for secruity so if database is hacked the user password is not compromised
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


$sql = "INSERT INTO user (first_name, last_name, username, email, password)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $mysqli->stmt_init();
//to help us identify any errors with the sql
if (!$stmt->prepare($sql)) {
    die("SQL error: " . $mysqli->error);
}



//
$stmt->bind_param("sssss",
    $_POST["first_name"],
    $_POST["last_name"],
    $_POST["username"],
    $_POST["email"],
    $password_hash);

if ($stmt->execute()) {
    header("Location: signupsuccess.html");
    exit();
}

$stmt->close();
$mysqli->close();
?>
