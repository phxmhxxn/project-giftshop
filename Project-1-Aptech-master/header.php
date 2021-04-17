<?php $num_items_in_cart = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0; ?>
<?php
$products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$products_cart = array();
$subtotal = 0.00;
// If there are products in cart
if ($products_in_cart) {
    // There are products in the cart so we need to select those products from the database
    // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
    $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID IN (' . $array_to_question_marks . ')');
    // We only need the array keys, not the values, the keys are the id's of the products
    $stmt->execute(array_keys($products_in_cart));
    // Fetch the products from the database and return the result as an Array
    $products_cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
<link href='https://fonts.googleapis.com/css?family=Nunito' rel='stylesheet'>

<!-- jQueryUI -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GIFT SHOP</title>
    <link rel="icon" href="./imgs/icon.png">
    <link rel="stylesheet" href="./styleshop.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src='./scriptpage1.js'></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="./scriptpage.js"></script>
    <!-- <script async defer crossorigin="anonymous" src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v10.0" nonce="9nv1wW2o"></script> -->
</head>

<body class="Vegur row">
    <header class="bg-pink">
        <div class="content-wrapper bg-pink" style="width: 85%;height: fit-content;padding: 10px 0">
            <div class="link-icons">
                <a class="dropdown" href="index?page=cart">
                    <i class="dropdown fas fa-shopping-cart txt-color-black"></i>
                    <span style="top: -5px ;position: absolute; background-color:brown"><?= $num_items_in_cart ?></span>
                </a>
            </div>
        </div>
    </header>
    <main class="row">

        <!-- Logo - search bar - login UI -->
        <nav class="row navbar navbar-expand-lg navbar-dark lighten-1 d-flex justify-content-center secondary-color p-0" style="width: 100%">
            <div class=" navbar-nav clearfix" id="header" style="width: 85%">
                <div class="head-col-left col-lg-3 col-12 text-center">
                    <a href="./index"><img src="./imgs/logo11.png" class="m-2" alt="Logo" style="height: 100px !important; "></a>
                </div>
                <div class="justify-content-center text-center my-auto head-col-center col-lg-6">
                    <div class="py-2">
                        <form id="form" action="index?" method="get" class="m-0">
                            <input type="text" name="page" value="category" hidden>
                            <div class="searchbar mysearchbar m-auto">
                                <input class="search_input" type="search" name="searchinfo" placeholder="Search...">
                                <input type="submit" hidden>

                                <a href="#" onclick="$(`#form`).submit();" class="search_icon "><i class="fas fa-search" style="font-size:22px;"></i></a>







                            </div>
                    </div>
                    </form>
                </div>
                <div class="head-col-right col-lg-3 col-12 d-flex">
                    <div class="py-2 align-self-center w-100 text-center">

                        <?php if (isset($_SESSION['login1'])) : ?>
                            <a class="p-1 txt-color-black Vegur" style="font-size: 19px !important ">Welcome</a>
                            <a class="px-1 Vegur" style="font-size: 19px !important " href="index?page=user"> <?php
                                                                                                                if ($_SESSION['customerFname'] != '') {
                                                                                                                    echo $_SESSION['customerFname'];
                                                                                                                } else {
                                                                                                                    echo $_SESSION['login1'];
                                                                                                                } ?> |
                            </a>
                            <a class="Vegur" style="font-size: 19px !important " href="index?logout=1">Log out</a>
                        <?php else : ?>

                            <a class=" pl-3 txt-color-black Vegur" style="font-size: 19px !important " href="index?page=login">Login |</a>
                            <a class="p-1 txt-color-black Vegur" style="font-size: 19px !important " href="index?page=register">Register</a>
                        <?php endif ?>

                    </div>
                </div>
            </div>
        </nav>