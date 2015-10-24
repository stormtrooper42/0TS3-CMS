<?php
// load framework files

require_once("libraries/TeamSpeak3/TeamSpeak3.php");

$usrname = ""; //QUERY USERNAME
$pass = ""; //QUERY PASSWORD
$host = "127.0.0.1";
$qport = "10011"; // QUERY PORT

/* connect to server, authenticate and get TeamSpeak3_Node_Server object by URI */
$ts3_serv = TeamSpeak3::factory("serverquery://$usrname:$pass@$host:$qport/");
