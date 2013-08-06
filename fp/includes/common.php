<?php

/***********************************************************************
* common.php
*
* Renata Cummins
* Final Project
*
* Code common to (i.e., required by) most pages.
**********************************************************************/


    // display errors
    ini_set("display_errors", true);
    error_reporting(E_ALL ^ E_NOTICE);

    // requirements
    require_once("constants.php");
    require_once("helpers.php");

    // enable sessions
    if (preg_match("{^(/~[^/]*/)}", $_SERVER["REQUEST_URI"], $matches))
        session_set_cookie_params(0, $matches[1]);
    session_start();

    // require authentication for most pages
    if (!preg_match("/(:?log(:?in|out)|register)\d*\.php$/", $_SERVER["PHP_SELF"]))
    {
        if (!isset($_SESSION["name"]))
            redirect("login.php");
    }

    // ensure database's name, username, and password are defined
    if (!DB_NAME) apologize("You left DB_NAME blank.");
    if (!DB_USER) apologize("You left DB_USER blank.");
    if (!DB_PASS) apologize("You left DB_PASS blank.");

    // connect to database server
    if (($connection = mysql_connect(DB_SERVER, DB_USER, DB_PASS)) === FALSE)
        apologize("Could not connect to database server (" . DB_SERVER . ").");

    // select database
    if (mysql_select_db(DB_NAME, $connection) === FALSE)
        apologize("Could not select database (" . DB_NAME . ").");

?>
