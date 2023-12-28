<?php
	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
	}

	$stmt=$conn->stmt_init();

	$name=$_POST['name'];
	$id=$_POST['id'];
	$alias=$_POST['alias'];
	$pw=$_POST['pw'];
	$pw=sha1($pw);
	$phone=$_POST['phone'];

	
	if($name==''||$id==''||$pw==''||$phone=='')
	{
		echo "<script>alert('Please enter your information.')</script>";
		echo "<script>location.href='index.php?page=signup'</script>";
	}else
	{
		if(isset($alias))
		{	
			$stmt=$conn->prepare("Insert into Members(Name, ID, Alias, PW, Phone_Number) values(?, ?, ?, ?, ?)");
			$stmt->bind_param('sssss', $name, $id, $alias, $pw, $phone);
		} else
		{
			$stmt=$conn->prepare("Insert into Members(Name, ID, PW, Phone_Number) values(?, ?, ?, ?)");
			$stmt->bind_param('ssss', $name, $id, $pw, $phone);
		}

		if($stmt->execute()){
			echo "<script>alert('Success sign up. Thank you!');</script>";
			echo "<script>location.href='index.php';</script>";
		}
		$stmt->close();
		$conn->close();
	}

?>
