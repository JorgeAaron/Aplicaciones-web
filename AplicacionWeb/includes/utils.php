<?php

// Función para imprimir mensajes
function printMsg($msg, $type) {
	echo "<div class=\"$type\">";
	if(is_array($msg)) {
		echo "<ul>";
		foreach ($msg as $caca) {
			echo "<li>$caca</li>\n";
		}
		echo "</ul>";
	}
	else {
		echo $msg;
	}
	echo "</div>";
}


/* Lógica para cerrar sesión
if(isset($_GET['logout']) && $_GET['logout'] == 'true') {
	session_destroy();
	header('Location: login.php?loggedOut=true');
}*/

?>
