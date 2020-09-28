<?php include 'check_admin.php';
check_admin(); ?>
<!DOCTYPE html>
<html>

<head>
  <title>Restaurawwwr 🦸‍♂️</title>
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
      <h1><strong>List item </strong>
        <a href="insert.php" class="btn btn-success btn-lg"><span class="glyphicon glyphicon-plus"></span> Tambah</a>
        <a href="report.php" class="btn btn-warning btn-lg"><span class="glyphicon glyphicon-th-list"></span> Report</a>
        <a href="../index.php" class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span> Halaman Awal</a>

      </h1>
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Deskripsi</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php

          $db = Database::connect();
          $statement = $db->query('SELECT items.id, items.name, items.description, items.price, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id ORDER BY items.id DESC');
          while ($item = $statement->fetch()) {
            echo '<tr>';
            echo '<td>' . $item['name'] . '</td>';
            echo '<td>' . $item['description'] . '</td>';
            echo '<td>' . $item['price'], ' K' . '</td>';
            echo '<td>' . $item['category'] . '</td>';
            echo '<td width=300>';
            echo '<a class="btn btn-default" href="view.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-eye-open"></span> Lihat</a>';
            echo ' ';
            echo '<a class="btn btn-primary" href="update.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-pencil"></span> Edit</a>';
            echo ' ';
            echo '<a class="btn btn-danger" href="delete.php?id=' . $item['id'] . '"><span class="glyphicon glyphicon-trash"></span> Hapus</a>';
            echo '</td>';
            echo '</tr>';
          }
          Database::disconnect();
          ?>
        </tbody>
      </table>
    </div>
  </div>
</body>

</html>