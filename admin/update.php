<?php include 'check_admin.php';
check_admin(); ?>
<?php

if (!empty($_GET['id'])) {
    $id = checkInput($_GET['id']);
}

$nameError = $descriptionError = $priceError = $categoryError = $imageError = $name = $description = $price = $category = $image = "";

if (!empty($_POST)) {
    $name               = checkInput($_POST['name']);
    $description        = checkInput($_POST['description']);
    $price              = checkInput($_POST['price']);
    $category           = checkInput($_POST['category']);
    $image              = checkInput($_FILES["image"]["name"]);
    $imagePath          = '../images/' . basename($image);
    $imageExtension     = pathinfo($imagePath, PATHINFO_EXTENSION);
    $isSuccess          = true;

    if (empty($name)) {
        $nameError = 'Field ini tidak boleh kosong';
        $isSuccess = false;
    }
    if (empty($description)) {
        $descriptionError = 'Field ini tidak boleh kosong';
        $isSuccess = false;
    }
    if (empty($price)) {
        $priceError = 'Field ini tidak boleh kosong';
        $isSuccess = false;
    }

    if (empty($category)) {
        $categoryError = 'Field ini tidak boleh kosong';
        $isSuccess = false;
    }
    if (empty($image)) {
        $isImageUpdated = false;
    } else {
        $isImageUpdated = true;
        $isUploadSuccess = true;
        if ($imageExtension != "jpg" && $imageExtension != "png" && $imageExtension != "jpeg") {
            $imageError = "File yang didukung: .jpg, .jpeg, .png";
            $isUploadSuccess = false;
        }
        if (file_exists($imagePath)) {
            $imageError = "File sudah ada";
            $isUploadSuccess = false;
        }
        if ($_FILES["image"]["size"] > 500000) {
            $imageError = "Ukuran maksimum 500KB";
            $isUploadSuccess = false;
        }
        if ($isUploadSuccess) {
            if (!move_uploaded_file($_FILES["image"]["tmp_name"], $imagePath)) {
                $imageError = "Gagal mengupload";
                $isUploadSuccess = false;
            }
        }
    }

    if (($isSuccess && $isImageUpdated && $isUploadSuccess) || ($isSuccess && !$isImageUpdated)) {
        $db = Database::connect();
        if ($isImageUpdated) {
            $statement = $db->prepare("UPDATE items  set name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?");
            $statement->execute(array($name, $description, $price, $category, $image, $id));
        } else {
            $statement = $db->prepare("UPDATE items  set name = ?, description = ?, price = ?, category = ? WHERE id = ?");
            $statement->execute(array($name, $description, $price, $category, $id));
        }
        Database::disconnect();
        header("Location: index.php");
    } else if ($isImageUpdated && !$isUploadSuccess) {
        $db = Database::connect();
        $statement = $db->prepare("SELECT * FROM items where id = ?");
        $statement->execute(array($id));
        $item = $statement->fetch();
        $image          = $item['image'];
        Database::disconnect();
    }
} else {
    $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM items where id = ?");
    $statement->execute(array($id));
    $item = $statement->fetch();
    $name           = $item['name'];
    $description    = $item['description'];
    $price          = $item['price'];
    $category       = $item['category'];
    $image          = $item['image'];
    Database::disconnect();
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
    <title>Restaurawwwr ✏</title>
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
                <h1><strong>Edit item</strong></h1>
                <br>
                <form class="form" action="<?php echo 'update.php?id=' . $id; ?>" role="form" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Nama:
                            <input type="text" class="form-control" id="name" name="name" placeholder="Nama" value="<?php echo $name; ?>">
                            <span class="help-inline"><?php echo $nameError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:
                            <input type="text" class="form-control" id="description" name="description" placeholder="Description" value="<?php echo $description; ?>">
                            <span class="help-inline"><?php echo $descriptionError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="price">Harga: (Rp)
                            <input type="number" step="1" class="form-control" id="price" name="price" placeholder="Harga" value="<?php echo $price; ?>">
                            <span class="help-inline"><?php echo $priceError; ?></span>
                    </div>


                    <div class="form-group">
                        <label for="category">Category:
                            <select class="form-control" id="category" name="category">
                                <?php
                                $db = Database::connect();
                                foreach ($db->query('SELECT * FROM categories') as $row) {
                                    if ($row['id'] == $category)
                                        echo '<option selected="selected" value="' . $row['id'] . '">' . $row['name'] . '</option>';
                                    else
                                        echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';;
                                }
                                Database::disconnect();
                                ?>
                            </select>
                            <span class="help-inline"><?php echo $categoryError; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="image">Image:</label>
                        <p><?php echo $image; ?></p>
                        <label for="image">Pilih Gambar:</label>
                        <input type="file" id="image" name="image" accept=".jpg,.jpeg,.png">
                        <span class="help-inline"><?php echo $imageError; ?></span>
                    </div>
                    <br>
                    <div class="form-actions">
                        <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>

                        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-floppy-disk"></span> Simpan</button>
                        <?php echo '
                                  <a class="btn btn-danger" href="delete.php?id=' . $id . '"><span class="glyphicon glyphicon-trash"></span> Hapus</a>                              
                                '
                        ?>
                    </div>
                </form>
            </div>
            <div class="col-sm-6 site">
                <div class="thumbnail">
                    <img src="<?php echo '../images/' . $image; ?>" alt="...">
                    <div class="price"><?php echo 'Rp ' . $price . ' k'; ?></div>
                    <div class="caption">
                        <h4><?php echo $name; ?></h4>
                        <p><?php echo $description; ?></p>
                        <?php echo '<a href="../order.php?id=' . $_GET['id'] . '" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Pesan </a>' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>