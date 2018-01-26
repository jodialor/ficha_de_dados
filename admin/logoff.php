<?php
//destroi a sessão (logoff)
	session_start();
	session_destroy();
	echo "<meta HTTP-EQUIV='REFRESH' content='0; url=index.php?mod=login'>";
?>