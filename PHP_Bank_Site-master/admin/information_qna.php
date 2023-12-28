<HTML>
	<head>
		<script>
			function answer(no)
			{
				window.location.href='admin_display.php?page=answer&no='+no;
			}
		</script>
	</head>
	<body>
		<div class='admin_table_qna'>
			<table>
				<thead>
					<tr>
						<th scope="col" class="No">No</th>
						<th scope="col" class="Title">Title</th>
						<th scope="col" class="ID">ID</th>
						<th scope="col" class="Date">Date</th>
						<th scope="col" class="Time">Time</th>
						<th scope="col" class="File">File</th>
						<th scope="col" class="Answer">Answer</th>
					</tr>	
				</thead>
				<tbody>
					<?php
						include '../config/database.php';
						$conn = mysqli_connect( $host, $user, $pw, $dbName);

						if(!$conn){
							echo "<script>alert('DB Server Connect Fail');</script>";
							echo "<script>locastion.href='index.php'</script>";
						}

						$stmt=$conn->stmt_init();
						$query="select * from Board order by No DESC";
						$result=$conn->query($query);

						while($row=$result->fetch_assoc())
						{
					?>
					<tr>
						<td class="No"><?php echo $row['No']?></td>
						<td class="Title"><?php echo $row['Title']?></td>
						<td class="ID"><?php echo $row['ID']?></td>
						<td class="Date"><?php echo $row['Date']?></td>
						<td class="Time"><?php echo $row['Time']?></td>
						<?php
							if(!empty($row['File_name']))
							{
								echo "<td class='File_Button'><input type='button' value='File Download'></td>";
							}else
							{
								echo "<td class='File_Button'></td>";
							}
						?>
						
						<?php
							$no=$row['No'];
							echo "<td class='Answer_Button'><input type='button' value='answer' onClick='answer(".$no.")'></td>";
						?>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</HTML>
