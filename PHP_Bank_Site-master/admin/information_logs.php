<HTML>
	<head>
		
	</head>
	<body>
		<table>
			<thead>
				<tr>
					<th scope="col" class="ID">ID</th>
					<th scope="col" class="Log">Log</th>
					<th scope="col" class="Date">Date</th>
					<th scope="col" class="Time">Time</th>
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
					$query="select * from Log order by Date DESC,Time DESC";
					$result=$conn->query($query);

					while($row=$result->fetch_assoc())
					{
				?>
				<tr>
					<td class="ID"><?php echo $row['ID']?></td>
					<td class="Log"><?php echo $row['Log']?></td>
					<td class="Date"><?php echo $row['date']?></td>
					<td class="Time"><?php echo $row['time']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</body>
</HTML>
