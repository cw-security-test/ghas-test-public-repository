<?php
	session_start();
	require 'library/database_func.php';

	$insNum=$_POST['insNum'];
	$fromAcc=$_POST['fromAcc'];
	$accPW=$_POST['accPW'];
	$accPW=sha1($accPW);
	
	$insurance=getQuery1('select * from Insurances where Number=?', 'i', (int)$insNum);
	$name=$insurance['Name'];
	$price=$insurance['Price'];
	$period=$insurance['Period'];
	
	$chkAcc=getQuery2('select * from Accounts where Proprietor_ID=? and Account=?', 'ss', $_SESSION['user_id'], $fromAcc);

	if($chkAcc['Account'])
	{		
		if($chkAcc['Account_PW']==$accPW)
		{
			if((int)$chkAcc['Balance']>=(int)$price)
			{
				$chkSigned=getQuery1('select * from Members where ID=?', 's', $_SESSION['user_id']);
				
				if($chkSigned['Valid_Insurance']==null)
				{					
					setQuery2('update Members set Valid_Insurance=? where ID=?', 'ss', $insNum, $_SESSION['user_id']);
					$newAccBnc=(int)$chkAcc['Balance']-(int)$price; 
					
					setQuery3('update Accounts set Balance=? where Proprietor_ID=? and Account=?', 'sss', (string)$newAccBnc, $_SESSION['user_id'], $fromAcc);
					
					$contractDay=date("Y-m-d", time());
					$now=time();
					$cclExpireDay="+".$period." days";
					$expireDay=date("Y-m-d", strtotime($cclExpireDay, $now));
					setQuery4('insert into Current_Insurances values(?,?,?,?)','isss',$insNum,$_SESSION['user_id'],$contractDay,$expireDay);
					
					echo "<script>alert('Success insurance signup. Thank you.');</script>";
					echo "<script>location.href='index.php?page=mypage'</script>";
				}else
				{
					echo "<script>alert('Already exist insurance.');</script>";
					echo "<script>location.href='index.php?page=index'</script>";
				}
			}else
			{
				echo "<script>alert('Lack amount in your account.');</script>";
				echo "<script>location.href='index.php?page=deposit'</script>";
			}
		}else
		{
			echo "<script>alert('Wrong password.');</script>";
			echo "<script>location.href='index.php?page=insurance'</script>";
		}
	}else
	{
		echo "<script>alert('Occured error.');</script>";
		echo "<script>location.href='index.php?page=insurance'</script>";
	}
?>



		