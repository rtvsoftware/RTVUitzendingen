<?php


// Host MySql
$dbhost = 'localhost';
// mySql user
$dbuser = '';
// mySql password
$dbpasswd = '';
// Schame name
$dbname = 'rtvuitzendingen';

// Prefix tabellen.
// (verander alleen deze waarde als u weet waarvoor)
$dbtable_prefix = 'rtvuitzendingen_';

// Upload locatie afbeeldingen
$images = "/images";

// URL root waar deze RTVUitzendingen beschikbaar is. Bijvoorbeeld:
// $urlroot = "https://www.omroepsite.nl/rtvuitzendingen";  
//   of
// $urlroot = "https://rtvuitzendingen.omroepsite.nl";
$urlroot =  (isset($_SERVER['HTTPS']) ? "https" : "http") ."://".$_SERVER['HTTP_HOST'];


?>
