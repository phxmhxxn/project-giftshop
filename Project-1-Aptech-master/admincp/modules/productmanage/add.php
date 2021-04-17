<br>
<div><input id="button" type="button" value="ADD NEW PRODUCT" class="btn btn-success btn-hover" value="click me">
  <div id="addproduct" style="display: none;">
    <h2>ADD NEW PRODUCT</h2>
    <br>
    <form method="POST" action="modules/productmanage/analyze" enctype="multipart/form-data">

      <table class="table-bordered table-secondary table-hover" width=60% style="border-collapse: collapse">
        <tr>
          <td class="text-right pr-2">PRODUCT NAME</td>
          <td><input type="text" name="nameproduct" style="width: max-content;" required></td>
        </tr>
        <tr>
          <td class="text-right pr-2">PRICE</td>
          <td><input type="text" name="price" required></td>
        </tr>
        <tr>
          <td class="text-right pr-2">QUANTITY</td>
          <td><input type="text" name="quantity" required></td>
        </tr>
        <tr>
          <td class="text-right pr-2">IMAGE</td>
          <td><input type="file" name="image" accept="image/*" required></td>
        </tr>
        <tr>
          <td class="text-right pr-2">PRODUCT DETAILS FILE</td>
          <td><input type="file" name="file" accept=".doc,.docx,.txt"></td>
        </tr>
        <tr>
          <td class="text-right pr-2">DESCRIPTION</td>
          <td><textarea style="width: 500px;" rows="5" name="description"></textarea></td>
        </tr>
        <tr>
          <td class="text-right pr-2">CATEGORY</td>
          <td>
            <select name="category">
              <?php
              $sql_categories = $pdo->prepare("SELECT * FROM categories ORDER BY categoryID DESC");
              $sql_categories->execute();
              $query_categories = $sql_categories->fetchAll(PDO::FETCH_ASSOC);
              foreach ($query_categories as $row_categories) {
              ?>
                <option value="<?php echo $row_categories['categoryID'] ?>"><?php echo $row_categories['name'] ?></option>
              <?php
              }
              ?>
            </select>
          </td>
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
              ?>
                <option value="<?php echo $row_brands['brandID'] ?>"><?php echo $row_brands['name'] ?></option>
              <?php
              }
              ?>
            </select>
          </td>
        </tr>

        <tr>
          <td class="text-right pr-2">STATUS</td>
          <td>
            <select name="stt">
              <option value="0" default>DISABLE</option>
              <option value="1">ACTIVE</option>
            </select>
          </td>
        </tr>
        <tr>
          <td class="text-center" colspan="2"><input class="btn btn-danger btn-hover" type="submit" name="addproduct" value="ADD"></td>
        </tr>
      </table>
    </form>
  </div>
</div>
<script>
  $("#button").on('click', function() {
    $("#addproduct").toggle();
  });
</script>