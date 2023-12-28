<?php
	include 'config/database.php';
	session_start();
	$conn = mysqli_connect( $host, $user, $pw, $dbName);

	if(!isset($_SESSION['user_id']) OR !isset($_SESSION['user_name']) )
	{
		echo "<script>alert('Wrong Access.');</script>";
		echo "<script>location.href='index.php?page=opening';</script>";
	}

	$id=$_SESSION['user_id'];
	$title=$_POST['title'];
	$content=$_POST['content'];
	$pw=$_POST['password'];
	$pw=sha1($pw);
	$date=date('Y-n-j');
	$time=date('h:i:s');
	
	if(isset($_FILES['file']))
	{
		$filename=$_FILES['file']['name'];
		$uploadPath="./upload/".$filename;
	}
	
	if($title==''||$content==''||$pw=='')
	{
			echo "<script>alert('Please enter contents.')</script>";
			echo "<script>location.href='index.php?page=qna'</script>";
	}else
	{
		//exist file
		if(isset($_FILES['file']))
		{
			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("insert into Board(ID,Title,Content,Date,Time,File_name,PW) values(?,?,?,?,?,?,?)");
			$stmt->bind_param('sssssss', $id, $title, $content, $date, $time, $filename, $pw);
			
			//file upload
			move_uploaded_file($_FILES['file']['tmp_name'], $uploadPath);
		}else //non exsit file
		{
			$stmt=$conn->stmt_init();
			$stmt=$conn->prepare("insert into Board(ID,Title,Content,Date,Time,PW) values(?,?,?,?,?,?)");
			$stmt->bind_param('ssssss', $id, $title, $content, $date, $time, $pw);
		}
		
		if($stmt->execute()){
			$stmt->close();
			$conn->close();
			echo "<script>alert('Success write!');</script>";
			echo "<script>location.href='index.php?page=qna';</script>";
		}
	}
?>