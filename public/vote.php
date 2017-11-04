<?php

    require(__DIR__ . "/../includes/config.php");

    $id_comment = $_POST['id_comment'];
    // ensure proper usage
    if (empty($id_comment))
    {
        http_response_code(400);
        redirect("/");
        exit;
    }
    
    $previous_vote = CS50::query("SELECT vote FROM votes WHERE id_comment = ? AND id_user = ?", $id_comment, $_SESSION["id"]);
    $rate = CS50::query("SELECT rate FROM comments WHERE id_comment = ?", $id_comment);
    if (empty($previous_vote)) //if it is the first time the user votes in the trivia
    {
        $rate = $rate[0]["rate"] + $_POST["vote"];
        CS50::query("INSERT IGNORE INTO votes (id_comment, vote, id_user) VALUES(?, ?, ?)", $id_comment, $_POST["vote"], $_SESSION["id"]);
        CS50::query("UPDATE comments SET rate = ? WHERE id_comment = ?", $rate, $id_comment);
    }
    else //if it is not
    {
        $rate = $rate[0]["rate"] + 2*$_POST["vote"];
        CS50::query("UPDATE votes SET vote = ? WHERE id_comment = ? AND id_user = ?", $_POST["vote"], $id_comment, $_SESSION["id"]);
        CS50::query("UPDATE comments SET rate = ? WHERE id_comment = ?", $rate, $id_comment);
    }
?>