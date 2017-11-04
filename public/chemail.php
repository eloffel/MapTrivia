<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("chemail_form.php", ["title" => "Change Email"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $rows = CS50::query("SELECT * FROM users WHERE id_user = ?", $_SESSION["id"]);
        $row = $rows[0];
        if (empty($_POST["new_email"]))
        {
            apologize("You must provide your new email.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if (password_verify($_POST["password"], $row["hash"]))
        {
            CS50::query("UPDATE users SET email = ? WHERE id_user = ?", $_POST["new_email"], $_SESSION["id"]);
            // redirect to home
            redirect("/");
        }
        else
        {
            apologize("Invalid password.");
        }
    }


?>