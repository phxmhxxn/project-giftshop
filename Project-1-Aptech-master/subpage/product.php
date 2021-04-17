<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);
    $stmt->execute();
    // Fetch the product from the database and return the result as an Array
    $main_product = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($main_product) {
        $category_id = $main_product['categoryID'];
        $product_id = $main_product['productID'];
    }
    // Check if the product exists (array is not empty)
    if (!$main_product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
?>

<?php include 'navbar.php'; ?>

<div class="product content-wrapper d-flex" style="width: 80%; flex-wrap:wrap ">
    <div class="col-lg-6   col-12 ">
        <img src="imgs/<?= $main_product['img'] ?>" style="width: 100%;" alt="<?= $main_product['name'] ?>">
    </div>
    <div class="col-lg-6  col-12 px-4">
        <h1 class="name py-4"><?= $main_product['name'] ?></h1>
        <h6>Product code: <?= $main_product['productID'] ?></h6>
        <span class="price">
            &dollar;<?= $main_product['price'] ?>
            <?php if ($main_product['rrp'] > 0) : ?>
                <span class="rrp">&dollar;<?= $main_product['rrp'] ?></span>
            <?php endif; ?>
        </span>

        <span class="text-success" id="instock">In Stock: </span>
        <h7 id="stock"><?= $main_product['quantity'] ?></h7>
        <form action="index?page=cart" method="post"> <h4>quantity:</h4>
                <input type="number" style="width: 50%;" id="quantity" name="quantity" value="1" min="1" max="<?php if ($main_product['quantity'] < 20) {
                                                                                                                    echo $main_product['quantity'];
                                                                                                                } else {
                                                                                                                    echo 20;
                                                                                                                } ?>" placeholder="Quantity" required oninput="
                    if(this.checkValidity()) {$('#stock').css('color', 'black')}
                    else {$('#stock').css('color', 'coral')}
                    ">  
            <input type="hidden" name="product_id" value="<?= $main_product['productID'] ?>">
            <button class="btn-danger btn" type="submit" style="width: 50%;" value="Add To Cart" id="add">Add to cart</button>
        </form>
            <p><a href="download.php?file=<?= $main_product['file'] ?>">Download detailed informations of the product</a></p> 
            <?= $main_product['desci'] ?> 
    </div>
</div>

<script>
    if (<?= $main_product['quantity'] ?> <= 0) {
        $('#instock').toggleClass('change_me text-danger');
        $('#instock').html('Out Stock:');
        $("#quantity, #add").prop("disabled", true);
        $("#add").val("OUT STOCK");
    }
</script>


<?php
// The amounts of products to show on each page
$num_products_on_each_page = 8;
// The current page, in the URL this will appear as index.php?page=products&p=1, index.php?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt1 = $pdo->prepare('SELECT * FROM products WHERE categoryID = ? AND productID <> ? ORDER BY date_added DESC limit ?,?');
$stmt1->bindParam(1, $category_id, PDO::PARAM_STR);
$stmt1->bindParam(2, $product_id, PDO::PARAM_STR);
$stmt1->bindValue(3, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt1->bindValue(4, $num_products_on_each_page, PDO::PARAM_INT);

// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt1->execute();
// Fetch the products from the database and return the result as an Array  
$products = $stmt1->fetchAll(PDO::FETCH_ASSOC);

$stmt1 = $pdo->prepare('SELECT * FROM products WHERE categoryID = ? AND productID <> ? ORDER BY date_added DESC');
$stmt1->bindParam(1, $category_id, PDO::PARAM_STR);
$stmt1->bindParam(2, $product_id, PDO::PARAM_STR);
$stmt1->execute();
// Get the total number of products 
$total_products = $stmt1->rowCount();
?>
<div class="products content-wrapper" style="width: 80%;">
    <h1>Select a similar product to compare</h1>
    <p><?= $total_products ?> similar products</p>
    <div class="col-lg-12 col-xs-12 d-flex justify-content-start " style="flex-wrap: wrap;">
        <?php foreach ($products as $product) : ?>
            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 col-6 product-item justify-content-center products-wrapper" id="product<?= $product['productID'] ?>" style="text-align:center">

                <a style="width: 100%; padding: 6%" href="index?page=compare&id[]=<?= $main_product['productID'] ?>&id[]=<?= $product['productID'] ?>" class="product ">
                    <img src="imgs/<?= $product['img'] ?>" style="width: 100%; margin-bottom:10% " alt="<?= $product['name'] ?>">
                        <p class="name truncated" style="text-align: start;"><?= $product['name'] ?></p>
                    <span class="price " style="float:left; padding-bottom:20px; color:black; font-weight:900; ">
                        &dollar;<?= $product['price'] ?>
                        <?php if ($product['rrp'] > 0) : ?>
                            <span class="rrp" style="text-decoration: line-through !important; color:gray"> &dollar;<?= $product['rrp'] ?></span>
                        <?php endif; ?>
                    </span>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <div>

        <ul class="pagination justify-content-center">
            <!-- PREV BUTTON -->
            <li class="page-item"> <a class="page-link" id="pageprev" onclick="window.location='<?= $link ?>&pagenumber=<?= $current_page - 1 ?>'
    ">Prev</a> </li>

            <!-- PAGES NUMBER BUTTON -->
            <?php
            $i = $total_products;
            $total_pages = ($i / $num_products_on_each_page);
            $j = 1;
            while ($j <= $total_pages) {
                if ($j == $current_page) { ?>
                    <li class="page-item"><a class="page-link" style="color: red;"><?= $j ?></a></li>
                <?php } else {
                ?>
                    <li class="page-item"><a class="page-link" onclick="window.location='<?= $link ?>&pagenumber=<?= $j ?>'
            "><?= $j ?></a></li>
            <?php  }
                $j += 1;
            }  ?>
            <!-- NEXT BUTTON -->
            <li class="page-item"> <a class="page-link" id="pagenext" onclick="window.location='<?= $link ?>&pagenumber=<?= $current_page + 1 ?>">Next</a> </li>
        </ul>
        <!-- ----------- -->

        <input hidden type="submit" value="submit">
        </form>
        <script>
            // DISABLED CURRENT PAGE BUTTON
            if (<?= $current_page ?> < 2) {
                $('#pageprev').attr('onclick', '');
            }

            if (<?= $current_page ?> >= <?= $total_pages ?>) {
                $('#pagenext').attr('onclick', '');
            }
        </script>
    </div>
</div>