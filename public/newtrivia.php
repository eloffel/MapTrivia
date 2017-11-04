<?php

    require(__DIR__ . "/../includes/config.php");

    $trivia = $_POST['trivia'];
    $place = $_POST['place'];
    // ensure proper usage
    if (empty($place) || empty($trivia))
    {
        http_response_code(400);
        exit;
    }

    CS50::query("INSERT IGNORE INTO comments (id_place, text, id_user) VALUES(?, ?, ?)", $place, $trivia, $_SESSION["id"]); // adds the new trivia to mysql
    CS50::query("UPDATE places SET number_facts = number_facts + 1 WHERE id_place = ?",$place); //updates the number of trivia in the place
?>