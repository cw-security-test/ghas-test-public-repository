<?php
	
	function connect()
	{
		include 'config/database.php';
		$conn = mysqli_connect($host, $user, $pw, $dbName);
		if(!$conn)
		{
			echo "<script>alert('DB Server Connect Fail');</script>";
			echo "<script>location.href='index.php'</script>";
		}
		return $conn;
	}

	function setQuery0($query)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->execute();
	}	

	function setQuery1($query, $paramFlag, $paramValue)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue);
		$stmt->execute();
	}
	
	function setQuery2($query, $paramFlag, $paramValue1, $paramValue2)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue1, $paramValue2);
		$stmt->execute();
	}

	function setQuery3($query, $paramFlag, $paramValue1, $paramValue2, $paramValue3)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue1, $paramValue2, $paramValue3);
		$stmt->execute();
	}

	function setQuery4($query, $paramFlag, $paramValue1, $paramValue2, $paramValue3, $paramValue4)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue1, $paramValue2, $paramValue3, $paramValue4);
		$stmt->execute();
	}

	function getQuery0($query)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->execute();
		$result=$stmt->get_result();
		$data=$result->fetch_assoc();
		return $data;
	}	

	function getQuery1($query, $paramFlag, $paramValue)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue);
		$stmt->execute();
		$result=$stmt->get_result();
		$data=$result->fetch_assoc();
		return $data;
	}
	
	function getQuery2($query, $paramFlag, $paramValue1, $paramValue2)
	{
		$conn=connect();
		$stmt=$conn->stmt_init();
		$stmt=$conn->prepare($query);
		$stmt->bind_param($paramFlag, $paramValue1, $paramValue2);
		$stmt->execute();
		$result=$stmt->get_result();
		$data=$result->fetch_assoc();
		return $data;
	}
?>