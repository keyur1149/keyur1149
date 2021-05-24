
<?php


if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

    require_once "connect.php";
    

    $sql = "DELETE FROM notes WHERE id= ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
       
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        $param_id = trim($_GET["id"]);
        
   
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            
            
        } else{
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
     
   
    mysqli_stmt_close($stmt);
    
    
    mysqli_close($link);
    
} else{
    
    header("location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>delete notes information</title>
</head>
<body>
<h2>Delete notes</h2>

<p>Are you sure you want to delete this notes?</p>
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="GET">
	
	
	<input type="submit" value="Yes">
	<a href="index.php">No</a>
</form>
                
</body>
</html>