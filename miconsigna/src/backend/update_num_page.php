<?php
session_start();
require_once __DIR__ . "/ajax_helpers.php";
header("Content-Type: application/json");

if(!isset($_SESSION['numPage'])) {
    $_SESSION['numPage'] = 1;
}


if(isset($_GET['page']) && is_numeric($_GET['page'])) {
    
    $_SESSION['numPage'] = $_GET['page'];
    print_r($_SESSION);
}

echo jsonResponse(1, "Updated session page");