<?php
	include '../config/database.php';
	session_start();
	$conn = mysqli_connect( $host, $user, $pw, $dbName);
	if($_SESSION['user_id']!='admin')
	{
		echo "<script>alert('Your not admin. Signin admin account.');</script>";
		echo "<script>location.href='admin.html'</script>";
	}
	$answer=$_POST['answer'];
	$no=$_POST['no'];
	$date=date('Y-n-j');
	$time=date('h:i:s');
	
	if($no==''||$answer=='')
	{
			echo "<script>alert('Please enter contents.')</script>";
			echo "<script>location.href='admin_display.php?page=qna'</script>";
	}else
	{
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare("insert into Board_Reply values(?,?,?,?)");
		$stmt->bind_param('ssss', $no, $answer, $date, $time);
		
		if($stmt->execute()){
			$stmt->close();
			$conn->close();
			echo "<script>alert('Success reply!');</script>";
			echo "<script>location.href='admin_display.php?page=answer&no=".$no."';</script>";
		}else
		{
			$stmt->close();
			$conn->close();
			echo "<script>alert('Fail reply.');</script>";
			echo "<script>location.href='admin_display.php?page=answer&no=".$no."';</script>";
		}
	}
	
?>