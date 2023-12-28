<?php
	session_start();
	if(!isset($_SESSION['user_id']) OR !isset($_SESSION['user_name']))
	{
		echo "<script>alert('Wrong access.');</script>";
		echo "<script>location.href='index.php?page=transfer'</script>";
	}

	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);	

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>location.href='index.php?page=inquery'</script>";
	}
	$toAcc=$_GET['toAcc'];
	$amount=$_GET['amount'];

	if(!$toAcc)
	{
		echo "<script>alert('Wrong input.');</script>";
		echo "<script>window.history.back();</script>";
	}
	
	//check sender name, account number
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select * From Members where Account1=? or Account2=? or Account3=?");
	$stmt->bind_param('sss', $toAcc, $toAcc, $toAcc);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();
	$name=$data['Name'];

	if($name)
	{
		echo "<script>location.href='index.php?page=transfer&name=".$name."&toAcc=".$toAcc."'</script>";
	} else
	{
		echo "<script>location.href='index.php?page=transfer&name=fail'</script>";
	}
	
	$stmt->close();
	$conn->close();
?>