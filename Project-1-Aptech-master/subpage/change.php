<?php include 'navbar.php'; ?>
<?php
$stmt = $pdo->prepare('SELECT * FROM customer_user WHERE username = ?');
$stmt->bindParam(1, $_SESSION['login1'], PDO::PARAM_STR);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php
if (isset($_POST['update'])) {
    $new_Fname = $_POST['customerFname'];
    $new_Lname = $_POST['customerLname'];
    $new_email = $_POST['email'];
    $new_address = $_POST['address'];
    $new_city = $_POST['addresscity'];
    if($new_email != $_SESSION['email']) {
    $stmt = $stmt = $pdo->prepare("select * from customer_user where email = ? ");
    $stmt->bindParam(1, $new_email, PDO::PARAM_STR);
    $stmt->execute();
    $result = $stmt->rowCount(); 
    if ($result >= 1) {
        echo '<script>alert("email already exists, please re-enter.")</script>'; 
    } }else 
    {
    $stmt = $pdo->prepare('UPDATE customer_user SET customerFname=?,customerLname=?,email=?,address=?,city=?  WHERE username = ?');
    $stmt->bindParam(1, $new_Fname, PDO::PARAM_STR);
    $stmt->bindParam(2, $new_Lname, PDO::PARAM_STR);
    $stmt->bindParam(3, $new_email, PDO::PARAM_STR);
    $stmt->bindParam(4, $new_address, PDO::PARAM_STR);
    $stmt->bindParam(5, $new_city, PDO::PARAM_STR);
    $stmt->bindParam(6, $_SESSION['login1'], PDO::PARAM_STR);
    $stmt->execute();
    $_SESSION['address'] = $_POST['address'];
    $_SESSION['customerFname'] = $_POST['customerFname'];
    $_SESSION['customerLname'] = $_POST['customerLname'];
    $_SESSION['email'] = $_POST['email'];
    $_SESSION['city'] = $_POST['addresscity'];
    echo '<script>alert("Change information successfully.")</script>';
    }
}

?>
<div class="wrapper-login justify-content-center d-flex">
    <div class=" m-auto">
        <form action="" autocomplete="off" method="POST">
            <table class="table table-danger table-bordered" style="text-align: center; border-width:1 ">
                <tr>
                    <td colspan="2">
                        <h3>Change Information</h3>
                    </td>
                </tr>
                <tr>
                    <td>First Name</td>
                    <td>
                        <input type="text" name="customerFname" id="customerFname" value="<?=$_SESSION['customerFname']?>" >

                    </td>
                </tr>
                <tr>
                    <td>Family Name</td>
                    <td>
                        <input type="text" name="customerLname" id="customerLname" value="<?=$_SESSION['customerLname']?>" >

                    </td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td> 
            <input id="input" name="email" type="email" 
            pattern="^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$" value="<?=$_SESSION['email']?>"> 
                    </td>
                </tr>
                <tr>
                    <td>City</td>
                    <td> <select id="city" name="addresscity">
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
                    </td>
                </tr>
                <tr>
                    <td>Address</td>
                    <td>
                        <input type="address" name="address" id="address" value="<?=$_SESSION['address']?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="update" value="update"></td>
                </tr>
            </table>
        </form>
    </div>
</div>