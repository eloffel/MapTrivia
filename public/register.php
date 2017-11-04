<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        render2("register_form.php", ["title" => "Register"]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        if (strpos($_POST["username"], ' ') != false)
        {
            apologize("Your username cannot contain spaces");
        }
        if (ctype_lower($_POST["username"]) != true)
        {
            apologize("Your username cannot contain capital letters");
        }
        if (empty($_POST["firstname"]))
        {
            apologize("You must provide your first name.");
        }
        if (empty($_POST["lastname"]))
        {
            apologize("You must provide your last name.");
        }
        if (empty($_POST["email"]))
        {
            apologize("You must provide your email.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
        else if ($_POST["password"] != $_POST["confirmation"])
        {
            apologize("The password and the confirmation do not match.");
        }
        else
        {
            if(!empty(CS50::query("SELECT * FROM users WHERE username = ?", $_POST["username"])))
            {
                apologize("That username appears to be taken.");
            }
            if(!empty(CS50::query("SELECT * FROM users WHERE email = ?", $_POST["email"])))
            {
                apologize("This email account is already being used.");
            }
            else
            {
                CS50::query("INSERT IGNORE INTO users (username, first_name, last_name, email, hash) VALUES(?, ?, ?, ?, ?)", $_POST["username"], $_POST["firstname"], $_POST["lastname"], $_POST["email"], password_hash($_POST["password"], PASSWORD_DEFAULT));
                $rows = CS50::query("SELECT LAST_INSERT_ID() AS id");
                $id = $rows[0]["id"];
                
                // remember that user's now logged in by storing user's ID in session
                $_SESSION["id"] = $id;

                // redirect to portfolio
                redirect("/");
            }
        }
    }

?>