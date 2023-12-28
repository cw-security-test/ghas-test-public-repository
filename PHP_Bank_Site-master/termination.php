<?php
	session_start();
    include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>location.href='index.php?page=inquery'</script>";
	}

	$accNum=$_POST['accNum'];
	$pw=$_POST['accPW'];
	$pw=sha1($pw);

	//check pw : error
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select * from Accounts where Proprietor_ID=? and Account=?");
	$stmt->bind_param('ss', $_SESSION['user_id'], $accNum);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();

	if($data['Account_PW']!=$pw)
	{	
		echo "<script>alert('Wrong password.');</script>";
		echo "<script>location.href='index.php?page=termination'</script>";
	} else
	{
		//check balance
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare("Select Balance from Accounts where Proprietor_ID=? and Account=?");
		$stmt->bind_param('ss', $_SESSION['user_id'], $accNum);
		$stmt->execute();
		$result=$stmt->get_result();
		$data=$result->fetch_assoc();
		
		if((int)($data['Balance'])>1)
		{
			echo "<script>alert('Exist balance in your account. Please empty.');</script>";
			echo "<script>location.href='index.php?page=deposit'</script>";
		}else
		{
			$acc1=0;
			$acc2=0;
			$acc3=0;

			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("Select * from Members where ID=?");
			$stmt->bind_param('s', $_SESSION['user_id']);
			$stmt->execute();
			$result=$stmt->get_result();
			$data=$result->fetch_assoc();
			
			if($data['Account1']==$accNum)
			{
				$acc1=1;
			} elseif($data['Account2']==$accNum)
			{
				$acc2=1;
			} elseif($data['Account3']==$accNum)
			{
				$acc3=1;
			} else
			{
				echo "<script>alert('Not exist account');</script>";
				echo "<script>window.history.back();</script>";
			}

			if($acc1==1)
			{
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Update Members set Account1='' where ID=?");
				$stmt->bind_param('s', $_SESSION['user_id']);
				$stmt->execute();
			}elseif($acc2==1)
			{
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Update Members set Account2='' where ID=?");
				$stmt->bind_param('s', $_SESSION['user_id']);
				$stmt->execute();
			}elseif($acc3==1)
			{
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("Update Members set Account3='' where ID=?");
				$stmt->bind_param('s', $_SESSION['user_id']);
				$stmt->execute();
			}

			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("Select * from Members where ID=?");
			$stmt->bind_param('s', $_SESSION['user_id']);
			$stmt->execute();
			$result=$stmt->get_result();
			$data=$result->fetch_assoc();

			$isset_account1=0;
			$isset_account2=0;
			$isset_account3=0;
			$account1=$data['Account1'];
			$account2=$data['Account2'];
			$account3=$data['Account3'];

			if($data['Account1']==null)
			{
				$isset_account1=1;
			}
			if($data['Account2']==null)
			{
				$isset_account2=1;
			}
			if($data['Account3']==null)
			{
				$isset_account3=1;
			}

			//if($isset_account1==1)
			//{

			//}

			//exist one account
			if($isset_account1+$isset_account2+$isset_account3==2){
				if($isset_account1==0){

				}elseif($isset_account2==0){
					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account1=? where ID=?");
					$stmt->bind_param('ss', $account2, $_SESSION['user_id']);
					$stmt->execute();

					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account2='' where ID=?");
					$stmt->bind_param('s', $_SESSION['user_id']);
					$stmt->execute();
				}elseif($isset_account3==0){
					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account1=? where ID=?");
					$stmt->bind_param('ss', $account3, $_SESSION['user_id']);
					$stmt->execute();

					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account3='' where ID=?");
					$stmt->bind_param('s', $_SESSION['user_id']);
					$stmt->execute();
				}
			}

			//exist two account
			if($isset_account1+$isset_account2+$isset_account3==1){
				if($isset_account3==1)
				{

				}elseif($isset_account2==1)
				{
					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account2=? where ID=?");
					$stmt->bind_param('ss', $account3, $_SESSION['user_id']);
					$stmt->execute();

					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account3='' where ID=?");
					$stmt->bind_param('s', $_SESSION['user_id']);
					$stmt->execute();
				}elseif($isset_account1==1)
				{
					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account1=? where ID=?");
					$stmt->bind_param('ss', $account2, $_SESSION['user_id']);
					$stmt->execute();

					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account2=? where ID=?");
					$stmt->bind_param('ss', $account3, $_SESSION['user_id']);
					$stmt->execute();

					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("Update Members set Account3='' where ID=?");
					$stmt->bind_param('s', $_SESSION['user_id']);
					$stmt->execute();
				}
				
				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("delete from Accounts where Proprietor_ID=? and Account=?");
				$stmt->bind_param('ss', $_SESSION['user_id'], $accNum);
				$stmt->execute();
				
			}
			
			//log
			$date=date('Y-n-j');
			$time=date('h:i:s');
			$logWords="[LOG] Termination Account ".$accNum." by ".$_SESSION['user_id'];
			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("Insert into Log values(?,?,?,?)");
			$stmt->bind_param('ssss', $_SESSION['user_id'], $logWords, $date, $time);
			$stmt->execute();
			
			echo "<script>alert('Success termination.');</script>";
			echo "<script>location.href='index.php?page=lookup'</script>";
		}			
	}
?>



		