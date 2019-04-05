<?php
	Session_start();
	$_SESSION = array();
	Session_destroy();
	header('Location: ./');
?>
