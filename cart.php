<?php session_start();
require 'database.php';
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
} ?>




<!DOCTYPE html>
<html>

<head>
    <title>Restaurawwwr 🛒</title>
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
        <div class="form-actions">
            <a class="btn btn-primary" href="javascript:history.go(-1)"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
            <a class="btn btn-danger" href="empty.php"> Kosongkan Keranjang</a>

        </div>
        <h1><strong>Keranjang</strong></h1>
        <div class="row">
            <form method="post" action="process.php">
                <input type="hidden" name="cartlist" id="cartlist">

                <script defer>
                    var x = {}
                    var y = {}



                    function calc() {
                        let t = 0
                        Object.values(x).forEach(z => {
                            t += z[0] * z[1]
                        })
                        return t
                    }

                    function update() {
                        let n = ''
                        let txt
                        Object.entries(x).forEach(z => {
                            var [i, j] = z

                            n += i + ':' + j[0] + ','

                        })

                        if (n[n.length - 1] === ",") {
                            txt = n.slice(0, -1)
                        }
                        return txt
                    }

                    window.onload = () => {
                        cartlist.value = update()
                    }
                </script>



                <?php


                if (!empty($_SESSION['cash_error'])) {
                    $cashError = $_SESSION['cash_error'];
                } else {
                    $cashError = '';
                }

                if (!empty($_POST)) {

                    if (!empty($_POST['id']) && !empty($_POST['jumlah'])) {
                        if (!empty($_SESSION['cart'])) {

                            if (array_key_exists($_POST['id'], $_SESSION['cart'])) {
                                $_SESSION['cart'][$_POST['id']] += $_POST['jumlah'];
                            } else {
                                $_SESSION['cart'][$_POST['id']] = $_POST['jumlah'];
                            }
                        } else {
                            $_SESSION['cart'] = [];
                            $_SESSION['cart'][$_POST['id']] = $_POST['jumlah'];
                        }
                    }
                }


                if (!empty($_SESSION['cart'])) {
                    $total = 0;
                    foreach ($_SESSION['cart'] as $key => $value) {
                        $db = Database::connect();
                        $statement = $db->prepare("SELECT items.id, items.name, items.description, items.price, items.image, categories.name AS category FROM items LEFT JOIN categories ON items.category = categories.id WHERE items.id = ?");
                        $statement->execute(array($key));
                        $item = $statement->fetch();
                        Database::disconnect();
                        echo '
                    <div class="col-sm-6">
                    <br>
                   <div class="form-group">
                     <label>Nama:</label>' . $item['name'] . '
                     <input type="hidden" name="item' . $key . '">
                   </div>
                   <div class="form-group">
                     <label>Deskripsi:</label>' . $item['description'] . '
                     </div>
                   <div class="form-group">
                     <label>Jumlah: <b id="count' . $key . '">' . $value . '</b></label>
                     <input type="range" id="count-slider' . $key . '" min="1" max="30" value="' . $value . '" name="jumlah' . $key . '">
                   </div>
                   <div class="form-group">
                     <label>Harga: <b id="price' . $key . '">' . (int)$value * (int)$item['price'] . 'K</b></label>
                     <input type="hidden" id="priceform' . $key . '" name="harga' . $key . '">
                   </div>
                 
                 <br>
             </div> 
             <div class="col-sm-6 site">
                 <div class="thumbnail">
                     <img src="/images/' . $item['image'] . '" alt="...">
                 </div>
             </div>   
         <script>
         const disp' . $key . ' = document.getElementById("count' . $key . '")
         const slider' . $key . ' = document.getElementById("count-slider' . $key . '")
         const price' . $key . ' = document.getElementById("price' . $key . '")
         const prc' . $key . ' = ' . $item['price'] . ';
         const pf' . $key . '= document.getElementById("priceform' . $key . '")

        if(!window.hasOwnProperty("total")){
            let total = document.getElementById("total")
        }

        if(!window.hasOwnProperty("total_price")){
            let total_price = document.getElementById("total_price")
                }

        if(!window.hasOwnProperty("total_price")){
            let total_price = document.getElementById("cartlist")
                }



        

         


        x["' . $key . '"]=[Number(slider' . $key . '.value), Number(prc' . $key . ')]


         

    
         slider' . $key . '.addEventListener("change",()=>{
           disp' . $key . '.innerText=slider' . $key . '.value
           price' . $key . '.innerText = Number(slider' . $key . '.value)*Number(prc' . $key . ')+"K"
           pf' . $key . '.value = Number(slider' . $key . '.value)*Number(prc' . $key . ')
           x["' . $key . '"][0]=Number(slider' . $key . '.value)
           total.innerText=calc()
           total_price.value=calc()
           cartlist.value = update()
           })


    
         </script>
         ';
                        $total += (int)$value * (int)$item['price'];
                    }
                    $ux = '<div class="form-group">
    <label>Total: <b id="total">' . $total . '</b>K</label>
    <input type="hidden" name="total" id="total_price" value="' . $total . '">
    <br>
    <label>Cash</label>
    <input type="number" name="cash" id="cash"> <b> K</b><br>
    <span class="help-inline">' . $cashError . '</span>
    </div>
    <div class="caption site">
                <button class="btn btn-order" type="submit"><span class="glyphicon glyphicon-shopping-cart"></span> Order Sekarang </button>
    </div> 
    ';
                } else {
                    echo '<h1 class="text-center">Belum ada item</h1>';
                    $ux = '';
                }

                ?>
                <?php echo $ux;
                unset($_SESSION['cash_error']);
                ?>
            </form>
        </div>

    </div>



</body>

</html>