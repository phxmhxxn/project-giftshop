<?php
if (isset($_GET['declineitemid'])) {
  $stmt = $pdo->prepare("UPDATE billing SET stt = 1 WHERE invoiceID = ? AND productID = ?");
  $stmt->bindParam(1, $_GET['invoicenumber'], PDO::PARAM_STR);
  $stmt->bindParam(2, $_GET['declineitemid'], PDO::PARAM_STR);
  $stmt->execute();
}

$sql_edit_product = $pdo->prepare("SELECT * FROM invoices WHERE invoiceID = ? LIMIT 1 ");
$sql_edit_product->bindParam(1, $_GET['invoicenumber'], PDO::PARAM_STR);
$sql_edit_product->execute();
$query_edit_product = $sql_edit_product->fetchAll(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare("DELETE FROM invoice_noti WHERE invoiceID = ?");
$stmt->bindParam(1, $_GET['invoicenumber'], PDO::PARAM_STR);
$stmt->execute();
?>
<p>DETAILS</p>
<?php
foreach ($query_edit_product as $row_invoice) {
?>
  Invoice Number : <?php echo $row_invoice['invoiceID'] ?>
  <br>
  Created date : <?php echo $row_invoice['CreateDate'] ?>
  <br>
  Customer name : <?php echo $row_invoice['name'] ?>
  <br>
  Phone number : <?php echo $row_invoice['phone'] ?>
  <br>
  Address : <?php echo $row_invoice['city'] ?> ---- <?php echo $row_invoice['address'] ?>
  <br>
  Freeshipping? : <?php if ($row_invoice['freeshipping'] == 0) {
                    echo 'NO';
                  }
                  if ($row_invoice['freeshipping'] == 1) {
                    echo 'YES';
                  } ?>
  <br>
  Status : <?php if ($row_invoice['stt'] == 0) {
              echo 'PENDING';
            }
            if ($row_invoice['stt'] == 1) {
              echo 'CANCELLED';
            }
            if ($row_invoice['stt'] == 2) {
              echo 'SHIPPING';
            }
            if ($row_invoice['stt'] == 3) {
              echo 'DECLINED - SHIPPING BACK';
            }
            if ($row_invoice['stt'] == 4) {
              echo 'SHIPPED BACK';
            }
            if ($row_invoice['stt'] == 5) {
              echo 'COMPLETED';
            }
            if ($row_invoice['stt'] == 6) {
              echo 'PARTIALLY SHIPPED';
            }  ?>
  <br>
  <?php if ($row_invoice['stt'] == 0) {
    echo '<a href="/admincp/index?action=invoicemanager&query=edit&invoiceid=' . $row_invoice["invoiceID"] . '" >EDIT</a>';
  }
  ?>
  <?php
  $sql_list_item = $pdo->prepare("SELECT * FROM billing WHERE invoiceID = ? ");
  $sql_list_item->bindParam(1, $_GET['invoicenumber'], PDO::PARAM_STR);
  $sql_list_item->execute();
  $sql_list_items = $sql_list_item->fetchAll(PDO::FETCH_ASSOC);
  ?>
  <div>
    <h2>Item list</h2>
    <table class="table-bordered table-hover" style="width:90%">
      <tr>
        <th>Id</th>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>TotalCost</th>
        <th></th>
      </tr>
      <?php
      $i = 0;
      $subtotal = 0;
      foreach ($sql_list_items as $row) {
        $i++;
      ?>
        <tr>
          <td><?php echo $i ?></td>
          <td><?php echo $row['productID'] ?></td>
          <?php
          $sql_select = $pdo->prepare("SELECT * FROM products ORDER BY products.productID");
          $sql_select->execute();
          $query_select = $sql_select->fetchAll(PDO::FETCH_ASSOC);
          foreach ($query_select as $product) {
            if ($product['productID'] == $row['productID']) {
              echo '<td>' . $product['name'] . '</td>';
              break;
            }
          }
          ?>
          <td><?php echo $row['price'] ?></td>
          <td><?php echo $row['quantity'] ?></td>
          <td><?php if ($row['stt'] == 0) {
                $total = $row['price'] * $row['quantity'];
                $subtotal = $subtotal + $total;
              }
              echo $row['price'] * $row['quantity'] ?></td>
          <?php
          if ($row['stt'] == 1 && ($row_invoice['stt'] == 2 || $row_invoice['stt'] == 4 || $row_invoice['stt'] == 3 || $row_invoice['stt'] == 6)) { ?>
            <td> DECLINED </td>

          <?php }
          if ($row_invoice['stt'] == 2 && $row['stt'] == 0) { ?>
            <td> <a onclick="return confirm('Do you confirm to decline this item?');" href="index?action=invoicemanager&query=invoice&invoicenumber=<?= $row_invoice['invoiceID'] ?>&declineitemid=<?= $row['productID'] ?>">decline</a> </td>

          <?php } ?>
          <?php

          $stmt = $pdo->prepare("SELECT * FROM `invoices` WHERE invoiceID = ? LIMIT 1");
          $stmt->bindParam(1, $row_invoice['invoiceID'], PDO::PARAM_STR);
          $stmt->execute();
          $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
          foreach ($invoices as $invoice) {
            $shippingfee = $invoice['shippingfee'];
            if ($invoice['stt'] == 0 || $invoice['stt'] == 1) {
          ?>


              <td><a onclick="return confirm('Do you really want to remove this item?');" href="modules/invoicemanager/analyze?removeitem=<?php echo $row['id'] ?>&invoiceid=<?= $row_invoice['invoiceID'] ?>&productid=<?= $row['productID'] ?>&quantity=<?= $row['quantity'] ?>">remove</a>
              </td> <?php } ?>
        </tr>
    <?php
          }
        }
    ?>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Shipping fee</td>
      <td><?= $shippingfee ?></td>
    </tr>
    <tr>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td>Subtotal</td>
      <td><?= $subtotal + $shippingfee ?></td>
    </tr>
    <?php

    $stmt = $pdo->prepare("SELECT * FROM `invoices` WHERE invoiceID = ? LIMIT 1");
    $stmt->bindParam(1, $row_invoice['invoiceID'], PDO::PARAM_STR);
    $stmt->execute();
    $invoices = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($invoices as $invoice)

      if ($invoice['stt'] == 0) {
    ?>
      <tr>
        <td>
          <div><input id="button" type="button" value="ADD ITEM" class="btn btn-danger btn-hover" value="click me">
            <div id="addproduct" style="display: none;">
              <br>
              <form method="POST" action="modules/invoicemanager/analyze?action=additem" enctype="multipart/form-data">

                <table class="table-bordered table-secondary table-hover" width=60% style="border-collapse: collapse">
                  <tr>
                    <td class="text-right pr-2">PRODUCT ID</td>
                    <td>
                      <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>

                      <input type="text" name="additem" style="width: max-content;">
                    </td>
                  </tr>
                  <tr>

                    <td class="text-right pr-2">QUANTITY</td>
                    <td><input type="number" name="quantity" min="1" value="1"></td>
                  </tr>
                  <tr>
                    <td></td>
                    <td><input type="submit" value="add"></td>
                  </tr>
                </table>
              </form>
            </div>
          </div>
        </td>
      </tr>
      <tr>
        <td></td>
        <td></td>
        <td>
          <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Do you really want to cancel this invoice?');">
            <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
            <input type="text" name="invoiceaction" value="1" hidden>
            <input type="submit" value="Cancel">
          </form>
        </td>
        <td>
          <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Confirm to shipping?');">
            <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
            <input type="text" name="invoiceaction" value="2" hidden>
            <input type="submit" value="Confirm">
            Shipping fee:
            <input type="number" step="0.01" id="shippingfee" name="shippingfee" required oninput="calctotal()">
          </form>
        </td>
        <td>SubTotal</td>
        <td id="subtotal"></td>
      </tr>
    </table>

  <?php
      }
    if ($invoice['stt'] == 3 || $invoice['stt'] == 6) { ?>
    <td></td>
    <td></td>
    <td style="text-align:right">
      <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Do you confirm products that was shipped back?');">
        <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
        <input type="text" name="invoiceaction" value="4" hidden>
        <input type="submit" value="Shipped back confirm">
        Shipping back fee:
    </td>
    <td>

      <input type="number" id="shippingfee"  step="0.01"  name="shippingfee" value="0.0" required >
      buyer paid:<input type="number" step="0.01" id="buyerpaid" name="buyerpaid" value="0.0" required >
    <td id="shippedfee" hidden></td>
    </form>
    </td>
    <td>profit</td>
    <td id="subtotal"></td>
    </table>
  <?php }
    if ($invoice['stt'] == 2) { ?>
    <table>
      <td>
        <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Do you confirm the recipient decline order?');">
          <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
          <input type="text" name="invoiceaction" value="3" hidden>
          <input type="submit" value="Declined" <?php

                                                foreach ($sql_list_items as $row) {
                                                  if ($row['stt'] == 1) {
                                                    echo 'hidden';
                                                  }
                                                } ?>>
        </form>
      </td>
      <td>
        <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Do you confirm the PARTIALLY SHIPPED order?');">
          <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
          <input type="text" name="invoiceaction" value="6" hidden>
          <input type="submit" value="PARTIALLY SHIPPED">
        </form>
      </td>
      <td>
        <form action="modules/invoicemanager/analyze" method="post" onsubmit="return confirm('Confirm the order is complete?');">
          <input type="text" name="invoiceid" value="<?= $row_invoice['invoiceID'] ?>" hidden>
          <input type="text" name="invoiceaction" value="5" hidden>
          <input type="submit" value="Completed" <?php

                                                  foreach ($sql_list_items as $row) {
                                                    if ($row['stt'] == 1) {
                                                      echo 'hidden';
                                                    }
                                                  } ?>>
        </form>
      </td>
    </table>
<?php }
  }
?>
</table>

<script>
  $("#button").on('click', function() {
    $("#addproduct").toggle();
  });
</script>