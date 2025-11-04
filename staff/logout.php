<?php
	session_start();
	session_unset();
	session_destroy();
	header("Location: /FOODIE/landing-page/index.html");
?>