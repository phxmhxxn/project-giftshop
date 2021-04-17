<?php
$sql_list = $pdo->prepare("SELECT * FROM main_categories ORDER BY maincategoryID DESC");
$sql_list->execute();
$query_list = $sql_list->fetchAll(PDO::FETCH_ASSOC);
?>
<p>LIST OF MAIN CATEGORY</P>
<table  class="table-active  table-hover table-boddered w-50"  border="1" width=50% style="border-collapse: collapse">
  <thead class="thead-dark">
    <th class="text-center">ID</th>
    <th>NAME</th>
    <th class="text-center">STATUS</th>
    <th class="text-center">MANAGER</th>
  </thead>
  <?php
  $i = 0;
  foreach ($query_list as $main_category) {
    $i++;
  ?>
    <tr>
      <td class="text-center"><?php echo $i ?></td>
      <td><?php echo $main_category['name'] ?></td>
      <td class="text-center"><?php if ($main_category['stt'] == 1) {
                                echo 'SHOW';
                              } else {
                                echo 'HIDDEN';
                              } ?>
      </td>
      <td class="text-center">
        <a onclick="return confirm('Do you really want to delete this main category?');" href="modules/maincategorymanager/analyze?id=<?php echo $main_category['maincategoryID'] ?>">Delete</a>||
        <a href="?action=maincategorymanager&query=edit&id=<?php echo $main_category['maincategoryID'] ?>">Edit</a>
      </td>
    </tr>
  <?php
  }
  ?>
</table>