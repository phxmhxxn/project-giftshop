<?php
include('../../config/connect.php');

if (isset($_POST['add'])) {
    //add
    try {
        $sql_add = $pdo->prepare("INSERT INTO categories(`name`,`maincategoryID`) VALUE( ? , ?)");
        $sql_add->bindParam(1, $_POST['name'], PDO::PARAM_STR);
        $sql_add->bindParam(2, $_POST['main_category'], PDO::PARAM_STR);
        $sql_add->execute();
    } catch (PDOException $exception) {
        echo "cannot add the category";
    }
} elseif (isset($_POST['edit'])) {
    //update
    try {
        $sql_update = $pdo->prepare("UPDATE categories SET `name`= ? ,`stt`= ? ,`maincategoryID`= ? WHERE categoryID= ? ");
        $sql_update->bindParam(1, $_POST['name'], PDO::PARAM_STR);
        $sql_update->bindParam(2, $_POST['stt'], PDO::PARAM_STR);
        $sql_update->bindParam(3, $_POST['main_category'], PDO::PARAM_STR);
        $sql_update->bindParam(4, $_GET['id'], PDO::PARAM_STR);
        $sql_update->execute();
    } catch (PDOException $exception) {
        echo "cannot update the category";
        
    }
} else {
    //DELETE
    try {
        $id = $_GET['id'];
        $sql_delete = $pdo->prepare("DELETE FROM categories WHERE categoryID = ? ");
        $sql_delete->bindParam(1, $_GET['id'], PDO::PARAM_STR);
        $sql_delete->execute();
    } catch (PDOException $exception) {
        echo "cannot delete the category";
    }
}
 
?>
<center>DONE! <br><a href="../../index?action=categorymanager&query=add">go back</a></center>