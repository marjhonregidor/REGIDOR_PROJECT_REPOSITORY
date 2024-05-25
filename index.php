<?php include('connection.php');

if(isset($_POST['but_submit'])){

    $uname = mysqli_real_escape_string($con,$_POST['User']);
    $password = mysqli_real_escape_string($con,$_POST['password']);


    if ($uname != "" && $password != ""){

        $sql_query = "select count(*) as cntUser from accounts where Username='".$uname."' and Password='".$password."'";
        $result = mysqli_query($con,$sql_query);
        $row = mysqli_fetch_array($result);

        $count = $row['cntUser'];

        if($count > 0){
            // $_SESSION['uname'] = $uname;
            header('Location: stocks-page.php');//mao ni tung stock na dashboard
        }else{echo '<script language = "javascript">';
            echo 'alert("Invalid user and password")';
            echo '</script>';
        }

    }

}


?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <title>CRUD Stocks Management</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');
        
        
    </style>

</head>
<body>
    <div class="container justify-content-center mainbody">
        <form method="post">
            <div class="form-group">
                <label for="User">User</label>
                <input type="text" class="form-control" id="User" placeholder="Enter_Username" name="User">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword" placeholder="Password" name="password">
            </div>
                <a href="Home.php" target="_self"> 
                    <button type="submit" class="btn btn-dark" name="but_submit" >Login</button>
                </a>     
            <a href="accRegister.php" target="_self">
                <button type="button" class="btn btn-primary" id="Sign_up" >Sign up</button>
            </a>
    </form>
        
    </div>
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>

    <script type="text/javascript">
        
    </script>
       
</html>