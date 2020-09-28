<?php session_start();
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} ?>
<!DOCTYPE html>
<html>

<head>
    <title>Restaurawwwr 🍽</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Holtwood+One+SC' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="css/styles.css">
    <style>
        .footer {
            left: 0;
            right: 0;
            height: 1.5em;
            top: 95%;
            width: 100%;
            background: rgba(0, 0, 0, 0.5);
            font-family: 'Holtwood One SC', sans-serif;
            color: orange;
            font-size: 14px;
            text-align: right;
            padding-right: 2rem;
            align-self: center;
        }

        .footer>p>a {
            color: #f53;
        }

        .footer>p>a:hover {
            color: #fed;
        }
    </style>
</head>


<body>
    <div class="container site">
        <h1 class="text-logo"><span class="glyphicon glyphicon-cutlery"></span> Restaurawwwr <span class="glyphicon glyphicon-cutlery"></span></h1>
        <?php
        require 'database.php';

        echo '<nav>
                        <ul class="nav nav-pills">';


        $db = Database::connect();
        $statement = $db->query('SELECT * FROM categories');
        $categories = $statement->fetchAll();
        foreach ($categories as $category) {
            if ($category['id'] == '1')
                echo '<li role="presentation" class="active"><a href="#' . $category['id'] . '" data-toggle="tab">' . $category['name'] . '</a></li>';
            else
                echo '<li role="presentation"><a href="#' . $category['id'] . '" data-toggle="tab">' . $category['name'] . '</a></li>';
        }

        echo    '                        <li role="presentation" style="position:absolute; right:10rem;">
                                <a href="cart.php"><span class="glyphicon glyphicon-shopping-cart" style="color:#e7480f"></span></a>
                                </li>
                </ul>
                      </nav>';

        echo '<div class="tab-content">';

        foreach ($categories as $category) {
            if ($category['id'] == '1')
                echo '<div class="tab-pane active" id="' . $category['id'] . '">';
            else
                echo '<div class="tab-pane" id="' . $category['id'] . '">';

            echo '<div class="row">';

            $statement = $db->prepare('SELECT * FROM items WHERE items.category = ?');
            $statement->execute(array($category['id']));
            while ($item = $statement->fetch()) {
                echo '<div class="col-sm-6 col-md-4">
                                <div class="thumbnail">
                                    <img src="images/' . $item['image'] . '" alt="...">
                                    <div class="price">' . 'Rp ' . $item['price'] . 'K</div>
                                    <div class="caption">
                                        <h4>' . $item['name'] . '</h4>
                                        <p>' . $item['description'] . '</p>
                                        <a href="order.php?id=' . $item['id'] . '" class="btn btn-order" role="button"><span class="glyphicon glyphicon-shopping-cart"></span> Pesan</a>
                                    </div>
                                </div>
                            </div>';
            }

            echo    '</div>
                        </div>';
        }
        Database::disconnect();
        echo  '</div>';

        function check_user()
        {
            $db = Database::connect();
            $statement = $db->prepare("SELECT * FROM user WHERE user.username = ?");
            $statement->execute(array($_SESSION['username']));

            $acc = $statement->fetch();
            Database::disconnect();
            if ($acc["level"] != "1") {
                return false;
            }
            return true;
        }

        $admin = check_user();
        ?>
    </div>

    <?php $db = Database::connect();
    $statement = $db->prepare("SELECT * FROM user WHERE user.username = ?");
    $statement->execute(array($_SESSION['username']));

    $acc = $statement->fetch();
    Database::disconnect();
    ?>
    <div class="footer">

        <p><?php echo $acc['name'] ?> <?php if ($admin) {
                                            echo '- <a href="admin/index.php"> Admin Page  </a> ';
                                        } ?> | [ <a href="logout.php">Logout</a> ] </p>
    </div>
</body>

</html>