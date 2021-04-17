<?php
$sql_edit = $pdo->prepare("SELECT * FROM categories WHERE categoryID = ? LIMIT 1 ");
$sql_edit->bindParam(1, $_GET['id'], PDO::PARAM_STR);
$sql_edit->execute();
$query_edit = $sql_edit->fetchAll(PDO::FETCH_ASSOC);
?>

<?php
$sql_select = $pdo->prepare("SELECT * FROM main_categories ORDER BY maincategoryID");
$sql_select->execute();
$query_select = $sql_select->fetchAll(PDO::FETCH_ASSOC);
?>

<p>EDIT CATEGORY</p>
<table border="1" width=50% style="border-collapse: collapse">
  <form method="POST" action="modules/categorymanager/analyze?id=<?php echo $_GET['id'] ?>">
    <?php
    foreach ($query_edit as $category) {
    ?>
      <tr>
        <th>INPUT FORM</th>
      </tr>
      <tr>
        <td>CATEGORY NAME</td>
        <td><input type="text" value="<?php echo $category['name'] ?>" name="name"></td>
      </tr>
      <tr>
        <td>Main category</td>
        <td><select name="main_category">
            <?php
            foreach ($query_select as $main_categories) {

              if ($main_categories['maincategoryID'] == $category['maincategoryID']) {
            ?>
              <option selected value="<?php echo $main_categories['maincategoryID'] ?>"><?php echo $main_categories['name'] ?></option>
            <?php
            } else { ?>
              <option value="<?php echo $main_categories['maincategoryID'] ?>"><?php echo $main_categories['name'] ?></option>
<?php
            }}
            ?>
          </select></td>
      </tr>
      <tr>
        <td>STATUS</td>
        <td>
          <select name="stt">
            <?php
            if ($category['stt'] == 1) {
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