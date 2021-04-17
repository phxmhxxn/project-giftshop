<?php
include('../../config/connect.php');

if (isset($_POST['add'])) {
    //add
    try {
        $sql_add = $pdo->prepare("INSERT INTO brands(`name`) VALUE( ? )");
        $sql_add->bindParam(1, $_POST['name'], PDO::PARAM_STR);
        $sql_add->execute();
    } catch (PDOException $exception) {
        echo "cannot add the brand";
    }
} elseif (isset($_POST['edit'])) {
    //update
    try {
        $sql_update = $pdo->prepare("UPDATE brands SET `name`= ? , `stt` = ? WHERE brandID = ?");
        $sql_update->bindParam(1, $_POST['name'], PDO::PARAM_STR);
        $sql_update->bindParam(2, $_POST['stt'], PDO::PARAM_STR);
        $sql_update->bindParam(3, $_GET['id'], PDO::PARAM_STR);
        $sql_update->execute();
    } catch (PDOException $exception) {
        echo "cannot update the brand";
    }
} else {
    try {
        $sql_delete = $pdo->prepare("DELETE FROM brands WHERE brandID = ? ");
        $sql_delete->bindParam(1, $_GET['id'], PDO::PARAM_STR);
        $sql_delete->execute();
    } catch (PDOException $exception) {
        echo "cannot delete the brand - there are some product linked to this brand";
    }
} 
?>
<center>DONE! <br><a href="../../index?action=brandmanager&query=add">go back</a></center>
