<?php session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} ?>

<?php
// unset($_SESSION['cart']);
require 'database.php';
$cart = $_POST['cartlist'];

$list = explode(',', $cart);

$succes = true;

function createref()
{
    $bytes = random_bytes(8);
    return bin2hex($bytes);
}

function getCashierId()
{
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM user WHERE user.username = ?");
    $statement->execute(array($_SESSION['username']));
    $data = $statement->fetch();
    Database::disconnect();
    return $data['id'];
}

if (empty($_POST['cash'])) {
    $succes = false;
    $_SESSION['cash_error'] = 'Field ini wajib di isi';
    header('Location: cart.php');
}

$ff = $_POST['cash'] - $_POST['total'];

if ($ff < 0) {
    $succes = false;
    $_SESSION['cash_error'] = 'Cash kurang dari total belanja';
    header('Location: cart.php');
}

if ($succes) {
    $_SESSION['trans_ref'] = createref();
    $cashier = getCashierId();
    $cash = (int)$_POST['cash'];
    $total = (int)$_POST['total'];
    $change = $cash - $total;

    $db = Database::connect();
    $statement = $db->prepare("INSERT INTO transaction (id,date,cashier,total,cash,cash_change,ref) values(NULL, current_timestamp(), ?, ?,?,?,?)");
    $statement->execute(array($cashier, $total, $cash, $change, $_SESSION['trans_ref']));
    Database::disconnect();

    $refId = getRefId();

    foreach ($list as $key => $value) {
        $item = explode(':', $value);
        $db = Database::connect();
        $statement = $db->prepare("INSERT INTO cart (id,item,count,transaction) values(NULL,?,?,?)");
        $statement->execute(array($item[0], $item[1], $refId));
        Database::disconnect();
    }

    unset($_SESSION['cart']);
    header('Location: review.php');
}




function getRefId()
{
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM transaction WHERE transaction.ref = ?");
    $statement->execute(array($_SESSION['trans_ref']));
    $data = $statement->fetch();
    Database::disconnect();
    return $data['id'];
}



?>