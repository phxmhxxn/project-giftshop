<?php


$account = isset($_POST['username']) ? $_POST['username'] : '';

if (isset($_POST['register'])) {
    $result = $pdo->query("select * from tbl_admin where username = '$account'");
    $num = $result->rowCount();
    if ($num >= 1) {
        echo '<script>alert("Username already exists, please re-enter.")</script>';
        header("index?page=register");
    } else {
        $role1 = $_POST['role'];
        $password = md5($_POST['password']);
        $reg = $pdo->query("insert into tbl_admin(username,password,role) value('$account','$password','$role1')");
        echo 'echo "<script>
            alert("Register successfully");
            window.location.href="index";
            </script>";
            ';
    }
}

if (isset($_POST['addslide'])) {

    $img = (isset($_FILES['image'])) ? ($_FILES['image']['name']) : "";
    $img_tmp = (isset($_FILES['image'])) ? ($_FILES['image']['tmp_name']) : "";

    $stmt = $pdo->prepare(' INSERT INTO slideshow (img,stt) VALUES (?,1) ');
    $stmt->bindParam(1, $img, PDO::PARAM_STR);
    $stmt->execute();
    move_uploaded_file($img_tmp, '../slideshow/' . $img);
}
if (isset($_POST['removeslide'])) {

    $sql = $pdo->prepare("SELECT img FROM slideshow WHERE id = ? LIMIT 1");
    $sql->bindParam(1, $_POST['imgid'], PDO::PARAM_INT);
    $sql->execute();
    $query = $sql->fetchAll(PDO::FETCH_ASSOC);
    foreach ($query as $row) {
        $sql_delete = $pdo->prepare("DELETE FROM slideshow WHERE id = ? ");
        $sql_delete->bindParam(1,$_POST['imgid'], PDO::PARAM_INT);
        $sql_delete->execute();
        $result = $sql_delete->fetchAll(PDO::FETCH_ASSOC);
        if ($result) unlink('../slideshow/' . $row['img']);
    }
}
$stmt = $pdo->prepare(' SELECT * FROM slideshow');
$stmt->execute();
$slides = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<br>
<div class="wrapper-login justify-content-center d-flex">
    <br>
    <div><input id="button" type="button" value="ADD NEW SLIDESHOW" class="btn btn-success btn-hover" value="click me">
        <div id="addproduct" style="display: none;">
            <h2>ADD NEW SLIDESHOW</h2>
            <br>
            <form method="POST" action="" enctype="multipart/form-data">

                <table class="table-bordered table-secondary table-hover" width=60% style="border-collapse: collapse">
                    <tr>
                        <td class="text-right pr-2">IMAGE</td>
                        <td><input type="file" name="image" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td class="text-center" colspan="2"><input class="btn btn-success btn-hover" type="submit" name="addslide" value="ADD"></td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
    <script>
        $("#button").on('click', function() {
            $("#addproduct").toggle();
        });
    </script>
    <br>
</div>
<br>
<?php if (!empty($slides)) { ?>
    <div class="wrapper-login justify-content-center d-flex">
        <table class="table-secondary table-hover text-center" border="1" width=60% style="border-collapse: collapse">
            <tr>
                <td class="text-center pr-2 py-2" colspan="2">SLIDESHOW IMAGES</td>
            </tr>
            <?php foreach ($slides as $slide) { ?>
                <tr>
                    <form action="" method="POST">
                        <td class="text-center">
                            <img src="../../../slideshow/<?php echo $slide['img'] ?>" height="200px">
                        </td>
                        <input type="text" hidden name="imgid" value="<?=$slide['id']?>">
                        <td><input class="btn btn-danger btn-hover" type="submit" name="removeslide" value="REMOVE"></td>
                    </form>
                </tr>
            <?php } ?>
        </table>
    </div>
<?php } ?>
<br><br><br>


<div class="wrapper-login justify-content-center d-flex">
    <div class=" m-auto">
        <form action="" autocomplete="off" method="POST">
            <table class="table table-danger table-bordered" style="text-align: start; border-width:1 ">
                <tr>
                    <td colspan="2">
                        <h3>Create admin account</h3>
                    </td>
                </tr>
                <tr>
                    <td>Your user name</td>
                    <td><input name="username" type="text" required>
                    </td>
                </tr>
                <tr>
                    <td>Your password</td>
                    <td><input id="input" name="password" type="password" oninput="
                    if(this.checkValidity()) form.password2.pattern = this.value;" required></td>
                </tr>
                <tr>
                    <td>Confirm your password</td>
                    <td>
                        <input id="input" name="password2" type="password" required>
                    </td>
                </tr>
                <tr>
                    <td>Role</td>
                    <td>
                        <select name="role" id="role">
                            <option value="2">Invoice management
                            <option value="1">Product management
                            <option value="0">Master admin
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="register" value="register"></td>
                </tr>
            </table>
        </form>
    </div>
</div>