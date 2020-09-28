<?php session_start();
if (isset($_SESSION['username'])) {
    header('Location: index.php');
} ?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurawwwr 👤</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <?php
    require 'database.php';

    $db = Database::connect();
    $statement = $db->query("SELECT username FROM user");
    $listuser = [];
    while ($userlist = $statement->fetch()) {
        array_push($listuser, $userlist['username']);
    }
    Database::disconnect();

    $usernameError = $pwdError = $username = $pwd = "";




    if (!empty($_POST)) {
        $username        = checkInput($_POST['username']);
        $pwd              = checkInput($_POST['pwd']);
        $pwdhash = md5($pwd);
        $isSuccess          = true;




        if (empty($username)) {
            $usernameError = 'Field tidak boleh kosong';
            $isSuccess = false;
        }
        if (!in_array($username, $listuser)) {
            $usernameError = 'Username tidak ditemukan';
            $isSuccess = false;
        }
        if (empty($pwd)) {
            $pwdError = 'Field tidak boleh kosong';
            $isSuccess = false;
        }


        if (getuser($username)['password'] != $pwdhash) {
            $usernameError = 'Username atau Password salah';
            $isSuccess = false;
        }

        if ($isSuccess) {

            $_SESSION['username'] = $username;
            header("Location: index.php");
        }
    }

    function checkInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function getuser($u)
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM user WHERE user.username = ?");
        $statement->execute(array($u));
        $acc = $statement->fetch();
        Database::disconnect();
        return $acc;
    }
    ?>



    <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Restaurawwwr <span class="glyphicon glyphicon-cutlery"></span></h1>
    <div class="container admin">
        <div class="row">
            <h1><strong> Login </strong></h1>
            <br>
            <form class="form" action="login.php" role="form" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="description">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Username" value="<?php echo $username; ?>">
                    <span class="help-inline"><?php echo $usernameError; ?></span>
                </div>
                <div class="form-group">
                    <label for="price">Password:</label>
                    <input type="password" class="form-control" id="pwd" name="pwd" placeholder="Password" value="<?php echo $pwd; ?>">
                    <span class="help-inline"><?php echo $pwdError; ?></span>
                </div>

                <br>
                <div class="form-actions">
                    <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-user"></span> Login</button>
                    <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                </div>
                <br>
                <a href="register.php">Tidak punya akun?</a>
            </form>
        </div>
    </div>
</body>

</html>