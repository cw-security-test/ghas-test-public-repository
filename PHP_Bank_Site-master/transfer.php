<?php
	session_start();
    include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>location.href='index.php?page=inquery'</script>";
	}

	$fromAcc=$_POST['fromAcc'];
	$toAcc=$_POST['toAcc'];
	$amount=$_POST['amount'];
	$pw=$_POST['pw'];
	$pw=sha1($pw);

	if($fromAcc==$toAcc)
	{
		echo "<script>alert('Same accounts.');</script>";
		echo "<script>location.href='index.php?page=transfer'</script>";
	}else
	{
		//check pw
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare("Select * from Accounts where Proprietor_ID=? and Account=?");
		$stmt->bind_param('ss', $_SESSION['user_id'], $fromAcc);
		$stmt->execute();
		$result=$stmt->get_result();
		$data=$result->fetch_assoc();

		if($data['Account_PW']!=$pw)
		{	
			echo "<script>alert('Wrong password.');</script>";
			echo "<script>location.href='index.php?page=transfer'</script>";
		} else
		{
			//check balance
			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("Select Balance from Accounts where Proprietor_ID=? and Account=?");
			$stmt->bind_param('ss', $_SESSION['user_id'], $fromAcc);
			$stmt->execute();
			$result=$stmt->get_result();
			$data=$result->fetch_assoc();

			if((int)$data['Balance']<(int)$amount)
			{
				echo "<script>alert('Lack balance on your account.');</script>";
				echo "<script>location.href='index.php?page=deposit'</script>";
			}else
			{
				//get receiver balance
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Select Balance from Accounts where Account=?");
				$stmt->bind_param('s', $toAcc);
				$stmt->execute();
				$result=$stmt->get_result();
				$data=$result->fetch_assoc();
				$rcvBalance=$data['Balance'];

				//get sender balance
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Select Balance from Accounts where Account=?");
				$stmt->bind_param('s', $fromAcc);
				$stmt->execute();
				$result=$stmt->get_result();
				$data=$result->fetch_assoc();
				$sndBalance=$data['Balance'];

				//set receiver balance
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("update Accounts set Balance=? where Account=?");
				$newAmount=(string)((int)$rcvBalance+(int)$amount);
				$stmt->bind_param('ss', $newAmount, $toAcc);
				$stmt->execute();

				//set sender balance
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("update Accounts set Balance=? where Account=?");
				$newAmount=(string)((int)$sndBalance-(int)$amount);
				$stmt->bind_param('ss', $newAmount, $fromAcc);
				$stmt->execute();

				//log
				$date=date('Y-n-j');
				$time=date('h:i:s');
				$logWords="[LOG] Transfer ".$fromAcc." to ".$toAcc." for ".$amount;
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Insert into Log values(?,?,?,?)");
				$stmt->bind_param('ssss', $_SESSION['user_id'], $logWords, $date, $time);
				$stmt->execute();
				
				echo "<script>alert('Success transfer.');</script>";
				echo "<script>location.href='index.php?page=lookup'</script>";
			}			
		}
	}

?>



		