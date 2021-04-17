<?php

include 'cartinfo.php';

//insert information to invoices and bill table
if (isset($_POST['invoice']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {

    foreach ($products as $product) {
        $stmt = $pdo->prepare('SELECT `products`.`quantity` from `products` WHERE `products`.`productID` = ?');
        $stmt->bindParam(1, $product['productID'], PDO::PARAM_STR);
        $stmt->execute();
        $quant = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($quant["quantity"] < $products_in_cart[$product['productID']]) {
            header('Location: index?page=error');
            exit();
        }
    }

    foreach ($products as $product) {
        $stmt = $pdo->prepare('UPDATE `products` SET `quantity` = `quantity` - ? WHERE `products`.`productID` = ?');
        $stmt->bindParam(1, $products_in_cart[$product['productID']], PDO::PARAM_STR);
        $stmt->bindParam(2, $product['productID'], PDO::PARAM_STR);
        $stmt->execute();
    }

    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $date = date('Y-m-d H:i:s', time());


    $stmt = $pdo->prepare('INSERT INTO `invoices` '
        . '(`name`, `phone`, `address`, `city`, `CreateDate`, `stt`,`userID`)' .
        ' VALUES (?, ?, ?, ?, ?, 0, 0);'); 
    if(isset($_SESSION['userID'])) {
        $stmt = $pdo->prepare('INSERT INTO `invoices` '
        . '(`name`, `phone`, `address`, `city`, `CreateDate`, `stt`, `userID`)' .
        ' VALUES (?, ?, ?, ?, ?, 0, ?);');
        $stmt->bindParam(6, $_SESSION['userID'], PDO::PARAM_STR);
    }

    $stmt->bindParam(1, $_POST['customer_name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(4, $_POST['addresscity'], PDO::PARAM_STR);
    $stmt->bindParam(5, $date, PDO::PARAM_STR);
    $stmt->execute();

    $stmt = $pdo->prepare('SELECT invoiceID FROM invoices WHERE `name` = ? AND `phone` = ?  AND `address` = ? AND `city` = ? AND `CreateDate` = ? LIMIT 1');
    $stmt->bindParam(1, $_POST['customer_name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(4, $_POST['addresscity'], PDO::PARAM_STR);
    $stmt->bindParam(5, $date, PDO::PARAM_STR);
    $stmt->execute();
    $lastinvoices = $stmt->fetch(PDO::FETCH_ASSOC);
    foreach ($lastinvoices as $lastinvoice) {
        $BillID = $lastinvoice;
    }

    foreach ($products as $product) {
        $stmt = $pdo->prepare('INSERT INTO `billing` '
            . '(`invoiceID`, `ProductID`, `price` ,`quantity`)' .
            ' VALUES (?, ?, ?, ?);');
        $stmt->bindParam(1, $BillID, PDO::PARAM_STR);
        $stmt->bindParam(2, $product['productID'], PDO::PARAM_STR);
        $stmt->bindParam(3, $product['price'], PDO::PARAM_STR);
        $stmt->bindParam(4, $products_in_cart[$product['productID']], PDO::PARAM_STR);
        $stmt->execute();
        unset($_SESSION['cart'][$product['productID']]);
    }
    header('Location: index?page=placeorder');
    exit;
} elseif (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {

    header('Location: index?page=home');
}
?>


<?php include 'navbar.php'; ?>
<div class="mx-auto " style="width: 90%;">
<div class="cart col-lg-9 col-md-10 col-sm-11 col-12 mx-auto" >
    <h1 class="mx-auto">Invoice's Information</h1>
    <form action="index?page=invoice" method="post">
        <div class="col-10">
        <div class="form-row col-7">
            <div class=" mb-3">
                <label>Your name</label>
                <input type="text" class="form-control" placeholder="Your name" required name="customer_name" value="<?= isset($_SESSION['customerFname']) ? $_SESSION['customerFname'] : '' ?>">
            </div>
        </div>
        <div class="form-row col-7">
            <div class="mb-3">
                <label>Phone number </label>
                <input type="tel" min="0" class="form-control" pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" required name="phone" value="<?= isset($_SESSION['phone']) ? $_SESSION['phone'] : '' ?>">
            </div>
        </div>
        <div class="form-row col-7">
            <div class=" mb-3">
                <label>Address City</label>
                <select id="city" name="addresscity">
                    <option value="Hà Nội">Tp.Hà Nội
                    <option value="Hồ Chí Minh">TP HCM
                    <option value="Cần Thơ">Tp.Cần Thơ
                    <option value="Đà Nẵng">Tp.Đà Nẵng
                    <option value="Hải Phòng">Tp.Hải Phòng
                    <option value="An Giang">An Giang
                    <option value="Bà Rịa - Vũng Tàu">Bà Rịa - Vũng Tàu
                    <option value="Bắc Giang">Bắc Giang
                    <option value="Bắc Kạn">Bắc Kạn
                    <option value="Bạc Liêu">Bạc Liêu
                    <option value="Bắc Ninh">Bắc Ninh
                    <option value="Bến Tre">Bến Tre
                    <option value="Bình Định">Bình Định
                    <option value="Bình Dương">Bình Dương
                    <option value="Bình Phước">Bình Phước
                    <option value="Bình Thuận">Bình Thuận
                    <option value="Cà Mau">Cà Mau
                    <option value="Cao Bằng">Cao Bằng
                    <option value="Đắk Lắk">Đắk Lắk
                    <option value="Đắk Nông">Đắk Nông
                    <option value="Điện Biên">Điện Biên
                    <option value="Đồng Nai">Đồng Nai
                    <option value="Đồng Tháp ">Đồng Tháp
                    <option value="Gia Lai">Gia Lai
                    <option value="Hà Giang">Hà Giang
                    <option value="Hà Nam">Hà Nam
                    <option value="Hà Tĩnh">Hà Tĩnh
                    <option value="Hải Dương">Hải Dương
                    <option value="Hậu Giang">Hậu Giang
                    <option value="Hòa Bình">Hòa Bình
                    <option value="Hưng Yên">Hưng Yên
                    <option value="Khánh Hòa">Khánh Hòa
                    <option value="Kiên Giang">Kiên Giang
                    <option value="Kon Tum">Kon Tum
                    <option value="Lai Châu">Lai Châu
                    <option value="Lâm Đồng">Lâm Đồng
                    <option value="Lạng Sơn">Lạng Sơn
                    <option value="Lào Cai">Lào Cai
                    <option value="Long An">Long An
                    <option value="Nam Định">Nam Định
                    <option value="Nghệ An">Nghệ An
                    <option value="Ninh Bình">Ninh Bình
                    <option value="Ninh Thuận">Ninh Thuận
                    <option value="Phú Thọ">Phú Thọ
                    <option value="Quảng Bình">Quảng Bình
                    <option value="Quảng Bình">Quảng Bình
                    <option value="Quảng Ngãi">Quảng Ngãi
                    <option value="Quảng Ninh">Quảng Ninh
                    <option value="Quảng Trị">Quảng Trị
                    <option value="Sóc Trăng">Sóc Trăng
                    <option value="Sơn La">Sơn La
                    <option value="Tây Ninh">Tây Ninh
                    <option value="Thái Bình">Thái Bình
                    <option value="Thái Nguyên">Thái Nguyên
                    <option value="Thanh Hóa">Thanh Hóa
                    <option value="Thừa Thiên Huế">Thừa Thiên Huế
                    <option value="Tiền Giang">Tiền Giang
                    <option value="Trà Vinh">Trà Vinh
                    <option value="Tuyên Quang">Tuyên Quang
                    <option value="Vĩnh Long">Vĩnh Long
                    <option value="Vĩnh Phúc">Vĩnh Phúc
                    <option value="Yên Bái">Yên Bái
                    <option value="Phú Yên">Phú Yên
                </select>
                <script>
                    var ident = "<?= isset($_SESSION['city']) ? $_SESSION['city'] : '' ?>";
                    $('#city option[value="' + ident + '"]').attr("selected", "selected");
                </script>
            </div>
        </div>
        <div class="form-row col-10">
            <div class="mb-3">
                <label>Address</label>
                <input type="text" class="form-control" value="<?= isset($_SESSION['address']) ? $_SESSION['address'] : '' ?>" placeholder="address" name="address" required>
            </div>
        </div>
        </div>
        <div class="col-12">
        <table class="col-12" >
            <thead>
                <tr>
                    <td colspan="2" class="col-6">Product</td>
                    <td>Price</td>
                    <td>Quantity</td>
                    <td>Total</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product) :
                    if (isset($_POST["remove$product[productID]"])) {
                        unset($_SESSION['cart'][$product['productID']]);
                        header('location: index?page=cart');
                    }
                ?>
                    <tr>

                        <td class="img">
                            <a href="index?page=product&id=<?= $product['productID'] ?>">
                                <img src="imgs/<?= $product['img'] ?>" width="50" height="50" alt="<?= $product['name'] ?>">
                            </a>
                        </td>
                        <td >
                            <a class="wrap" style="white-space: normal !important; padding-left:10px " href="index?page=product&id=<?= $product['productID'] ?>"><?= $product['name'] ?></a>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] ?></td>
                        <td class="quantity">
                            <p name="quantity-<?= $product['productID'] ?>" required><?= $products_in_cart[$product['productID']] ?></p>
                        </td>
                        <td class="price">&dollar;<?= $product['price'] * $products_in_cart[$product['productID']] ?></td>
                    </tr>
                <?php endforeach; ?>


            </tbody>
        </table>
        <div class="subtotal">
            <span class="text">Subtotal</span>
            <input type="text" value="<?= $subtotal ?>" name="totalcost" hidden>
            <span class="price">&dollar;<?= $subtotal ?></span>
        </div>
        <div class="buttons">
            <input type="submit" value="Send order" name="invoice">
        </div></div>
    </form>
</div></div>