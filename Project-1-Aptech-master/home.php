<?php
// Get the 4 most recently added products
$stmt = $pdo->prepare('SELECT * FROM products  WHERE stt = 1 ORDER BY date_added DESC LIMIT 8');
$stmt->execute();
$recently_added_products = $stmt->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare('SELECT * FROM slideshow  WHERE stt = 1');
$stmt->execute();
$slideshows = $stmt->fetchAll(PDO::FETCH_ASSOC);

 
?>
   
<?php include 'navbar.php'; ?>

<?php if(!empty($slideshows)) { 
    $currentslide = 0; ?>
<div style="width:100%"> 
    <div class="slideShow col-slider col-12">
        
   <?php $i = 1; foreach ($slideshows as $image) {?>
        <div class="slideimg mySlides<?=$i?>">
            <img class="imgslide" src="./slideshow/<?=$image['img']?>">
        </div> 
        <?php $i = $i+1; } ?>
        <!-- Next and previous buttons -->
        <a class="prev " onclick="plusSlides(-1)">&#10094;</a>
        <a class="next " onclick="plusSlides(1)">&#10095;</a>
    </div> 
    <!-- The dots/circles -->
    <div style="text-align:center ; position:relative; top:-20px; ">
    
   <?php foreach ($slideshows as $image) {?>
        <span class="dot" onclick="currentSlide(<?=$currentslide = $currentslide+1?>)"></span> 
        <?php } ?>
    </div>
    </div> 
<?php } ?>
<div class="products content-wrapper text-center" style="width: 85%">
    <h2 class="Vegur mx-auto">New Products</h2>
    <div class="col-lg-12 col-xs-12 d-flex justify-content-start " style="flex-wrap: wrap;">
            <?php foreach ($recently_added_products as $product) : ?>
                <div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 col-6 product-item justify-content-center products-wrapper" id="product<?= $product['productID'] ?>" style="text-align:center">
               
                <a style="width: 100%; padding: 6%" href="index?page=product&id=<?= $product['productID'] ?>" class="product ">
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
        </div></div>
 