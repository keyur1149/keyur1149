<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
<?php

require_once "connect.php";


$sql = "SELECT * FROM notes";
if($result = mysqli_query($link, $sql)){
	if(mysqli_num_rows($result) > 0){
		echo "<table border='2'>";
			echo "<thead>";
				echo "<tr>";
					echo "<th>#</th>";
					echo "<th>Name</th>";
					echo "<th>Notes</th>";
                    echo "<th>what you do ?</th>";
				echo "</tr>";
			echo "</thead>";
			echo "<tbody>";
			while($row = mysqli_fetch_array($result)){
				echo "<tr>";
					echo "<td>" . $row['id'] . "</td>";
					echo "<td>" . $row['name'] . "</td>";
					echo "<td>" . $row['notes'] . "</td>";
					echo "<td>";
						echo "<a href='read.php?id=" . $row['id'] . "'>View Note</a>";
						echo "&nbsp;";
						echo "<a href='update.php?id=" . $row['id'] . "'>Update Note</a>";
						echo "&nbsp;";
						echo "<a href='delete.php?id=" . $row['id'] . "'>Delete Note</a>";
						echo "&nbsp;";
						echo "<a href='create.php'>Create Note</a>";
					echo "</td>";
				echo "</tr>";
			}
			echo "</tbody>";                            
		echo "</table>";
		
		mysqli_free_result($result);
	} else{
		echo "<p><em>No records were found.</em></p>";
	}
} else{
	echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
}


mysqli_close($link);
?>
</body>
</html>
