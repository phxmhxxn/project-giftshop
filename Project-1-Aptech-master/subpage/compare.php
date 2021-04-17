<?php
// Check to make sure the id parameter is specified in the URL
if (isset($_GET['id'][0]) && isset($_GET['id'][1])) {
    // Prepare statement and execute, prevents SQL injection
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->execute([$_GET['id'][0]]);
    // Fetch the product from the database and return the result as an Array
    $main_product = $stmt->fetch(PDO::FETCH_ASSOC);
    $category_id = $main_product['categoryID'];
    $product_id = $main_product['productID'];
    $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
    $stmt->execute([$_GET['id'][1]]);
    // Fetch the product from the database and return the result as an Array
    $sub_product = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('select * from categories where categoryID = ' . $main_product['categoryID']);
    $stmt->execute();
    $cate = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('select * from categories where categoryID = ' . $sub_product['categoryID']);
    $stmt->execute();
    $cate1 = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('select mc.name from main_categories mc,products p,categories c where p.categoryID = c.categoryID AND c.maincategoryID=mc.maincategoryID AND p.categoryID=' . $main_product['categoryID']);
    $stmt->execute();
    $main_cate = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $pdo->prepare('select mc.name from main_categories mc,products p,categories c where p.categoryID = c.categoryID AND c.maincategoryID=mc.maincategoryID AND p.categoryID=' . $sub_product['categoryID']);
    $stmt->execute();
    $main_cate1 = $stmt->fetch(PDO::FETCH_ASSOC);
    // Check if the product exists (array is not empty)
    if (!$main_product || !$sub_product) {
        // Simple error to display if the id for the product doesn't exists (array is empty)
        exit('Product does not exist!');
    }
} else {
    // Simple error to display if the id wasn't specified
    exit('Product does not exist!');
}
$myfile = fopen("summary.txt", "w");
$txt = $main_product['desci'];
fwrite($myfile, $txt);
fclose($myfile);
?>

<?php include 'navbar.php'; ?>

<?php
$stmt = $pdo->prepare('select name from brands where brandID = ' . $main_product['brandID']);
$stmt->execute();
$brand = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt = $pdo->prepare('select name from brands where brandID = ' . $sub_product['brandID']);
$stmt->execute();
$brand1 = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<div class="product content-wrapper justify-content-center products1">
    <div class="col-12">
        <h1>Comparison table</h1>
        <br>
        <table class="table table-bordered text-center">
            <tr>
                <td class="text-center" style="width: 50%;"><a href="index?page=product&id=<?= $main_product['productID'] ?>">
                        <img src="imgs/<?= $main_product['img'] ?>" alt="<?= $main_product['name'] ?>" style="width: 90%;"></a>
                </td>
                <td class="text-center" style="width: 50%;"><a href="index?page=product&id=<?= $sub_product['productID'] ?>">
                        <img src="imgs/<?= $sub_product['img'] ?>" alt="<?= $sub_product['name'] ?>" style="width: 90%;"></a>
                </td>
            </tr>
            <tr>
                <td><a href="index?page=product&id=<?= $main_product['productID'] ?>"><?php echo $main_product['name'] ?></a></td>
                <td><a href="index?page=product&id=<?= $sub_product['productID'] ?>"><?php echo $sub_product['name'] ?></a></td>
            </tr>
            <tr>
                <td><?php echo $brand['name']; ?></td>
                <td><?php echo $brand1['name']; ?></td>
            </tr>
            <tr>
                <td>$<?php echo $main_product['price'] ?></td>
                <td>$<?php echo $sub_product['price'] ?></td>
            </tr>
            <tr>
                <td colspan="2">
                    <h4>Details</h4>
                </td>
            </tr>
            <tr>
                <td style="text-align: start;" class="p-4">
                    <h5><?php echo $main_product['desci'] ?></h5>
                </td>
                <td style="text-align: start;" class="p-4">
                    <h5><?php echo $sub_product['desci'] ?></h5>
                </td>
            </tr>
            <tr>
                <td>
                    <form action="index?page=cart" method="post">
                        <input hidden type="number" id="quantity" name="quantity" value="1">
                        <input type="hidden" name="product_id" value="<?= $main_product['productID'] ?>">
                        <button class="btn-danger btn mx-auto" type="submit" style="width: 50%;" value="Add To Cart" id="add">Add to cart</button>
                    </form>
                </td>
                <td>
                    <form action="index?page=cart" method="post">
                        <input hidden type="number" id="quantity" name="quantity" value="1">
                        <input type="hidden" name="product_id" value="<?= $sub_product['productID'] ?>">
                        <button class="btn-danger btn mx-auto" type="submit" style="width: 50%;" value="Add To Cart" id="add">Add to cart</button>
                    </form>
                </td>

            </tr>
        </table>
    </div>
</div>

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