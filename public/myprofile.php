<?php

    // configuration
    require("../includes/config.php");

    $user = CS50::query("SELECT * FROM users WHERE id_user = ?", $_SESSION["id"]); 
    
    // array that will contain information about the user
    $data = [
                "username" => $user[0]["username"],
                "full_name" => $user[0]["first_name"]." ".$user[0]["last_name"],
                "email" => $user[0]["email"]
            ];
    $places = CS50::query("SELECT title,latitude,longitude, number_facts FROM places WHERE id_user = ? ORDER BY number_facts DESC", $_SESSION["id"]);
    $data["places"]=count($places);
    $trivias = CS50::query("SELECT id_place, text, rate FROM comments WHERE id_user = ? ORDER BY rate DESC", $_SESSION["id"]);
    $data["trivia"]=count($trivias);
    $upvotes = 0;
    $i = 0;
    foreach ($trivias as &$trivia) //adds the name of the place to every comment and counts the number of upvotesadds the name of the place to every comment and counts the number of upvotes
    {
        $title_place = CS50::query("SELECT title FROM places WHERE id_place = ?", $trivia["id_place"]);
        $trivias[$i]["title"] = $title_place[0]["title"];
        $upvotes += $trivia["rate"];
        $i += 1;
    }
    $data["upvotes"] = $upvotes;
    
    $place_ach = 0;
    $trivia_ach = 0;
    $upvote_ach = 0;
    
    //checks the number of upvotes, trivias and places to give the user the achievements he deserves
    
    if($data["upvotes"] > 4)
    {
        $upvote_ach += 1;
        if($data["upvotes"] > 19)
        {
            $upvote_ach += 1;
            if($data["upvotes"] > 49)
            {
                $upvote_ach += 1;
                if($data["upvotes"] > 149)
                {
                    $upvote_ach += 1;
                    if($data["upvotes"] > 299)
                    {
                        $upvote_ach += 1;
                    }
                }
            }
        }
    }
    if($data["trivia"] > 0)
    {
        $trivia_ach += 1;
        if($data["trivia"] > 4)
        {
            $trivia_ach += 1;
            if($data["trivia"] > 14)
            {
                $trivia_ach += 1;
                if($data["trivia"] > 49)
                {
                    $trivia_ach += 1;
                    if($data["trivia"] > 99)
                    {
                        $trivia_ach += 1;
                        if($data["trivia"] > 249)
                        {
                            $trivia_ach += 1;
                        }
                    }
                }
            }
        }
    }
    if($data["places"] > 0)
    {
        $place_ach += 1;
        if($data["places"] > 4)
        {
            $place_ach += 1;
            if($data["places"] > 14)
            {
                $place_ach += 1;
                if($data["places"] > 49)
                {
                    $place_ach += 1;
                    if($data["places"] > 99)
                    {
                        $place_ach += 1;
                    }
                }
            }
        }
    }
    
    $data["place_ach"] = $place_ach;
    $data["trivia_ach"] = $trivia_ach;
    $data["upvote_ach"] = $upvote_ach;
    $data["total_ach"] = $place_ach + $trivia_ach + $upvote_ach;
    
    // define what will be the user's title
    $data["title"] = "Acolyte";
    if ($data["total_ach"]>5)
    {
        $data["title"] = "Apprentice";
        if ($data["total_ach"]>10)
        {
            $data["title"] = "Master";
            if ($data["total_ach"]>10)
            {
                $data["title"] = "Dark Lord"; // pardon
            }
        }
    }
    $data["full_user"] = $data["title"]." ".$data["username"];
    // render portfolio
    render("profile.php", ["data" => $data, "title" => "Profile", "trivias" => $trivias, "places" => $places]);

?>
