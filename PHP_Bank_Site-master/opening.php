<?php
	include 'config/database.php';
	session_start();

	if(!isset($_SESSION['user_id']) OR !isset($_SESSION['user_name']) )
	{
		echo "<script>alert('Wrong Access.');</script>";
		echo "<script>location.href='index.php?page=opening';</script>";
	}	

	$accNum=$_POST['accNum'];
	$accPW=$_POST['accPW'];
	$accPW=sha1($accPW);
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('MySQL Connect Fail');</script>";
	}

	//add to Accounts table
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("insert into Accounts values(?, ?, ?, ?, '0')");
	$stmt->bind_param('ssss', $accNum, $accPW, $_SESSION['user_id'], $_SESSION['user_name']);
	$stmt->execute();

	//add to Members table
	$chk_1=1;
	$chk_2=1;
	$chk_3=1;

	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select * from Members where ID=?");
	$stmt->bind_param('s', $_SESSION['user_id']);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();
	
	if($data['Account1']==null)
	{
		$chk_1=0;
	}
	if($data['Account2']==null)
	{
		$chk_2=0;
	}
	if($data['Account3']==null)
	{
		$chk_3=0;
	}

	if($chk_3==0)
	{
		if($chk_2==0)
		{
			if($chk_1==0)
			{
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("update Members set Account1=? where ID=?");
				$stmt->bind_param('ss', $accNum, $_SESSION['user_id']);
				$stmt->execute();
			} else 
			{
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("update Members set Account2=? where ID=?");
				$stmt->bind_param('ss', $accNum, $_SESSION['user_id']);
				$stmt->execute();
			}
			
		} else
		{
			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("update Members set Account3=? where ID=?");
			$stmt->bind_param('ss', $accNum, $_SESSION['user_id']);
			$stmt->execute();
		}
	}

	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select * from Members where ID=?");
	$stmt->bind_param('s', $_SESSION['user_id']);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();

	//log
	$date=date('Y-n-j');
	$time=date('h:i:s');
	$logWords="[LOG] Opening Account ".$accNum." by ".$_SESSION['user_id'];
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Insert into Log values(?,?,?,?)");
	$stmt->bind_param('ssss', $_SESSION['user_id'], $logWords, $date, $time);
	$stmt->execute();
				
	if($data['Name'])
	{
		echo "<script>alert('Success opening your account.');</script>";
		$stmt->close();
		$conn->close();
		echo "<script>location.href='index.php?page=lookup'</script>";
	}
?>