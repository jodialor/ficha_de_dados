<?php
error_reporting(0);
$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "egcead_pessoal";


$mysqlcon = MYSQL_CONNECT($hostname, $username, $password) OR
DIE("N\xe3o \xe9 poss\xedvel conectar-se \xe0 base de dados");
@mysql_select_db("$dbName") OR
DIE("N\xc3o \xe9 poss\xedvel selecionar a Base de Dados");

/*
// Create connection
$con=mysqli_connect($hostname, $username, $password,$dbName) OR
DIE("Nao é possível conectar-se à base de dados: ". mysqli_connect_error());
*/
?>
