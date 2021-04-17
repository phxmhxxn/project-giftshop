<?php
$sql_edit_product = $pdo->prepare("SELECT * FROM invoices WHERE invoiceID = ? LIMIT 1 ");
$sql_edit_product->bindParam(1, $_GET['invoiceid'], PDO::PARAM_STR);
$sql_edit_product->execute();
$query_edit_product = $sql_edit_product->fetchAll(PDO::FETCH_ASSOC);

foreach ($query_edit_product as $row_invoice) {
?>
    <p>DETAILS</p>
    <form action="modules/invoicemanager/analyze" method="POST">
        <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
        Invoice Number : <?php echo $row_invoice['invoiceID'] ?>
        <br>
        Created date : <?php echo $row_invoice['CreateDate'] ?>
        <br>
        Customer name : <input type="text" name="name" required value="<?php echo $row_invoice['name'] ?>">
        <br>
        Phone number : <input type="number" name="phone" required value="<?php echo $row_invoice['phone'] ?>">
        <br>
        City:
        <select id="city" name="city">
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
        <br>
        Address : <input type="text" name="address" required value="<?php echo $row_invoice['address'] ?>">
        <br>
        Freeshipping? : <select name="freeshipping" id="freeshipping">
            <option value="0">NO
            <option value="1">YES
        </select>
        <br>
        Status : <?php if ($row_invoice['stt'] == 0) {
                        echo 'PENDING';
                    }
                    if ($row_invoice['stt'] == 1) {
                        echo 'CANCELLED';
                    }
                    if ($row_invoice['stt'] == 2) {
                        echo 'SHIPPING';
                    }
                    if ($row_invoice['stt'] == 3) {
                        echo 'DECLINED - SHIPPING BACK';
                    }
                    if ($row_invoice['stt'] == 4) {
                        echo 'SHIPPED BACK';
                    }
                    if ($row_invoice['stt'] == 5) {
                        echo 'COMPLETED';
                    }
                    if ($row_invoice['stt'] == 6) {
                        echo 'PARTIALLY SHIPPED';
                    } 
                } ?>
    <br>
    <input type="submit" name="editinvoice" value="Confirm">
    </form>
    <script>
        $(document).ready(function() {
            $("select#city").val("<?php echo $row_invoice['city'] ?>");
            $("select#freeshipping").val("<?php echo $row_invoice['freeshipping'] ?>");
        });
    </script>