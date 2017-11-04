<?php

    require(__DIR__ . "/../includes/config.php");

    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        $origin = CS50::query("SELECT initialLat, initialLong FROM users WHERE id_user = ?", $_SESSION["id"]); //gets the origin to initialize the map
        header("Content-type: application/json");
        print(json_encode($origin, JSON_PRETTY_PRINT));
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $lat = $_POST["lat"];
        $lng = $_POST["lng"];
    
        CS50::query("UPDATE users SET initialLat = ?, initialLong = ? WHERE id_user= ?", $lat, $lng, $_SESSION["id"]); //stores the new origin
    }
?>