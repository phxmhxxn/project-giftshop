<?php
// If the user clicked the add to cart button on the product page we can check for the form data
if (
    isset($_POST['product_id'], $_POST['quantity'])
    && ($_POST['product_id']) != '' && is_numeric($_POST['quantity'])
) {
    // Set the post variables so we easily identify them, also make sure they are integer
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    // Prepare the SQL statement, we basically are checking if the product exists in our database
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->bindParam(1, $product_id, PDO::PARAM_STR);
    $stmt->execute();
    // Fetch the product from the database and return the result as an Array
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Check if the product exists (array is not empty)
    if ($product && $quantity > 0) {
        // Product exists in database, now we can create/update the session variable for the cart
        if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            if (array_key_exists($product_id, $_SESSION['cart'])) {
                // Product exists in cart so just update the quanity
                $_SESSION['cart'][$product_id] += $quantity;
            } else {
                // Product is not in cart so add it
                $_SESSION['cart'][$product_id] = $quantity;
            }
        } else {
            // There are no products in cart, this will add the first product to cart
            $_SESSION['cart'] = array($product_id => $quantity);
        }
    }
    // Prevent form resubmission...
    header('location: index?page=cart');
    exit;
}

if (isset($_POST['update']) && isset($_SESSION['cart'])) {
    // Loop through the post data so we can update the quantities for every product in cart
    foreach ($_POST as $k => $v) {
        if (strpos($k, 'quantity') !== false && is_numeric($v)) {
            $id = str_replace('quantity-', '', $k);
            $quantity = (int)$v;
            // Always do checks and validation

            if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity >= 0) {
                // Update new quantity
                $_SESSION['cart'][$id] = $quantity;
            }
        }
    }
    // Prevent form resubmission...
    header('location: index?page=cart');
    exit;
}  
if (isset($_POST['invoice']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    header('Location: index?page=invoice');
    exit;
}

include("cartinfo.php");


include("navbar.php");
 
?>

<div class="mx-auto " style="width: 90%;">
<div class="cart col-lg-9 col-md-10 col-sm-11 col-12 mx-auto" >
    <h1 class="mx-auto">Shopping Cart</h1>
    <form action="index?page=cart" method="post"> 
        <table class="col-11" >
            <?php if (empty($products)) : ?>
                <tr>
                    <td colspan="5" style="text-align:center;">You have no products added in your Shopping Cart</td>
                </tr>
            <?php else : ?>
                <thead>
                    <tr>
                        <td class="col-1"></td>
                        <td colspan="2" class="col-5">Product</td>
                        <td>Price</td>
                        <td>Quantity</td>
                        <td>Total</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product) :
                    ?>
                        <tr>
                            <td><input class="btn btn-outline-danger btn-sm pr-1" type="submit" value="remove" name="remove<?= $product['productID'] ?>"> </td>
                            <td class="img">
                                <a href="index?page=product&id=<?= $product['productID'] ?>">
                                    <img src="imgs/<?= $product['img'] ?>" width="50" height="50" alt="<?= $product['name'] ?>">
                                </a>
                            </td>
                            <td>
                                <a class="wrap my-auto" style="white-space: normal !important; padding-left:10px " href="index?page=product&id=<?= $product['productID'] ?>"><?= $product['name'] ?></a>
                            </td>
                            <td class="price">&dollar;<?= $product['price'] ?></td>
                            <td class="quantity">
                                <input type="number" name="quantity-<?= $product['productID'] ?>" value="<?= $products_in_cart[$product['productID']] ?>" min="0" max="<?= $product['quantity'] ?>" placeholder="Quantity" required>
                            </td>
                            <td class="price">&dollar;<?= $product['price'] * $products_in_cart[$product['productID']] ?></td>

                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <span class="price">&dollar;<?= $subtotal ?></span>
        </div>
        <form action="index?page=cart" method="post">
            <div class="buttons">
                <input type="submit" value="Update" name="update">
                <input type="submit" value="Place Order" name="invoice">
            </div>
        </div>
        </form>
</div>