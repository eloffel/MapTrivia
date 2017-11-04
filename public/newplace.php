<?php

    require(__DIR__ . "/../includes/config.php");

    $name = $_POST['name'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    // ensure proper usage
    if (empty($lng) || empty($lat) || (empty($name)))
    {
        http_response_code(400);
        exit;
    }
    
    //sends the information about the new place to a mysql table
    CS50::query("INSERT IGNORE INTO places (title, latitude, longitude, id_user) VALUES(?, ?, ?, ?)", $name, $lat, $lng, $_SESSION["id"]);
 
?>