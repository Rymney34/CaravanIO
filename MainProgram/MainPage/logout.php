<?php
session_start();

session_destroy();

header('Location: /MainProgram/index.php');

exit();
