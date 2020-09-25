<?php
function check_admin()
{
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: ../login.php');
    } else {
        require 'database.php';
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM user WHERE user.username = ?");
        $statement->execute(array($_SESSION['username']));

        $acc = $statement->fetch();
        Database::disconnect();
        if ($acc["level"] != "1") {
            header('Location: 403.html');
        }
    }
}


?>