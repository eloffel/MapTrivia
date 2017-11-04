<?php

    require(__DIR__ . "/../includes/config.php");

    // ensure proper usage
    if (!isset($_GET["id_place"]))
    {
        http_response_code(400);
        exit;
    }

    // find all comments
    $rows = CS50::query("SELECT * FROM comments WHERE id_place = ? ORDER BY rate DESC", $_GET["id_place"]);
    for($i = 0;$i < count($rows);$i++)
    {
        $username = CS50::query("SELECT username FROM users WHERE id_user = ?", $rows[$i]["id_user"]);
        $rows[$i]["username"] = $username[0]["username"]; // add the username of the user who created the trivia to the array, so it can be displayed
    }
    for($i = 0;$i < count($rows);$i++) // checks if the user has already voted
    {
        $vote = CS50::query("SELECT vote FROM votes WHERE id_user = ? AND id_comment = ?", $_SESSION["id"], $rows[$i]["id_comment"]);
        if (empty($vote))
        {
            $rows[$i]["upvote"] = "";
            $rows[$i]["downvote"] = "";
        }
        else if ($vote[0]["vote"] == 1)
        {
            $rows[$i]["upvote"] = "disabled";
            $rows[$i]["downvote"] = "";
        }
        else if ($vote[0]["vote"] == -1)
        {
            $rows[$i]["downvote"] = "disabled";
            $rows[$i]["upvote"] = "";
        }
    }
    for($i = count($rows)-1;$i >= 0;$i--)
    {
        $rows[$i+1]=$rows[$i];
    }
    $place_user = CS50::query("SELECT username FROM users WHERE id_user = ?", $_GET["id_user"]); // adds the username of the user who created the place to the array
    $rows[0] = $place_user[0]["username"];
    
    // output places as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($rows, JSON_PRETTY_PRINT));

?>