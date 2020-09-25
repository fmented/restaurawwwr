<?php session_start(); if(!isset($_SESSION['username'])){header('Location: login.php');} ?>


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
        <link rel="stylesheet" href="/css/styles.css">
        <style>
          .text-review
{
    font-family: 'Holtwood One SC', sans-serif;
    color: #e7480f;
    text-shadow: 2px 2px #ffd301;
    font-size: 2em;
    padding: 0;
    text-align: center;
}

        </style>
    </head>
    
    <body>
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Restaurawwwr <span class="glyphicon glyphicon-cutlery"></span></h1>
         <div class="container admin">

         <h1 class="text-center"><strong>Review Order</strong></h1>
         
            <div class="row">

            <div class="col-sm-6">
            
            <h1 class="text-logo" style="font-size:15rem;"><span class="glyphicon glyphicon-shopping-cart"></span></h1>
            <h3 class="text-center"><strong>Transaksi Berhasil</strong></h3>
            </div>


                <div class="col-sm-6">
                    <br>
                    <br>
                    <br>
                    <div class="table-responsive">
                    <table class="table  table-stripped">
                    <thead>
                    <tr>
                    <th>Nama Menu</th>
                    <th>Jumlah Pesanan</th>
                    <th>Harga</th>
                    <tr>
                    </thead>
                    </tbody>

                    <?php
                        require 'database.php';

                        $ref = $_SESSION['trans_ref'];
                        
                        $db = Database::connect();
                        $statement = $db->prepare("SELECT items.name as name, items.price as price, cart.count as count, transaction.ref as ref,
                                                    transaction.total as total, transaction.cash as cash, transaction.cash_change as cchange, user.name as cashier FROM cart INNER JOIN items on cart.item = items.id INNER JOIN transaction on cart.transaction = transaction.id INNER JOIN user on transaction.cashier = user.id where transaction.ref = ?");
                        $statement->execute(array($ref));
                        while($item = $statement->fetch()){
                            echo "<tr>";
                            echo "<td>".$item['name']."</td>";
                            echo "<td>".$item['count']."</td>";
                            echo "<td>".(int)$item['count']*(int)$item['price']."</td>";
                            echo "</tr>";
                            $total = $item['total'];
                            $cashier = $item['cashier'];
                            $cash = $item['cash'];
                            $change = $item['cchange'];

                            
                        }
                        Database::disconnect();

                    ?>
                    <tr style="height:4rem;"></tr>
                    <tr>
                    <td><b>Total</b></td>
                    <td></td>
                    <td><b><?php echo $total; ?></b></td>
                    </tr>
                    <tr>
                    <td><b>Cash</b></td>
                    <td></td>
                    <td><b><?php echo $cash; ?></b></td>
                    </tr>
                    <tr>
                    <td><b>Kembali</b></td>
                    <td></td>
                    <td><b><?php echo $change; ?></b></td>
                    </tr>
                    </tbody>
                    </table>
                    <br>
                    <table class="table">
                    <thead>
                    <tr>
                    <th>Cashier</th>
                    <th>:</th>
                    <th><?php echo $cashier; ?> </th>
                    </tr>
                    <tr>
                    <th>Kode Transaksi</th>
                    <th>:</th>
                    <th><?php echo $ref; ?> </th>
                    </tr>
                    </thead>
                    </table>
                            <a href="index.php" class="btn btn-order" role="button"> Selesai </a>
                    </div>

                </div>
            </div>
            <div class="form-actions">
                      <a class="btn btn-primary" href="index.php"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            </div>
        </div>   
    </body>
</html>
<?php unset($_SESSION['trans_ref'])?>

