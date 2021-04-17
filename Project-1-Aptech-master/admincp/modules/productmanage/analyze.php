<?php
include('../../config/connect.php');
try {
    //IMAGE,quantity,maincategory PROCESS
    $img = (isset($_FILES['image'])) ? ($_FILES['image']['name']) : "";
    $img_tmp = (isset($_FILES['image'])) ? ($_FILES['image']['tmp_name']) : "";
    $file = (isset($_FILES['file'])) ? ($_FILES['file']['name']) : "";
    $file_tmp = (isset($_FILES['file'])) ? ($_FILES['file']['tmp_name']) : "";
    $oldquantity = (isset($_POST['quantity'])) ? intval($_POST['quantity']) : 0;
    $addamount = (isset($_POST['addamount'])) ? intval($_POST['addamount']) : 0;
    $quantity = $addamount + $oldquantity;

    if (isset($_POST['category'])) {
        $sql_maincategory = $pdo->prepare("SELECT * FROM categories WHERE categoryID = ? LIMIT 1");
        $sql_maincategory->bindParam(1, $_POST['category'], PDO::PARAM_INT);
        $sql_maincategory->execute();
        $categories = $sql_maincategory->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $categories = array(1);
    }
} catch (PDOException $exception) {
    echo "error";
}

foreach ($categories as $category) {

    if (isset($_POST['addproduct'])) {
        //ADD
        try {
            $sql_add = $pdo->prepare("INSERT INTO products(`name`,price,quantity,img,desci,stt,categoryID,brandID,`file`) VALUES(?,?,?,?,?,?,?,?,?)");
            $sql_add->bindParam(1, $_POST['nameproduct'], PDO::PARAM_STR);
            $sql_add->bindParam(2, $_POST['price'], PDO::PARAM_STR);
            $sql_add->bindParam(3, $quantity, PDO::PARAM_STR);
            $sql_add->bindParam(4, $img, PDO::PARAM_STR);
            $sql_add->bindParam(5, $_POST['description'], PDO::PARAM_STR);
            $sql_add->bindParam(6, $_POST['stt'], PDO::PARAM_STR);
            $sql_add->bindParam(7, $_POST['category'], PDO::PARAM_STR);
            $sql_add->bindParam(8, $_POST['brand'], PDO::PARAM_STR); 
            $sql_add->bindParam(9, $file, PDO::PARAM_STR);
            $sql_add->execute();
            move_uploaded_file($img_tmp, '../../../imgs/' . $img);
            move_uploaded_file($file_tmp, '../../../files/' . $file);
        } catch (PDOException $exception) {
            echo $exception;
        }
    } elseif (isset($_POST['editproduct'])) {
        //EDIT   

        try {
            $sql_update = $pdo->prepare("UPDATE products SET `name`= ?, price = ?, rrp = ? , quantity = ?, desci = ?, stt = ?, categoryID = ?, brandID = ? WHERE productID = ?");
            $sql_update->bindParam(1, $_POST['nameproduct'], PDO::PARAM_STR);
            $sql_update->bindParam(2, $_POST['price'], PDO::PARAM_STR);
            $sql_update->bindParam(3, $_POST['rrp'], PDO::PARAM_STR);
            $sql_update->bindParam(4, $quantity, PDO::PARAM_STR);
            $sql_update->bindParam(5, $_POST['description'], PDO::PARAM_STR);
            $sql_update->bindParam(6, $_POST['stt'], PDO::PARAM_STR);
            $sql_update->bindParam(7, $_POST['category'], PDO::PARAM_STR);
            $sql_update->bindParam(8, $_POST['brand'], PDO::PARAM_STR);
            $sql_update->bindParam(9, $_GET['id'], PDO::PARAM_STR);
            $sql_update->execute();
        } catch (PDOException $exception) {
            echo $exception;
        }
            if ($img != '') {
                try {
                    move_uploaded_file($img_tmp, '../../../imgs/' . $img);

                    $sql_update = $pdo->prepare("UPDATE products SET img = ? WHERE productID = ?");
                    $sql_update->bindParam(1, $img, PDO::PARAM_STR);
                    $sql_update->bindParam(2, $_GET['id'], PDO::PARAM_STR);

                    $sql = $pdo->prepare("SELECT * FROM products WHERE productID = ? LIMIT 1");
                    $sql->bindParam(1, $_GET['id'], PDO::PARAM_STR);
                    $sql->execute();
                    $query = $sql->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($query as $row) {
                        unlink('../../../imgs/' . $row['img']);
                    }

                    $sql_update->execute();
                } catch (PDOException $exception) {
                    echo $exception;
                }
            } 
            if ($file != '') {
                try {
                    move_uploaded_file($img_tmp, '../../../files/' . $file);

                    $sql_update = $pdo->prepare("UPDATE products SET `file` = ? WHERE productID = ?");
                    $sql_update->bindParam(1, $file, PDO::PARAM_STR);
                    $sql_update->bindParam(2, $_GET['id'], PDO::PARAM_STR);

                    $sql = $pdo->prepare("SELECT * FROM products WHERE productID = ? LIMIT 1");
                    $sql->bindParam(1, $_GET['id'], PDO::PARAM_STR);
                    $sql->execute();
                    $query = $sql->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($query as $row) {
                        unlink('../../../files/' . $row['file']);
                    }

                    $sql_update->execute();
                } catch (PDOException $exception) {
                    echo $exception;
                }
            } 

        
    } else {
        try {
            $sql = $pdo->prepare("SELECT img FROM products WHERE productID = ? LIMIT 1");
            $sql->bindParam(1, $_GET['id'], PDO::PARAM_STR);
            $sql->execute();
            $query = $sql->fetchAll(PDO::FETCH_ASSOC);
            foreach ($query as $row) {
                $sql_delete = $pdo->prepare("DELETE FROM products WHERE productID = ?");
                $sql_delete->bindParam(1, $_GET['id'], PDO::PARAM_STR);
                $sql_delete->execute();
                $result = $sql_delete->fetchAll(PDO::FETCH_ASSOC);
                if ($result) unlink('../../../imgs/' . $row['img']);
                if ($result) unlink('../../../files/' . $row['files']);
            }
        } catch (PDOException $exception) {
            echo "cannot delete product";
        }
    }
}
?>
<center>DONE! <br><a href="../../index?action=productmanage&query=add">go back</a></center>