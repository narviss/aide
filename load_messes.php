<?php
//Подключаемся к БД
include("bd.php");
//Выбираем все сообщения
$bd = new mysqli( 'localhost', 'check_pg', 'check_pg_password' , 'codic') or die("Error");
$result = $bd->query("SELECT * FROM `messages` ORDER BY `id`");
//Выводим все сообщения на экран
while($d=$result->fetch_array())
{
	echo "<b><font color='orange'>".$d['login'].": </font></b>".$d['message']."<br>";
}
?>