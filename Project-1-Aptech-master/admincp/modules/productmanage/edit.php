<?php
$sql_edit_product = $pdo->prepare("SELECT * FROM products WHERE productID = ? LIMIT 1 ");
$sql_edit_product->bindParam(1, $_GET['id'], PDO::PARAM_STR);
$sql_edit_product->execute();
$query_edit_product = $sql_edit_product->fetchAll(PDO::FETCH_ASSOC);


$sql_categories = $pdo->prepare("SELECT * FROM categories ORDER BY categoryID DESC");
$sql_categories->execute();
$query_categories = $sql_categories->fetchAll(PDO::FETCH_ASSOC);
?>
<h2>EDIT PRODUCT</h2>
<table class="table-bordered  table-secondary table-hover" width=60% style="border-collapse: collapse">
  <?php
  foreach ($query_edit_product as $row) {
  ?>
    <form method="POST" action="modules/productmanage/analyze?id=<?php echo $row['productID'] ?>" enctype="multipart/form-data">

      <tr>
        <td class="text-right pr-2">PRODUCT NAME</td>
        <td><input type="text" name="nameproduct" value="<?php echo $row['name'] ?>"></td>
      </tr>
      <tr>
        <td class="text-right pr-2">PRODUCT CODE</td>
        <td><input disabled type="text" name="code" value="<?php echo $row['productID'] ?>"></td>
      </tr>
      <tr>
        <td class="text-right pr-2">PRICE</td>
        <td><input type="text" name="price" value="<?php echo $row['price'] ?>"></td>
      </tr>
      <tr>
      <tr>
        <td class="text-right pr-2">RETAIL PRICE</td>
        <td><input type="text" name="rrp" value="<?php echo $row['rrp'] ?>"></td>
      </tr>
      <tr>
        <td class="text-right pr-2">QUANTITY</td>
        <td>
          <input hidden type="number" name="quantity" value="<?php echo $row['quantity'] ?>">
          <input disabled type="number" value="<?php echo $row['quantity'] ?>">
          <input id="button1" type="button" value="ADD" class="btn btn-danger btn-hover">
          <div id="add" style="display: none;">
            Enter amount add to stock :
            <input type="number" name="addamount" value="0">
          </div>
        </td>
      </tr>
      <tr>
        <td>
        </td>
        <td>
        </td>
      </tr>
      <tr>
        <td class="text-right pr-2">IMAGE</td>
        <td><input type="file" name="image" accept="image/*"  value="">
          <img src="../../../imgs/<?php echo $row['img'] ?>" width="200px">
        </td>
      </tr>
      <tr>
        <td class="text-right pr-2">PRODUCT DETAILS FILE</td>
        <td><input type="file" name="file" accept=".doc,.docx,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,.txt">
        </td>
      </tr>
      <tr>
        <td class="text-right pr-2">DESCRIPTION</td>
        <td><textarea rows="5" name="description" style="width: 500px;"><?php echo $row['desci'] ?></textarea></td>
      </tr>
      <tr>
        <td class="text-right pr-2">CATEGORY</td>
        
        <td><select name="category">
            <?php
            foreach ($query_categories as $row_categories) {

              if ($row_categories['categoryID'] == $row['categoryID']) {
            ?>
              <option selected value="<?php echo $row_categories['categoryID'] ?>"><?php echo $row_categories['name'] ?></option>
            <?php
            } else { ?>
              <option value="<?php echo $row_categories['categoryID'] ?>"><?php echo $row_categories['name'] ?></option>
<?php
            }}
            ?>
          </select></td>
 
      </tr>

      <tr>
        <td class="text-right pr-2">BRAND</td>
        <td>
          <select name="brand">
            <?php
            $sql_brands = $pdo->prepare("SELECT * FROM brands ORDER BY brandID DESC");
            $sql_brands->execute();
            $query_brands = $sql_brands->fetchAll(PDO::FETCH_ASSOC);
            foreach ($query_brands as $row_brands) {

              if ($row_brands['brandID'] == $row['brandID']) {
            ?>
              <option selected value="<?php echo $row_brands['brandID'] ?>"><?php echo $row_brands['name'] ?></option>
            <?php
            } else { ?>
              <option value="<?php echo $row_brands['brandID'] ?>"><?php echo $row_brands['name'] ?></option>
<?php
            }}
            ?>

          </select>
        </td>
      </tr>

      <tr>
        <td class="text-right pr-2">STATUS</td>
        <td>
          <select name="stt">
            <?php
            if ($row['stt'] == 1) {
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
        <td class="text-center" colspan="2"><input class="btn btn-default" class="text-center" type="submit" name="editproduct" value="SAVE"></td>
      </tr>
    </form>
  <?php
  }
  ?>
</table>
<script>
        $("#button1").on('click', function() {
            $("#add").toggle();
        });
</script>
