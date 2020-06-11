<?php

$host = "127.0.0.1";
$username = "zardasht";
$password = "Zardasht.11";
$dbname = "xomali_db";

$connection = mysqli_connect($host, $username, $password, $dbname);

if (!$connection)
{
    die("Connection failed: ". mysqli_connect_error());
}
