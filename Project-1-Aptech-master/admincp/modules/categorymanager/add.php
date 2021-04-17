<?php
$sql_select = $pdo->prepare("SELECT * FROM main_categories ORDER BY maincategoryID");
$sql_select->execute();
$query_select = $sql_select->fetchAll(PDO::FETCH_ASSOC); 
?>
<br>
<table class="table-boddered table-hover" border="1" width=50% style="border-collapse: collapse">
  <form method="POST" action="modules/categorymanager/analyze">
    <tr>
      <td class="text-center"  style=" font-size: 150%;" colspan="2">NEW CATEGORY</td>
    </tr>
    <tr>
      <td class="text-center" >NEW CATEGORY NAME</td>
      <td><input type="text" name="name" width="110px" required></td>
    </tr>
    <tr>
      <td class="text-center" >Main category</td>
      <td>
        <select  class="text-center" name="main_category">
          <?php
          foreach ($query_select as $main_categories) {
          ?>
            <option  class="text-center" value="<?php echo $main_categories['maincategoryID'] ?>"><?php echo $main_categories['name'] ?></option>
          <?php
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td  class="text-center"  colspan="2"><input class="btn btn-success" type="submit" name="add" value="ADD"></td>

    </tr>
  </form>
</table>