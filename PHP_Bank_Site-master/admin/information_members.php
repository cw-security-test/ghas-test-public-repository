<HTML>
	<head>
		
	</head>
	<body>
		<div class="admin_table_member">
			<table>
				<thead>
					<tr>
						<th scope="col" class="Name">Name</th>
						<th scope="col" class="ID">ID</th>
						<th scope="col" class="Alias">Alias</th>
						<th scope="col" class="Phone_Number">Phone_Number</th>
						<th scope="col" class="Account1">Account1</th>
						<th scope="col" class="Account2">Account2</th>
						<th scope="col" class="Account3">Account3</th>
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
						$query="select * from Members";
						$result=$conn->query($query);

						while($row=$result->fetch_assoc())
						{
					?>
					<tr>
						<td class="Name"><?php echo $row['Name']?></td>
						<td class="ID"><?php echo $row['ID']?></td>
						<td class="Alias"><?php echo $row['Alias']?></td>
						<td class="Phone_Number"><?php echo $row['Phone_Number']?></td>
						<td class="Account1"><?php echo $row['Account1']?></td>
						<td class="Account2"><?php echo $row['Account2']?></td>
						<td class="Account3"><?php echo $row['Account3']?></td>
					</tr>
					<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</body>
</HTML>
