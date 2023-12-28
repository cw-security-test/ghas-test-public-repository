
<?php
	include 'index.php';
	if(!isset($_SESSION['user_id']) OR !isset($_SESSION['user_name']))
	{
		echo "<script>alert('Access Denied. Signin please.');</script>";
		echo "<script>location.href='index.php?page=signin'</script>";
	}
	echo "<HTML>";
	echo "<TITLE>PHP Bank - QnA</TITLE>";
	echo "<link rel='stylesheet' type='text/css' href='style/index.css'>";
	echo "<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>";
	echo "<style>body { font-family: Consolas, sans-serif; }</style>";
	echo "<HEAD><li>Menu : QnA<br></li>";
	echo "";
	echo "</HEAD>";
	echo "<BODY></BODY>";
	echo "</HTML>";
?>
	
	
		
	

