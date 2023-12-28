<?php session_start(); ?>
<html>
<head>
	<title>PHP Bank</title>
	<link rel="stylesheet" type="text/css" href="style/index.css">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<style>
			body { font-family: Consolas, sans-serif; }
	</style>
</head>
<body>
	
	
	<img src="image/bank_main.jpg" alt="main" width="1250" height="200">

	<nav id="topMenu">
		<ul>
			<li><a class="menuLink" href="?page=index"><b>Home</b></a></li>
			<?php //세션이 존재한다면 로그아웃으로 표시, 존재하지 않는다면 로그인으로 표시
			if(isset($_SESSION['user_id']) AND isset($_SESSION['user_name']))
			{ 
				echo "<li><a class='menuLink' href='?page=logout'>Logout</a></li>";
			}else
			{
				echo "<li><a class='menuLink' href='?page=signin'>Sign in</a></li>";
			}
			?>
			<li><a class="menuLink" href="?page=signup">Sign up</a></li>
			<li><a class="menuLink" href="?page=mypage">My page</a></li>
			<li><a class="menuLink" href="?page=qna">QnA</a></li>
			<li><a class="menuLink" href="?page=chat">Chat</a></li>
		</ul>
		<ul>
			<li><a class="menuLink" href="?page=lookup">Lookup</a></li>
			<li><a class="menuLink" href="?page=deposit">Deposit</a></li>
			<li><a class="menuLink" href="?page=transfer">Transfer</a></li>
			<li><a class="menuLink" href="?page=opening">Opening</a></li>
			<li><a class="menuLink" href="?page=termination">Termination</a></li>
			<li><a class="menuLink" href="?page=insurance">Insurance</a></li>
			
		</ul>
	</nav>
	
	<br><br><br><br><br><br>
	
	<div id="hellowords">
		
	<?php if(isset($_SESSION['user_id']) AND isset($_SESSION['user_name'])){ ?>
	<?php echo "Hello! ".$_SESSION['user_name']; ?>	
	<?php }?>
	<br>
	</div>
	
	<nav id="content">
		
		<?php
		
		if($_GET['page']=="transfer"){
			include 'transfer.html';
		}
		if($_GET['page']=="lookup"){
			include 'lookup.html';
		}
		if($_GET['page']=="insurance"){
			include 'insurance.html';
		}
		if($_GET['page']=="inquery"){
			include 'inquery.php';
		}
		if($_GET['page']=="signin"){
			include 'signin.html';
		}
		if($_GET['page']=="signup"){
			include 'signup.html';
		}
		if($_GET['page']=="logout"){
			include 'logout.php';
		}
		if($_GET['page']=="index"){
			include 'introduce.html';
		}
		if($_GET['page']=="opening"){
			include 'opening.html';
		}
		if($_GET['page']=="deposit"){
			include 'deposit.html';
		}
		if($_GET['page']=="termination"){
			include 'termination.html';
		}
		if($_GET['page']=="admin"){
			include 'admin.html';
		}
		if($_GET['page']=="mypage"){
			include 'mypage.html';
		}
		if($_GET['page']=="qna"){
			include 'board.html';
		}
		if($_GET['page']=="write"){
			include 'board_write.html';
		}
		if($_GET['page']=="board_lookup"){
			if(isset($_GET['no']))
			{
				include 'board_lookup.html';
			}else
			{
				echo "<script>alert('Wrong Access.');</script>";
				echo "<script>location.href='index.php'</script>";
			}
		}
		if($_GET['page']=="chat"){
			
			include 'chat.html';
		}
		?>
	</nav>
</body>
</html>