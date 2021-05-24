<?php

require_once "connect.php";
 

$name = $note  = "";
$name_err = $note_err = "";
 

if(isset($_POST["id"]) && !empty($_POST["id"])){
   
    $id = $_POST["id"];
    
    
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
        $note_err = "Please enter an address.";     
    } else{
        $note = $input_note;
    }
    
   
    
    if(empty($name_err) && empty($address_err) ){
     
        $sql = "UPDATE notes SET name=?, notes=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "ssi", $param_name, $param_note, $param_id);
            
           
            $param_name = $name;
            $param_note = $note;
            $param_id = $id;
            
            
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
} else{
    
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){

        $id =  trim($_GET["id"]);
        

        $sql = "SELECT * FROM notes WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
           
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            
            $param_id = $id;
            
           
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
    }  else{
  
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Notes</title>
</head>
<body>
   
	<div>
		<h2>Update Notes</h2>
	</div>
	<p>Please edit the input values and submit to update the notes.</p>
	<form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
		<div <?php echo (!empty($name_err)); ?>>
			<label>Name</label>
			<input type="text" name="name" value="<?php echo $name; ?>">
			<span><?php echo $name_err;?></span>
		</div>
		<div <?php echo (!empty($address_err)); ?>>
			<label>Notes</label>
			<textarea name="notes" ><?php echo $note; ?></textarea>
			<span><?php echo $note_err;?></span>
		</div>
	
		<input type="hidden" name="id" value="<?php echo $id; ?>"/>
		<input type="submit" value="update">
		<a href="index.php">Cancel</a>
	</form>
               
</body>
</html>