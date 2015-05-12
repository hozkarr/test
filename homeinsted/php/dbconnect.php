<?php 

$con = mysql_connect("localhost","root","kirby94") or die (mysql_error()); //

if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db("cdr", $con); // para server
mysql_query('SET NAMES UTF-8');


