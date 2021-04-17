<?php
$sql_list = $pdo->prepare("SELECT * FROM categories ORDER BY maincategoryID DESC");
$sql_list->execute();
$query_list = $sql_list->fetchAll(PDO::FETCH_ASSOC);
?>
<hr>
<p>LIST OF CATEGORIES</P>
<table class="table-active table-hover table-boddered w-50" border="1" width=50% style="border-collapse: collapse">
  <thead class="thead-dark">
    <th>ID</th>
    <th>NAME</th>
    <th>MAIN CATEGORY</th>
    <th>STATUS</th>
    <th>MANAGER</th>
  </thead>
  <?php
  $i = 0;
  foreach ($query_list as $category) {
    $i++;
  ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $category['name'] ?></td>
      <?php
      $sql_select = $pdo->prepare("SELECT * FROM main_categories ORDER BY maincategoryID");
      $sql_select->execute();
      $query_select = $sql_select->fetchAll(PDO::FETCH_ASSOC); 
      foreach ($query_select as $main_categories) {
        if ($main_categories['maincategoryID'] == $category['maincategoryID']) {
          echo '<td>' . $main_categories['name'] . '</td>';
          break;
        }
      }
      ?>
      <td><?php if ($category['stt'] == 1) {
            echo 'SHOW';
          } else {
            echo 'HIDDEN';
          } ?>
      </td>
      <td>
        <a onclick="return confirm('Do you really want to delete this category?');" href="modules/categorymanager/analyze?id=<?php echo $category['categoryID'] ?>">Delete</a>||
        <a href="?action=categorymanager&query=edit&id=<?php echo $category['categoryID'] ?>">Edit</a>
      </td>
    </tr>
  <?php
  }
  ?>
</table>