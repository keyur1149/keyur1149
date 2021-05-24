<?php

require_once "connect.php";
 

$name = $note = "";
$name_err = $note_err = "";
 

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }
    
    $input_note = trim($_POST["notes"]);
    if(empty($input_note)){
        $note_err = "Please enter a note.";
    } elseif(!filter_var($input_note, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid note.";
    } else{
        $note = $input_note;
    }
    
   
    if(empty($name_err) && empty($note_err) ){
        
        $sql = "INSERT INTO notes (name, notes) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            
            mysqli_stmt_bind_param($stmt, "ss", $param_name, $param_note);
            
            
            $param_name = $name;
            $param_note = $note;
           
            if(mysqli_stmt_execute($stmt)){
               
                header("location: index.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }
         
      
        mysqli_stmt_close($stmt);
    }
    
  
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Notes</title>
</head>
<body>
<h2>Create Note</h2>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
	
	<div <?php echo (!empty($name_err)); ?>">
		<label>Name</label>
		<input type="text" name="name" value="<?php echo $name; ?>">
		<span><?php echo $name_err;?></span>
	</div>
	<div <?php echo (!empty($note_err)); ?>">
		<label>Notes</label>
		<textarea name="notes" ><?php echo $note; ?></textarea>
		<span><?php echo $note_err;?></span>
	</div>
	<input type="submit" value="Submit">
	<a href="index.php">Cancel</a>
</form>
                
</body>
</html>