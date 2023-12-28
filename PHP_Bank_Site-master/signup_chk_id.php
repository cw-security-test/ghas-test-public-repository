<?php
	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);	

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>location.href='index.php?page=inquery'</script>";
	}
	$id=$_GET['id'];
	$name=$_GET['name'];

	if(!$id)
	{
		echo "<script>alert('Wrong input.');</script>";
		echo "<script>window.history.back();</script>";
	}
	
	//check sender name, account number
	$stmt=$conn->stmt_init();
	$stmt=$conn->prepare("Select id From Members where id=?");
	$stmt->bind_param('s', $id);
	$stmt->execute();
	$result=$stmt->get_result();
	$data=$result->fetch_assoc();

	if(!$data['id'])
	{
		$stmt->close();
		$conn->close();
		echo "<script>location.href='index.php?page=signup&name=".$name."&id=".$id."&result=success'</script>";
	} else
	{
		$stmt->close();
		$conn->close();
		echo "<script>location.href='index.php?page=signup&name=".$name."&result=fail'</script>";
	}
?>