
<?php

	include 'config/database.php';
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!$conn){
		echo "<script>alert('DB Server Connect Fail');</script>";
		echo "<script>locastion.href='index.php'</script>";
	}

	$stmt=$conn->stmt_init();
	$query="select * from Chat_Display order by No ASC";
	$result=$conn->query($query);

	while($row=$result->fetch_assoc())
	{
		echo "[".$row['Date']." ".$row['Time']."] ".$row['ID']." : ".$row['Content'];
		echo "<br>";
	}
?>