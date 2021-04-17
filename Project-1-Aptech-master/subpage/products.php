<?php
// The amounts of products to show on each page
$num_products_on_each_page = 8;
// The current page, in the URL this will appear as index?page=products&p=1, index?page=products&p=2, etc...
$current_page = isset($_GET['p']) && is_numeric($_GET['p']) ? (int)$_GET['p'] : 1;
// Select products ordered by the date added
$stmt = $pdo->prepare('SELECT * FROM products WHERE stt = 1  ORDER BY date_added DESC LIMIT ?,?');
// bindValue will allow us to use integer in the SQL statement, we need to use for LIMIT
$stmt->bindValue(1, ($current_page - 1) * $num_products_on_each_page, PDO::PARAM_INT);
$stmt->bindValue(2, $num_products_on_each_page, PDO::PARAM_INT);
$stmt->execute();
// Fetch the products from the database and return the result as an Array  
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
// Get the total number of products
$total_products = $pdo->query('SELECT * FROM products WHERE stt = 1')->rowCount();
?> 

<?php include 'navbar.php'; ?>
<div class="products content-wrapper ">
    <h1>Products</h1>
    <p><?= $total_products ?> Products</p>

    <?php include 'itemlist.php'; ?>

    <ul class="pagination justify-content-center">
        <li class="page-item"> <a class="page-link" id="pageprev" onclick="window.location='index?page=products&p=<?= $current_page - 1 ?>'">Prev</a></li>
        <?php
        $total_pages = ($total_products / $num_products_on_each_page) + 1;
        $i = 1;
        while ($i <= $total_pages) {
            if ($i == $current_page) { ?>
                <li class="page-item"><a class="page-link" style="color: red;"><?= $i ?></a></li>
            <?php } else {
            ?>
                <li class="page-item"><a class="page-link" onclick="window.location='index?page=products&p=<?= $i ?>'"><?= $i ?></a></li>
        <?php  }
            $i += 1;
        }  ?>
        <li class="page-item"> <a class="page-link" id="pagenext" onclick="window.location='index?page=products&p=<?= $current_page + 1 ?>'">Next</a></li>
    </ul>
</div>
 
<script>
    if (<?= $i ?> == <?= $current_page ?>) {

    }
    if (<?= $current_page ?> < 2) {
        $('#pageprev').attr('onclick', '');
    }
    if (<?= $total_products ?> <= (<?= $current_page ?> * <?= $num_products_on_each_page ?>) - <?= $num_products_on_each_page ?> + <?= count($products) ?>) {
        $('#pagenext').attr('onclick', '');
    }
</script>