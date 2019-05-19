<?php
function doDB() {
   global $mysqli;

//connect to server and select database - OOP
$mysqli = new mysqli('localhost','root','','testDB');

//if connection fails, stop script execution
 if ($mysqli->connect_error) {
        printf('Connect failed: %s\n', $mysqli->connect_error);
 exit();
 }
 }

