<?php include 'check_admin.php';
check_admin(); ?>
<?php


if (!empty($_GET['id'])) {
  $id = checkInput($_GET['id']);
}

$db = Database::connect();
$statement = $db->prepare("SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");
$statement->execute(array($id));
$item = $statement->fetch();
Database::disconnect();

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
  <title>Restaurawwwr 👁</title>
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
      <div class="col-sm-6">
        <h1><strong>Lihat item</strong></h1>
        <br>
        <form>
          <div class="form-group">
            <label>Nama:</label><?php echo '  ' . $item['name']; ?>
          </div>
          <div class="form-group">
            <label>Deskripsi:</label><?php echo '  ' . $item['description']; ?>
          </div>
          <div class="form-group">
            <label>Harga:</label><?php echo '  ' . $item['price'], 'K' . ' Rupiah'; ?>
          </div>
          <div class="form-group">
            <label>Kategori:</label><?php echo '  ' . $item['category']; ?>
          </div>
          <div class="form-group">
            <label>Gambar:</label><?php echo '  ' . $item['image']; ?>
          </div>
        </form>
        <br>
        <div class="form-actions">
          <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
          <?php echo '
                                  <a class="btn btn-success" href="update.php?id=' . $id . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>
                                  <a class="btn btn-danger" href="delete.php?id=' . $id . '"><span class="glyphicon glyphicon-trash"></span> Hapus</a>                         
                                '
          ?>
        </div>

      </div>
      <div class="col-sm-6 site">
        <div class="thumbnail">
          <img src="<?php echo '../images/' . $item['image']; ?>" alt="...">
          <div class="price"><?php echo "Rp " . $item['price'], 'k'; ?></div>
          <div class="caption">
            <h4><?php echo $item['name']; ?></h4>
            <p><?php echo $item['description']; ?></p>
            <?php echo '<a href="../order.php?id=' . $_GET['id'] . '" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Pesan </a>' ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>