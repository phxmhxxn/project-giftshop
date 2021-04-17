<?php
// The amounts of products to show on each page
$num_products_on_each_page = 4;
// The current page, in the URL this will appear as index?page=products&p=1, index?page=products&p=2, etc...
$current_page = isset($_GET['pagenumber']) && is_numeric($_GET['pagenumber']) ? (int)$_GET['pagenumber'] : 1;

// Check to make sure the id parameter is specified in the URL
$min = isset($_GET['minprice']) ? $_GET['minprice'] : 0;
$max = isset($_GET['maxprice']) ? $_GET['maxprice'] : 100000;
$brandget1 = isset($_GET['brand']) ? str_replace("%20", " ", $_GET['brand']) : '';
$brandget = str_replace("%", " ", $brandget1) ;
$maincategoryget1 = isset($_GET['maincategory']) ? str_replace("%20", " ", $_GET['maincategory']) : '';
$maincategoryget = str_replace("%", " ", $maincategoryget1) ;
$categoryget1 = isset($_GET['category']) ? str_replace("%20", " ", $_GET['category']) : '';
$categoryget = str_replace("%", " ", $categoryget1) ;
$searchget1 = isset($_GET['searchinfo']) ? str_replace("%20", " ", $_GET['searchinfo']) : '';
$searchget = str_replace("%", " ", $searchget1); 

$brandget1 = ($brandget == '') ? "%$brandget%" : $brandget; 
$categoryget1 = ($categoryget == '') ? "%$categoryget%" : $categoryget; 
$maincategoryget1 = ($maincategoryget == '') ? "%$maincategoryget%" : $maincategoryget; 

if (isset($_GET['searchinfo'])) {

    $search = "%$searchget%"; 
    $stmt = $pdo->prepare('SELECT * FROM search WHERE (`name` LIKE ? OR categoryNAME LIKE ? OR maincategoryNAME LIKE ? OR brandNAME LIKE ? ) AND stt = 1 ORDER BY `name`');
    $stmt->bindValue(1, $search, PDO::PARAM_STR);
    $stmt->bindValue(2, $search, PDO::PARAM_STR);
    $stmt->bindValue(3, $search, PDO::PARAM_STR);
    $stmt->bindValue(4, $search, PDO::PARAM_STR);  
    $stmt->execute();
    $products1 = $stmt->fetchall(PDO::FETCH_ASSOC);  
    $total_products = $stmt->rowCount();
    $products = $products1;
  
    // $search_products is array help for search list if "search info" isset 
    // $i is amount of total products
} else {
    
        $stmt = $pdo->prepare('SELECT * FROM search WHERE categoryNAME LIKE ? AND maincategoryNAME LIKE ? AND stt = 1 ORDER BY `name`');
        $total_products_stmt  = $pdo->prepare('SELECT * FROM search WHERE categoryNAME LIKE ? AND maincategoryNAME LIKE ? AND stt = 1 ORDER BY `name` ');
    
    
    $stmt->bindValue(1, $categoryget1, PDO::PARAM_STR);
    $stmt->bindValue(2, $maincategoryget1, PDO::PARAM_STR);  
    $stmt->execute();
    $products1 = $stmt->fetchall(PDO::FETCH_ASSOC);
    $total_products = $stmt->rowCount();
    // $search_products is array help for search list if "search info" isset 
    // $i is amount of total products 
    $products = $products1;
} 
if ($brandget != '') { 

    foreach ($products as $key=>$product) { 
        if ($product['brandNAME'] != $brandget) {
            unset($products[$key]);
        }
    } 
    $products = array_values($products);
    $total_products = count($products);
} 

$i = $total_products;

?>

<?php include 'navbar.php'; ?>
<div class="products products1 content-wrapper text-center">
    <!-- SHOW WHERE CATEGORY YOU IN -->
    <?php
    if (isset($_GET['category']) && $_GET['category'] != 0 && $_GET['category'] != NULL) {
        $stmt = $pdo->prepare('SELECT * FROM categories WHERE `name` = "' . $categoryget . '" ');
        $stmt->execute();
        // Fetch the product from the database and return the result as an Array
        $categories = $stmt->fetchall(PDO::FETCH_ASSOC);
        foreach ($categories  as $category) :
            $main_catogery_id = $category['maincategoryID']; 
            $stmt = $pdo->prepare('SELECT * FROM main_categories WHERE `maincategoryID` = ' . $main_catogery_id);
            $stmt->execute();
            // Fetch the product from the database and return the result as an Array
            $main_categories = $stmt->fetchall(PDO::FETCH_ASSOC);
            foreach ($main_categories  as $main_category) :
                $main_catogery_name = $main_category['name'];
            endforeach;
        endforeach;
        $main_catogery_temp = isset($main_catogery_name) ? $main_catogery_name : "" ;

        echo ' <div class="d-inline-block pt-3"><a href="/index?page=category&brand=' . $brandget . '&maincategory=' .$main_catogery_temp . '" class=" Vegur txt-color-dark-pink" style="font-weight: 300!important;">' . $main_catogery_temp . '</a><span class="Vegur txt-color-dark-pink" style="font-weight: 700!important;"> &#8669 ' . $_GET['category'] . '</span></div>';
    }
    $categoryname = isset($_GET['category']) ? $_GET['category'] : '';
    if (isset($_GET['maincategory']) && $_GET['maincategory'] != 0 && $_GET['maincategory'] != NULL && $categoryname == '') {
        echo ' <p class="Vegur txt-color-dark-pink mt-3"  style="font-weight: 700!important;">' . $maincategoryget . '</p>';
    }
    ?>
    <hr class="bg-pink">

    <?php include 'itemlist.php'; ?>

    <?php $searchinfo = isset($_GET['searchinfo']) ? $_GET['searchinfo'] : "" ?>

</div>
<!-- PAGE BUTTONS -->
<?php


$currrentlink = explode('&pagenumber', strval($_SERVER['REQUEST_URI']));
$link = $currrentlink[0];
$searchinfo = isset($_GET['searchinfo']) ? $_GET['searchinfo'] : 0;
$brand = isset($_GET['brand']) ? $_GET['brand'] : 0;
?>

<input hidden id="minprice" name="minprice" class="rail-label min" style="width: 15%;" value="<?= $min ?>">
<input hidden id="maxprice" name="maxprice" class="rail-label max" style="width: 15%;" value="<?= $max ?>">

<ul class="pagination justify-content-center">
    <!-- PREV BUTTON -->
    <li class="page-item"> <a class="page-link" id="pageprev" onclick="window.location='<?= $link ?>&pagenumber=<?= $current_page - 1 ?>'
    ">Prev</a> </li>

    <!-- PAGES NUMBER BUTTON -->
    <?php
    $total_pages = ($i / $num_products_on_each_page)+1;
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