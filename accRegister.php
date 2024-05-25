<?php include('connection.php');

if(isset($_POST['but_submit'])){

	$name = mysqli_real_escape_string($con,$_POST['txt_name']);
	$user = mysqli_real_escape_string($con,$_POST['txt_user']);
    $password = mysqli_real_escape_string($con,$_POST['txt_pwd']);
    $REpassword = mysqli_real_escape_string($con,$_POST['txt_re_pwd']);

   if($name != "" && $user != "" && $password != "" && $REpassword != ""){

        if($count == 0){
			$sql_ins = 'insert into accounts(`UserID`, `Name`, `UserName`, `Password`) values("","'.$name.'", "'.$user.'","'.$password.'")';
            	
    		$com = mysqli_query($con,$sql_ins);
    		echo '<script language = "javascript">';
                echo 'alert("Sign up successfully")';
                echo '</script>';

                header('Location: Index.php');
        }
        elseif ($count > 0 ) {
        	echo '<script language = "javascript">';
            echo 'alert("USER is in use.")';
            echo '</script>';
        }
           

        else{ 
            echo '<script language = "javascript">';
            echo 'alert("Invalid INPUT")';
            echo '</script>'; }

    }else{ 
            echo '<script language = "javascript">';
            echo 'alert("Re-type password is wrong")';
            echo '</script>';
       }
   }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <title>CRUD Stocks Management</title>
</head>
<body>
<div class="container justify-content-center">
        <div class="row">
            <div class="col-md-12">
                <h2>Sign up</h2>
            
                <form action="" method="post">
                
                    <div class="form-group">
                        
                        <label for="Name">Name</label>
                        <input type="text" class="form-control" id="Name" placeholder="Enter_Name" name="txt_name">

                        <label for="User">UserName</label>
                        <input type="text" class="form-control" id="User" placeholder="Enter_Username" name="txt_user">
                        
                        <label for="exampleInputPassword">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" name="txt_pwd">
                        
                        <label for="ReEntryPassword">Re-type Password</label>
                        <input type="password" class="form-control" id="ReEntryPassword" placeholder="Password" name="txt_re_pwd">
                    
                        <br>
                    </div>

                    <a href="confermation_files/SignCon.php" target="_self">
                        <button type="submit" name="but_submit" class="btn btn-dark btn-sm">Submit</button>
                    </a>

                </form>
            </div>
            
       </div>
    </div>    
</body>
</html>