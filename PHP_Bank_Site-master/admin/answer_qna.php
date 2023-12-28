<HTML>
	<HEAD>
		<?php
			if($_SESSION['user_id']!='admin')
			{
				echo "<script>alert('Your not admin. Signin admin account.');</script>";
				echo "<script>location.href='admin.html'</script>";
			}
		?>
	</HEAD>
	<BODY>
		<form action="./answer_send.php" method="post">
		<fieldset>
			<legend>Board Form</legend>
				<?php
					include '../config/database.php';
					$conn = mysqli_connect( $host, $user, $pw, $dbName);

					if(!$conn){
						echo "<script>alert('DB Server Connect Fail');</script>";
						echo "<script>locastion.href='index.php?page=inquery'</script>";
					}
					
					$stmt=$conn->stmt_init();
					$stmt=$conn->prepare("select * from Board where No=?");
					$stmt->bind_param('s', $_GET['no']);
					$stmt->execute();
					$result=$stmt->get_result();
					while($data=$result->fetch_assoc())
					{
					
				?>
				<label class="title" for="no">No. </label>
				<?php echo "<input type='text' name='no' id='no' size='12' value='".$data['No']."' readonly>"; ?>
			
				<label class="title" for="title">Title : </label>
				<?php echo "<input type='text' name='title' id='title' size='12' value='".$data['Title']."' readonly>"; ?>
			
				<label class="title" for="author">Author : </label>
				<?php echo "<input type='text' name='author' id='author' size='12' value='".$data['ID']."' readonly>"; ?>
			
				<label class="title" for="content">Content : </label>
			 	<?php echo "<textarea cols='12' rows='10' name='content' id='content' readonly>".$data['Content']."</textarea>"; ?>	
			
				<label class="title" for="date">Date : </label>
				<?php echo "<input type='text' name='date' id='date' size='12' value='".$data['Date']." ".$data['Time']."' readonly>"; ?>
			
				<label class="title" for="file_name">File_name : </label>
				<?php $downpath="location.href='../file_download.php?filename=".$data['File_name']."'" ?>
				<?php echo "<input type='text' name='file' id='file' size='12' value='".$data['File_name']."' onClick=\"".$downpath."\" readonly>"; ?>
				<div class='downdesc'>click to Download file.</div>
				<br><br>
				<p><input type='button' class='b_button' value='Back' onClick="location.href='admin_display.php?page=qna'"></p>
				<?php } ?>
		</fieldset>
		<!--show already exists reply-->
		
			<?php
				include '../config/database.php';
				$conn = mysqli_connect( $host, $user, $pw, $dbName);

				if(!$conn){
					echo "<script>alert('DB Server Connect Fail');</script>";
					echo "<script>locastion.href='index.php?page=inquery'</script>";
				}

				$stmt=$conn->stmt_init();
				$stmt=$conn->prepare("select * from Board_Reply where No=? order by Date,Time ASC");
				$stmt->bind_param('s', $_GET['no']);
				$stmt->execute();
				$result=$stmt->get_result();
				$number=1;
				while($data=$result->fetch_assoc())
				{
					

			?>
					<fieldset>
						<label class="title" for="no_r">No. </label>
						<?php echo "<input type='text' name='no_r' id='no_r' size='12' value='".$data['No']."-".$number."' readonly>"; ?>

						<label class="title" for="author_r">Author : </label>
						<?php echo "<input type='text' name='author_r' id='author_r' size='12' value='Admin' readonly>"; ?>

						<label class="title" for="content_r">Content : </label>
						<?php echo "<textarea cols='12' rows='10' name='content_r' id='content_r' readonly>".$data['Content']."</textarea>"; ?>	

						<label class="title" for="date_r">Date : </label>
						<?php echo "<input type='text' name='date_r' id='date_r' size='12' value='".$data['Date']." ".$data['Time']."' readonly>"; ?>
					</fieldset><br>
					<?php $number+=1; ?>
				<?php } ?>
			
		<fieldset>
			<legend>Answer Form</legend>
				<label class="title" for="answer">Reply</label>
				<textarea cols='12' rows='10' name='answer' id='answer' ></textarea>	
				<br /><input class='b_button' type="submit" value="Answer">
			
		</fieldset>	
	</BODY>
</HTML>

