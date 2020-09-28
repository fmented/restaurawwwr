<?php include 'check_admin.php'; check_admin();?>
<?php

    $ref = '';

    if(!empty($_GET['ref'])) 
    {
        $ref = checkInput($_GET['ref']);
    }

    function checkInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

    function getRefId($x)
    {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM transaction WHERE transaction.ref = ?");
        $statement->execute(array($x));
        $data = $statement->fetch();
        Database::disconnect();
        return $data['id'];
    }


    function get_details($data){
    $str='';
    $db = Database::connect();
    $statement = $db->query("SELECT items.name, items.id, cart.count FROM cart INNER JOIN items on cart.item = items.id WHERE cart.transaction = ".$data);
    // $statement->execute(array($data));
    $str.='<table class="table">
    <thead>
        <tr>
            <th>Nama Menu</th>
            <th>Jumlah</th>
        </tr>
    </thead>
    <tbody>
    
    ';
    while($item = $statement->fetch()){
        $str.=' <tr>
                    <td><a href="view.php?id='.$item['id'].'">'.$item['name'].'</a></td>
                    <td>'.$item['count'].'</td>
                </tr>
        ';

    }
    Database::disconnect();
    $str.='</tbody>
    </table>
    ';
    return $str;
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Restaurawwwr 📑</title>
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
                    <h1><strong>Order History</strong></h1>
                    <br>
                    <div class="table-responsive">
                    <?php echo get_details(getRefId($ref));?>
                    <br>
                    </div>
                    <div class="form-actions">
                      <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
            </div>
        </div>   
    </body>
</html>

