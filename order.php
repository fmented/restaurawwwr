<?php session_start();
if (!isset($_SESSION['username'])) {
  header('Location: login.php');
} ?>

<?php
require 'database.php';

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
  <title>Restaurawwwr 📇</title>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
  <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Restaurawwwr <span class="glyphicon glyphicon-cutlery"></span></h1>
  <div class="container admin">
    <div class="row">
      <div class="col-sm-6">
        <h1><strong>Order item</strong></h1>
        <br>
        <form method="post" action="cart.php">
          <div class="form-group">
            <label>Nama:</label><?php echo '  ' . $item['name']; ?>
            <input type="hidden" name="nama">
          </div>
          <div class="form-group">
            <label>Deskripsi:</label><?php echo '  ' . $item['description']; ?>
          </div>
          <div class="form-group">
            <label>Jumlah: <b id="count"></b></label>
            <input type="range" id="count-slider" min="1" max="30" value="1" name="jumlah">
          </div>
          <div class="form-group">
            <label>Harga: <b id="price"></b></label>
            <input type="hidden" id="priceform" name="harga">
          </div>

          <br>
          <div class="form-actions">
            <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
          </div>
      </div>
      <div class="col-sm-6 site">
        <div class="thumbnail">
          <img src="<?php echo '../images/' . $item['image']; ?>" alt="...">
        </div>
        <div class="caption">
          <button class="btn btn-order" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> Order Sekarang </button>
        </div>
      </div>
    </div>
    <?php echo '<input type="hidden" name="id" value="' . $item['id'] . '">'; ?>

    </form>
  </div>
  <script>
    const disp = document.getElementById('count')
    const slider = document.getElementById('count-slider')
    const price = document.getElementById('price')
    const prc = <?php echo $item['price']; ?>;
    const pf = document.getElementById('priceform')
    window.onload = () => {
      disp.innerText = slider.value
      price.innerText = Number(slider.value) * Number(prc) + "K"
      pf.value = Number(slider.value) * Number(prc)
    }
    slider.onchange = () => {
      disp.innerText = slider.value
      price.innerText = Number(slider.value) * Number(prc) + "K"
      pf.value = Number(slider.value) * Number(prc)
    }
  </script>
</body>

</html>