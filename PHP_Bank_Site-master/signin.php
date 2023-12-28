<?php
	include 'config/database.php';

	if(isset($_SESSION['user_id']) OR isset($_SESSION['user_name']) )
	{
		echo "<script>alert('Alerady signed in.');</script>";
		echo "<script>location.href='index.php';</script>";
	}

	$id=$_POST['id'];
	$chkPW=$_POST['pw'];
	$chkPW=sha1($chkPW);
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('MySQL Connect Fail');</script>";
	}

	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select ID, PW, Name From Members Where ID=?");
	$stmt->bind_param('s', $id);
	$stmt->execute();
	$result=$stmt->get_result();

	$data=$result->fetch_assoc();
	if($data['ID']!=$id)
	{
		echo "<script>alert('ID does not exist or Wrong password.');</script>";
		echo "<script>location.href='index.php?page=signin';</script>";
	} else if($data['PW']!=$chkPW)
	{
		echo "<script>alert('ID does not exist or Wrong password.');</script>";
		echo "<script>location.href='index.php?page=signin';</script>";
	} else
	{
		session_start();
		$_SESSION['user_id']=$data['ID'];
		$_SESSION['user_name']=$data['Name'];
		echo "<script>alert('Success sign in.');</script>";
		require 'signin_chk_insurance.php';
		chk_insurance($data['ID']);
		echo "<script>location.href='index.php';</script>";
	}

	$stmt->close();
	$conn->close();

?>