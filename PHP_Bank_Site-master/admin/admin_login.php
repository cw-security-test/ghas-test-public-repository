<?php
	$id=$_POST['id'];
	$chkPW=$_POST['pw'];
	echo $pw;
	$chkPW=sha1($chkPW);

	IF(empty($id) OR empty($chkPW)){
		echo "<script>alert('Wrong access.');</script>";
		echo "<script>location.href='../index.php';</script>";
	}
	
	IF($id!='admin'){
		echo "<script>alert('Your not administrator.');</script>";
		echo "<script>location.href='../index.php';</script>";
	}

	include '../config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>locastion.href='index.php'</script>";
	}

	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select PW from Members where ID='admin'");
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();

	if($chkPW==$data['PW'])
	{
		session_start();
		$_SESSION['user_id']='admin';
		$_SESSION['user_name']='admin';
		echo "<script>alert('Hello Admin!');</script>";
		echo "<script>location.href='./admin_display.php';</script>";
	} else
	{
		echo "<script>alert('Your not administrator2.');</script>";
		echo "<script>location.href='../index.php';</script>";
	}
?>