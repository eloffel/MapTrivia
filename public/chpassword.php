<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render("chpassword_form.php", ["title" => "Change Password"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        $rows = CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"]);
        $row = $rows[0];
        if (empty($_POST["old_password"]))
        {
            apologize("You must provide your old password.");
        }
        else if (empty($_POST["new_password"]))
        {
            apologize("You must provide your new password.");
        }
        else if ($_POST["new_password"] != $_POST["confirmation"])
        {
            apologize("The new password and the confirmation do not match.");
        }
        else if (password_verify($_POST["old_password"], $row["hash"]))
        {
            CS50::query("UPDATE users SET hash = ? WHERE username = ?", password_hash($_POST["new_password"], PASSWORD_DEFAULT), $_POST["username"]);
            // redirect to home
            redirect("/");
        }
        else
        {
            apologize("Invalid password.");
        }
    }


?>