<?php
if (isset($_SESSION['login'])) {
	header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
} else {
	if (!empty($_POST)) {
		if (empty($_POST['f']['username']) || empty($_POST['f']['password'])
		) {
			$message['error'] = 'Es wurden nicht alle Felder ausgefüllt.';
		} else {
			$mysqli = @new mysqli('localhost', 'root', '', 'loginsystem');
			if ($mysqli->connect_error) {
				$message['error'] = 'Datenbankverbindung fehlgeschlagen: ' . $mysqli->connect_error;
			} else {
				$query = sprintf(
					"SELECT username, password FROM users WHERE username = '%s'",
					$mysqli->real_escape_string($_POST['f']['username'])
				);
				$result = $mysqli->query($query);
				if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					if (crypt($_POST['f']['password'], $row['password']) == $row['password']) {
						session_start();
						
						$_SESSION = array(
							'login' => true,
							'user'  => array(
								'username'  => $row['username']
							)
						);
						$message['success'] = 'Anmeldung erfolgreich, <a href="index.php">weiter zum Inhalt.';
						header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
					} else {
						$message['error'] = 'Das Kennwort ist nicht korrekt.';
					}
				} else {
					$message['error'] = 'Der Benutzer wurde nicht gefunden.';
				}
				$mysqli->close();
			}
		}
	} else {
		$message['notice'] = 'Geben Sie Ihre Zugangsdaten ein um sich anzumelden.<br />' .
			'Wenn Sie noch kein Konto haben, gehen Sie <a href="./register.php">zur Registrierung</a>.';
	}
}
?>