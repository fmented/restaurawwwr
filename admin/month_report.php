<?php include 'check_admin.php';
check_admin(); ?>
<?php


if (!empty($_GET['date'])) {
    $dt = checkInput($_GET['date']);
}
function checkInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$m = explode('-', $dt);

$x = "SELECT transaction.ref as ref, transaction.date as date, transaction.time as time, transaction.total as total,
transaction.cash as cash, transaction.cash_change as cc, user.name as cashier 
 FROM transaction INNER JOIN user on transaction.cashier = user.id where date BETWEEN '%s' AND '%s'";

$q = sprintf($x, $dt . "-01", $dt . "-31");
require './months.php';


function get_transaction($qr, $x)
{
    $str = '';
    $db = Database::connect();
    $statement = $db->query($qr);

    $str .= '<table class="table">
    <thead>
        <tr>
            <th>Code Transaksi</th>
            <th>Tanggal Transaksi</th>
            <th>Waktu Transaksi</th>
            <th>Total Belaja</th>
            <th>Cash Dibayarkan</th>
            <th>Kembalian</th>
            <th>Nama Kasir</th>
        </tr>
    </thead>
    <tbody>
    
    ';
    while ($item = $statement->fetch()) {
        $d = explode('-', $item['date']);
        $str .= ' <tr>
                    <td><a href="shop_history.php?ref=' . $item['ref'] . '">' . $item['ref'] . '</a></td>
                    <td><a href="date_report.php?date=' . $x . '-' . $d[2] . '">  ' . $d[2] . '</a></td>
                    <td>' . $item['time'] . '</td>
                    <td>' . $item['total'] . '</td>
                    <td>' . $item['cash'] . '</td>
                    <td>' . $item['cc'] . '</td>
                    <td>' . $item['cashier'] . '</td>
                </tr>
        ';
    }
    Database::disconnect();
    $str .= '</tbody>
    </table>
    ';
    return $str;
}


?>

<!DOCTYPE html>
<html>

<head>
    <title>Restaurawwwr 📜</title>
    <meta charset="utf-8" />
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
            <h1><strong><?php echo $months[$m[1]] . ' ' . $m[0]; ?> Reports</strong></h1>
            <br>
            <div class="table-responsive">
                <?php echo get_transaction($q, $dt); ?>
                <br>
            </div>
            <!-- <?php echo $q;
                    echo $_GET['date']; ?> -->
            <div class="form-actions">
                <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>