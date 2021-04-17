<?php
$sql_edit = $pdo->prepare("SELECT * FROM main_categories WHERE maincategoryID = ? LIMIT 1 ");
$sql_edit->bindParam(1, $_GET['id'], PDO::PARAM_STR);
$sql_edit->execute();
$query_edit = $sql_edit->fetchAll(PDO::FETCH_ASSOC);
?>

<p>EDIT MAIN CATEGORY</p>
<table border="1" width=50% style="border-collapse: collapse">
  <form method="POST" action="modules/maincategorymanager/analyze?id=<?php echo $_GET['id'] ?>">
    <?php
    foreach ($query_edit as $main_category) {
    ?>
      <tr>
        <th>INPUT FORM</th>
      </tr>
      <tr>
        <td>MAIN CATEGORY NAME</td>
        <td><input type="text" value="<?php echo $main_category['name'] ?>" name="name"></td>
      </tr>
      <tr>
        <td>STATUS</td>
        <td>
          <select name="stt">
            <?php
            if ($main_category['stt'] == 1) {
            ?>
              <option value="1" selected>ACTIVE</option>
              <option value="0">DISABLE</option>
            <?php
            } else {
            ?>
              <option value="1">ACTIVE</option>
              <option value="0" selected>DISABLE</option>
            <?php
            }
            ?>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" name="edit" value="SAVE"></td>
      </tr>
    <?php
    }
    ?>
  </form>
</table>