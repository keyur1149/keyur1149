<?php
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    
    require_once "connect.php";
    
   
    $sql = "SELECT * FROM notes WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        
        $param_id = trim($_GET["id"]);
        
      
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
              
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                
                $name = $row["name"];
                $note = $row["notes"];
            } else{
                
                header("location: error.php");
                exit();
            }
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
   
    mysqli_stmt_close($stmt);
    
    
    mysqli_close($link);
} else{
    
    header("location: error.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>View Notes</title>
<body>
    
	<div>
		<h1>&nbsp;View Note</h1>
	</div>
	<div>
		&nbsp;
		<label>Name</label>
		<p>&nbsp;&nbsp;<?php echo $row["name"]; ?></p>
	</div>
	<div>
		&nbsp;
		<label>Notes</label>
		<p>&nbsp;&nbsp;<?php echo $row["notes"]; ?></p>
	</div>
	
	<p>&nbsp;&nbsp;<a href="index.php">Back</a></p>
                
</body>
</html>