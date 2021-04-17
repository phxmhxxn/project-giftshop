<?php
$sql_list = $pdo->prepare("SELECT * FROM brands ORDER BY brandID DESC");
$sql_list->execute();
$query_list = $sql_list->fetchAll(PDO::FETCH_ASSOC);
?>
<hr> 
<p>LIST OF BRAND</P>
<table class="table-active table-hover" border="1" width=50% style="border-collapse: collapse">
  <tr>
    <th>ID</th>
    <th>NAME</th>
    <th>STATUS</th>
    <th>MANAGER</th>
  </tr>
  <?php
  $i = 0;
  foreach ($query_list as $brand) {
    $i++;
  ?>
    <tr>
      <td><?php echo $i ?></td>
      <td><?php echo $brand['name'] ?></td>
      <td><?php if ($brand['stt'] == 1) {
            echo 'SHOW';
          } else {
            echo 'HIDDEN';
          } ?>
      </td>
      <td>
        <a onclick="return confirm('Do you really want to delete this brand?');" href="modules/brandmanager/analyze?id=<?php echo $brand['brandID'] ?>">Delete</a>||
        <a href="?action=brandmanager&query=edit&id=<?php echo $brand['brandID'] ?>">Edit</a>
      </td>
    </tr>
  <?php
  }
  ?>
</table>