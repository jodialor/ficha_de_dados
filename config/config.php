<?php
error_reporting(0);
$hostname = "localhost";
$username = "root";
$password = "";
$dbName = "egcead_pessoal";


$mysqlcon = MYSQL_CONNECT($hostname, $username, $password) OR
DIE("Nao e' possivel conectar-se 'a base de dados");
@mysql_select_db("$dbName") OR
DIE("Nao e' possivel selecionar a Base de Dados");


// Create connection
//$con=mysqli_connect($hostname, $username, $password,$dbName) OR
//DIE("Nao é possível conectar-se à base de dados: ". mysqli_connect_error());


?>
