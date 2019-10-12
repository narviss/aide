<?php
//Проверям есть ли переменные на добавление
if(isset($_POST['mess']) && $_POST['mess']!="" && $_POST['mess']!=" ")
{
	//Стартуем сессию для записи логина пользователя
	session_start();
	//Принимаем переменную сообщения
	$mess=$_POST['mess'];
	//Переменная с логином пользователя
	$login=$_POST['login'];
	//Подключаемся к базе
	$bd = new mysqli( 'localhost', 'check_pg', 'check_pg_password' , 'codic') or die("Error");
	$result = $bd->query("INSERT INTO `messages` (`login`,`message`) VALUES ('".$login."','".$mess."') ");
}
?>