<?
	$connect = mysqli_connect('сервер', 'логин', 'пароль', 'названиеБД');
	if (!$connect) {
		die('Error connect to DataBase');
	}
?>
