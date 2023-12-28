<?php
	session_start();
	$fromAcc=$_POST['fromAcc'];
	$amount=$_POST['amount'];

	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>location.href='index.php?page=inquery'</script>";
	}
	
	//get balance
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select Balance from Accounts where Account=?");
	$stmt->bind_param('s',$fromAcc);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();
	$resBalance=$data['Balance']+$amount;

	//set balance
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Update Accounts set Balance=? where Account=?");
	$stmt->bind_param('ss', $resBalance, $fromAcc);
	$stmt->execute();

	//log
	$date=date('Y-n-j');
	$time=date('h:i:s');
	$logWords="[LOG] Deposit to ".$fromAcc." for ".$amount;
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Insert into Log values(?,?,?,?)");
	$stmt->bind_param('ssss', $_SESSION['user_id'], $logWords, $date, $time);
	$stmt->execute();

	//go to lookup
	echo "<script>alert('Success deposit.')</script>";
	echo "<script>location.href='index.php?page=lookup'</script>";

	$stmt->close();
	$conn->close();
?>