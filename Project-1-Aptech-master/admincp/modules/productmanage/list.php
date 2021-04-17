<?php
$sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY name ASC");
if (isset($_GET['asc']) || isset($_GET['desc'])) {
  if (isset($_GET['asc'])) {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY name ASC");
  } else {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY name DESC");
  }
}
if (isset($_GET['price']) || isset($_GET['decsprice'])) {
  if (isset($_GET['price'])) {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY price ASC");
  } else {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY price DESC");
  }
}
if (isset($_GET['productid']) || isset($_GET['decsproductid'])) {
  if (isset($_GET['productid'])) {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY productID ASC");
  } else {
    $sql_list_product = $pdo->prepare("SELECT * FROM products ORDER BY productID DESC");
  }
}

$sql_list_product->execute();
$query_list_product = $sql_list_product->fetchAll(PDO::FETCH_ASSOC);
?>
<!-- search product -->
<?php
if (isset($_POST['find'])) {
  $search_product = '%' . $_POST['search_product'] . '%';
  $result = $pdo->prepare("SELECT * FROM search WHERE name LIKE ? OR productID LIKE ? ");
  $result->bindParam(1, $search_product, PDO::PARAM_STR);
  $result->bindParam(2, $search_product, PDO::PARAM_STR);
  $result->execute();
  $result1 = $result->fetchAll(PDO::FETCH_ASSOC);
}
?>
<br>
<form method="POST">
  <input type="text" name="search_product" placeholder="Search..." required>
  <input class="btn btn-warning" type="submit" name="find" value="search">
</form>
<?php
if (isset($result1)) {
?>
  <table class="table-active  table-hover table-boddered" style="width:90%" border="1">
    <thead >

      <td>PRODUCT NAME</td>
      <td>Price</td>
      <td>RETAIL PRICE</td>
      <td>IN STOCK</td>
      <td>CATOGERY</td>
      <td>PRODUCT ID</td>
      <td>STATUS</td>
      <td>MANAGE</td>
    </thead>
    <?php
    foreach ($result1 as $row) {

    ?>
      <tr>
        <td class="table-active text-center"><?= $row['name'] ?></td>
        <td class="table-active text-center"><?= $row['price'] ?></td>
        <td class="table-active text-center"><?= $row['rrp'] ?></td>
        <td class="table-active text-center"><?= $row['quantity'] ?></td>
        <td class="table-active text-center"><?= $row['categoryNAME'] ?></td>
        <td class="table-active text-center"><?= $row['productID'] ?></td>
        <td class="table-active text-center"><?php if ($row['stt'] == 1) {
                                                echo 'ACTIVE';
                                              } else {
                                                echo 'DISABLE';
                                              } ?></td>
        <td class="table-active text-center">
            <a onclick="return confirm('Do you really want to delete this product?');" href="modules/productmanage/analyze?id=<?php echo $row['productID'] ?>">Delete</a>||
            <a href="index?action=productmanage&query=edit&id=<?php echo $row['productID'] ?>">Edit</a></td>
      </tr>
  <?php
    }
  }
  ?>
  </table>
  <center>
    <link rel="stylesheet" href=".././style.css">
    <br>
    <h2>PRODUCT LIST</h2>
    <table class="table-active table-hover table-boddered" style="width:90%;" border="1">
      <thead class="thead-dark">
        <th class="text-center">Id</th>
        <th class="text-center">IMAGE</th>
        <th class="text-center">
          <form method="get" action="/admincp/index">
            <input hidden type="text" name="action" value="productmanage">
            <input hidden type="text" name="query" value="add">
            <button class="sortbutton" type="submit" id="asc" name="<?php
                                                                    if (isset($_GET['desc'])) {
                                                                      echo 'asc';
                                                                    } else {
                                                                      echo 'desc';
                                                                    }
                                                                    ?>" value="asc" style="float:right">PRODUCT NAME <i class="fas fa-sort"></i></button>
          </form>
        </th>

        <th class="text-center">
          <form method="get" action="/admincp/index">
            <input hidden type="text" name="action" value="productmanage">
            <input hidden type="text" name="query" value="add">
            <button class="sortbutton" type="submit" id="price" name="<?php
                                                                      if (isset($_GET['decsprice'])) {
                                                                        echo 'price';
                                                                      } else {
                                                                        echo 'decsprice';
                                                                      }
                                                                      ?>" value="price" style="float:right">Price <i class="fas fa-sort"></i></button>
          </form>
        </th>
        <th class="text-center">RETAIL PRICE</th>
        <th class="text-center">IN STOCK</th>
        <th class="text-center">CATOGERY</th>
        <th class="text-center">
          <form method="get" action="/admincp/index">
            <input hidden type="text" name="action" value="productmanage">
            <input hidden type="text" name="query" value="add">
            <button class="sortbutton" type="submit" id="productid" name="<?php
                                                                          if (isset($_GET['decsproductid'])) {
                                                                            echo 'productid';
                                                                          } else {
                                                                            echo 'decsproductid';
                                                                          }
                                                                          ?>" value="productid" style="float:right">PRODUCT ID <i class="fas fa-sort"></i></button>
          </form>
        </th>
        <th class="text-center">STATUS</th>
        <th class="text-center">MANAGE</th>
      </thead>
      <?php
      $i = 0;
      foreach ($query_list_product as $row) {
        $i++;
      ?>
        <tr>
          <td class="table-active text-center"><?php echo $i ?></td>
          <td class="table-active text-center">
            <div><input id="showimagebtn<?= $row['productID'] ?>" type="button" value="SHOW IMAGE" class="btn btn-success btn-hover" value="click me">
              <div id="showimage<?= $row['productID'] ?>" style="display: none;">
                <img src="../../../imgs/<?php echo $row['img'] ?>" width="150px">
              </div>
            </div>
          </td>
          <td class="table-active text-center"><?php echo $row['name'] ?></td>
          <td class="table-active text-center"><?php echo $row['price'] ?></td>
          <td class="table-active text-center"><?php echo $row['rrp'] ?></td>
          <td class="table-active text-center"><?php echo $row['quantity'] ?></td>
          <?php
          $sql_select = $pdo->prepare("SELECT * FROM categories ORDER BY categoryID");
          $sql_select->execute();
          $query_select = $sql_select->fetchAll(PDO::FETCH_ASSOC);
          foreach ($query_select as $categories) {
            if ($categories['categoryID'] == $row['categoryID']) {
              echo '<td class="table-active text-center">' . $categories['name'] . '</td>';
              break;
            }
          }
          ?>
          <td class="table-active text-center"><?php echo $row['productID'] ?></td>
          <td class="table-active text-center"><?php if ($row['stt'] == 1) {
                                                  echo 'ACTIVE';
                                                } else {
                                                  echo 'DISABLE';
                                                } ?>
          </td>
          <td class="table-active text-center">
            <a onclick="return confirm('Do you really want to delete this product?');" href="modules/productmanage/analyze?id=<?php echo $row['productID'] ?>">Delete</a>||
            <a href="index?action=productmanage&query=edit&id=<?php echo $row['productID'] ?>">Edit</a>
          </td>
        </tr>
      <?php
      }
      ?>
    </table>
  </center>
  <script>
    <?php if (isset($query_list_product)) {
      foreach ($query_list_product as $row) { ?>
        $("#showimagebtn<?= $row['productID'] ?>").on('click', function() {
          $("#showimage<?= $row['productID'] ?>").toggle();
        });
    <?php }
    } ?>
  </script>