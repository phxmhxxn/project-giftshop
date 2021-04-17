<?php
include('../../config/connect.php');
 
if (isset($_POST['add'])) {
    //add
    try {
        $sql_add = $pdo->prepare("INSERT INTO main_categories(`name`) VALUE( ? )");
        $sql_add->bindParam(1,$_POST['name'], PDO::PARAM_STR);
        $sql_add->execute();
    } catch (PDOException $exception) {
        echo "cannot add main category";
    } 
} elseif (isset($_POST['edit'])) {
    //update
    try {
        $sql_update = $pdo->prepare("UPDATE main_categories SET `name`= ? ,`stt`= ? WHERE maincategoryID = ?");
        $sql_update->bindParam(1,$_POST['name'], PDO::PARAM_STR);
        $sql_update->bindParam(2,$_POST['stt'], PDO::PARAM_STR);
        $sql_update->bindParam(3,$_GET['id'], PDO::PARAM_STR);
        $sql_update->execute();
    } catch (PDOException $exception) {
        echo "cannot update main category";
    } 

} else {
    try {
        $sql_delete = $pdo->prepare("DELETE FROM main_categories WHERE maincategoryID = ?");
        $sql_delete->bindParam(1,$_GET['id'], PDO::PARAM_STR);
        $sql_delete->execute();
    } catch (PDOException $exception) { 
        echo "cannot delete main category"; 
        
    }  
} 
?>
<center>DONE! <br><a href="../../index?action=maincategorymanager&query=add">go back</a></center> 
