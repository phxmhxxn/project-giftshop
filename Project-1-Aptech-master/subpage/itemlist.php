<div class="row listitem">
    <div class="col-xl-3 col-lg-3 col-md-3 js-fil-bar ">
        <div class="filter-groups d-block full clearfix">
            <div class="filter-title d-flex align-items-center justify-content-between" data-toggle="collapse" data-target="#brandlist" aria-expanded="true">
                <a class="txt-color-highlight" <?php if ($categoryget != '' || $maincategoryget != '') {
                                                    echo 'href="index?page=category&maincategory=' . $maincategoryget . '&category=' . $categoryget . '"';
                                                } else {echo 'href="index?page=category&searchinfo=' . $searchget.'"';} ?>>All brands</a>
                <i class="fa fa-plus">
                </i>
            </div>
            <ul class="filter-nav collapse show" id="brandlist">
                <?php

                if (isset($products1)) {
                    $brands = array();
                    foreach ($products1 as $product) {
                        $temp_brand = $product['brandNAME'];
                        if (!in_array($temp_brand, $brands)) {
                            array_push($brands, $temp_brand);
                        }
                    }
                    foreach ($brands  as $brand) : ?>
                        <li class="nav-item">
                            <?php
                            if ($searchget == '') {
                                if (isset($_GET['brand']) && $_GET['brand'] == $brand) {
                                    echo '
                    <a class="txt-color-highlight"
                    href="index?page=category&brand=' . $brand . '&maincategory=' . $maincategoryget . '&category=' . $categoryget . '">
                    ' . strtoupper($brand) . '
                    </a> 
                    ';
                                } else {
                                    echo '
                    <a class="txt-color-black"
                    href="index?page=category&brand=' . $brand . '&maincategory=' . $maincategoryget . '&category=' . $categoryget . '">
                    ' . strtoupper($brand) . '
                    </a> 
                    ';
                                }
                            } else {
                                if (isset($_GET['brand']) && $_GET['brand'] == $brand) {
                                    echo '
                        <a class="txt-color-highlight"
                        href="index?page=category&brand=' . $brand . '&searchinfo=' . $searchget . '">
                        ' . strtoupper($brand) . '
                        </a> 
                        ';
                                } else {
                                    echo '
                        <a class="txt-color-black"
                        href="index?page=category&brand=' . $brand . '&searchinfo=' . $searchget . '">
                        ' . strtoupper($brand) . '
                        </a> 
                        ';
                                }
                            }
                            ?>
                        </li>
                <?php endforeach;
                } ?>
            </ul>
        </div>

        <!-- <div class="col-11">
        <div class="fb-page" data-href="https://www.facebook.com/aptechvietnam.com.vn" data-tabs="timeline" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/aptechvietnam.com.vn" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/aptechvietnam.com.vn"></a></blockquote></div>
        </div> -->
    </div>

    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
        <div class=" col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 " style="display: inline-flex;">
            <div class=" col-xl-3 col-lg-3  col-md-12 col-sm-12 col-xs-12 float-left">

                <?php if (isset($total_products) && $total_products != 0) echo '<p class="Vegur" style="padding-left: 10px">' . $total_products . ' result(s) ' . $searchget;
                if (isset($_GET['brand']) && $_GET['brand'] != '') {
                    echo ' for brand is ' . $_GET['brand'] . '.</p>';
                } else {
                    echo '.</p>';
                }
                ?></div>
            <div class=" col-xl-9 col-lg-9 col-md-10 col-sm-11  col-xs-11 range-slider">
                <div class="float-right d-flex justify-content-end ">
                    <span class="Vegur txt-color-highlight">
                        Price Range:
                    </span>
                    <div class="aria-widget-slider">
                        <div id="minpricez" class="rail-label min">
                            <?= $min ?>
                        </div>
                        <div class="rail justify-content-center" id="rail" style="width:160px; ">
                            <img id="minPricex" src="imgs/min-arrow.png" role="slider" tabindex="0" class="min thumb" aria-valuemin="0" aria-valuenow="<?= $min ?>" aria-valuetext="<?= $min ?>" aria-valuemax="200" aria-label="Hotel Minimum Price">
                            <img id="maxPricex" src="imgs/max-arrow.png" role="slider" tabindex="0" class="max thumb" aria-valuemin="0" aria-valuenow="<?= $max ?>" aria-valuetext="<?= $max ?>" aria-valuemax="200" aria-label="Hotel Maximum Price">

                        </div>
                        <div id="maxpricez" class="rail-label max">
                            <?= $max ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-xs-12 d-flex justify-content-start " style="flex-wrap: wrap;">
            <?php foreach ($products as $key=>$product) : 
                if ($key < (($current_page - 1) * $num_products_on_each_page) || $key >= ($current_page * $num_products_on_each_page)) continue;?>
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
        </div>
    </div>

    <!-- filter price range script -->

    <script>
        var element1 = document.getElementById('minpricez');
        element1.addEventListener('DOMSubtreeModified', myFunction);
        var element2 = document.getElementById('maxpricez');
        element2.addEventListener('DOMSubtreeModified', myFunction);
        $(document).ready(function() {
            myFunction();
        });
        function myFunction() {
            minnn = parseInt(document.getElementById("minpricez").innerHTML.slice(1));
            maxxx = parseInt(document.getElementById("maxpricez").innerHTML.slice(1));
            <?php foreach ($products as $product) : ?>
                rightprice<?= $product['productID'] ?> = <?= $product['price'] ?>;
                if (rightprice<?= $product['productID'] ?> > minnn && rightprice<?= $product['productID'] ?> < maxxx) {
                    $('#product<?= $product['productID'] ?>').removeAttr('hidden');
                } else {
                    $('#product<?= $product['productID'] ?>').attr('hidden', true);
                }
            <?php endforeach; ?>
        }
    </script>