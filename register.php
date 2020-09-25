<?php session_start(); if(isset($_SESSION['username'])){header('Location: index.php');} ?>

<?php
     
    require 'database.php';
 
    $db = Database::connect();
    $statement = $db->query("SELECT username FROM user");
    $listuser = [];
    while($userlist = $statement->fetch()){
        array_push($listuser, $userlist['username']);
    }
    Database::disconnect();

    $nameError = $usernameError = $pwdError = $pwd2Error = $statusError = $name = $username = $pwd = $status = $pwd2 = "";

    if(!empty($_POST)) 
    {
        $name               = checkInput($_POST['name']);
        $username        = checkInput($_POST['username']);
        $pwd              = checkInput($_POST['pwd']);
        $pwd2              = checkInput($_POST['pwd2']);
        $status           = checkInput($_POST['status']); 
        $isSuccess          = true;

        
        if(empty($name)) 
        {
            $nameError = 'Field tidak boleh kosong';
            $isSuccess = false;
        }
        if(empty($username)) 
        {
            $usernameError = 'Field tidak boleh kosong';
            $isSuccess = false;
        } 
        if(in_array($username, $listuser)){
            $usernameError = 'Username sudah digunakan';
            $isSuccess = false;
        }
        if(empty($pwd)) 
        {
            $pwdError = 'Field tidak boleh kosong';
            $isSuccess = false;
        } 
        if(empty($pwd2)) 
        {
            $pwd2Error = 'Field tidak boleh kosong';
            $isSuccess = false;
        } 
        if(empty($status)) 
        {
            $statusError = 'Field tidak boleh kosong';
            $isSuccess = false;
        }
        if($pwd != $pwd2){
            $pwd2Error = 'Password tidak sesuai';
            $isSuccess = false;

        }
        if(strlen($pwd)<8){
            $pwdError = 'Password harus memiliki setidaknya 8 karakter';
            $isSuccess = false;
        }
        else{
            $str= $pwd;
            preg_match_all('!\d+!', $str, $match);
            $x=implode('',$match[0]);
            if(strlen($x)==0){
                $pwdError = 'Password harus memiliki kombinasi angka';
                $isSuccess = false;
            }
        }
        
        if($isSuccess) 
        {
            $db = Database::connect();
            $statement = $db->prepare("INSERT INTO user (name,username,password,level) values(?, ?, ?, ?)");
            $statement->execute(array($name,$username,md5($pwd),$status));
            Database::disconnect();
            header("Location: login.php");
        }
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Restaurawwwr</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="../css/styles.css">
    </head>
    
    <body>
    
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Restaurawwwr <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">
            <div class="row">
                <h1><strong> Register </strong></h1>
                <br>
                <form class="form" action="register.php" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nama:</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="<?php echo $name;?>">
                        <span class="help-inline"><?php echo $nameError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Username:</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username;?>">
                        <span class="help-inline"><?php echo $usernameError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Password:</label>
                        <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" value="<?php echo $pwd;?>">
                        <span class="help-inline"><?php echo $pwdError;?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Confirm Password:</label>
                        <input type="password" class="form-control" id="pwd2" name="pwd2" placeholder="Confirm Password" value="<?php echo $pwd2;?>">
                        <span class="help-inline"><?php echo $pwd2Error;?></span>
                    </div>
                    <div class="form-group">
                        <label for="category">Status:</label>
                        <select class="form-control" id="status" name="status">
                        <?php
                           $db = Database::connect();
                           foreach ($db->query('SELECT * FROM user_type') as $row) 
                           {
                                echo '<option value="'. $row['id'] .'">'. $row['type'] . '</option>';;
                           }
                           Database::disconnect();
                        ?>
                        </select>
                        <span class="help-inline"><?php echo $statusError;?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-pencil"></span> Register</button>
                        <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                   </div>
                   <br>
                   <a href="login.php">Sudah punya akun?</a>
                </form>
            </div>
        </div>   
    </body>
</html>