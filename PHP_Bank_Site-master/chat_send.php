<?php
	session_start();
	if(!isset($_SESSION['user_id']) OR !isset($_SESSION['user_name']))
	{
		echo "<script>alert('Access Denied. Signin please.');</script>";
		echo "<script>location.href='index.php?page=signin'</script>";
	}
	$content=$_GET['content'];
	$date=date('Y-n-j');
	$time=date('h:i:s');

	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>locastion.href='index.php'</script>";
	}
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("insert into Chat(ID,Content,Date,Time) values(?, ?, ?, ?)");
	$stmt->bind_param('ssss', $_SESSION['user_id'], $content, $date, $time);
	if($stmt->execute()){
		echo "success";
	}else
	{
		echo "fail";
	}
	echo "<script>location.href='index.php?page=chat'</script>";
?>