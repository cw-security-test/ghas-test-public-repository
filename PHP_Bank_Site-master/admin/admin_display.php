<?php
	session_start();
?>
<html>
	<head>
		<title>PHP Bank - Admin</title>
		<link rel="stylesheet" type="text/css" href="../style/index.css">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<style>body { font-family: Consolas, sans-serif; }</style>
	</head>
	<body>
		<?php
			if($_SESSION['user_id']!="admin")
			{
				echo "<script>alert('Your not admin. Signin to admin account.');</script>";
				echo "<script>location.href='../index.php?page=index'</script>";
			}
		?>
		<nav id="topMenu">
			<ul>
				<li><a class="menuLink" href="?page=member">Member</a></li>
				<li><a class="menuLink" href="?page=log">Log</a></li>
				<li><a class="menuLink" href="?page=qna">QnA</a></li>
				<li><a class="menuLink" href="?page=logout">Logout</a></li>
			</ul>
		</nav>

		<br><br>

		<nav id="content">
			<?php
				if($_GET['page']=="member"){
					include 'information_members.php';
				}
				if($_GET['page']=="log"){
					include 'information_logs.php';
				}
				if($_GET['page']=="qna"){
					include 'information_qna.php';
				}
				if(isset($_GET['no']))
				{
					if($_GET['page']=="answer")
					{
						include "answer_qna.php";
					}
				}
				if($_GET['page']=="logout"){
					include 'admin_logout.php';
				}
			?>
		</nav>
	</body>
</html>