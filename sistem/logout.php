<?php
	session_start();
	if(ISSET($_SESSION['user_session']))
	{
		UNSET($_SESSION['user_session']);
		UNSET($_SESSION['type_session']);
	}

	if(session_destroy())
	{
		header("location: ../sistem.php?sistem=login&x=".base64_encode(84)."");
	}
?>
