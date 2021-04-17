<?php

date_default_timezone_set('Asia/Ho_Chi_Minh'); 
$startdate = (isset($_GET['startdate']) && $_GET['startdate'] != '') ? $_GET['startdate'] : date('Y-m-d', strtotime("-1 week"));
$enddate = (isset($_GET['enddate']) && $_GET['enddate'] != '') ? $_GET['enddate'] : date('Y-m-d');

$sql_list_invoice = $pdo->prepare("SELECT * FROM invoices WHERE stt = 0 AND invoices.CreateDate between  DATE_ADD(?,INTERVAL 0 DAY) AND DATE_ADD(?,INTERVAL 1 DAY) ORDER BY CreateDate DESC");
$sql_list_invoice->bindParam(1, $startdate, PDO::PARAM_STR);
$sql_list_invoice->bindParam(2, $enddate, PDO::PARAM_STR);
$sql_list_invoice->execute();
$query_list_invoice = $sql_list_invoice->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['filter'])) {
  if ($_GET['filter'] == 7) {
    $sql_list_invoice = $pdo->prepare("SELECT * FROM invoices WHERE (stt = 2 OR stt = 3 OR stt = 4 OR stt = 5 OR stt = 6) AND invoices.CreateDate between  DATE_ADD(?,INTERVAL 0 DAY) AND DATE_ADD(?,INTERVAL 1 DAY) ORDER BY CreateDate DESC");
    $sql_list_invoice->bindParam(1, $startdate, PDO::PARAM_STR);
    $sql_list_invoice->bindParam(2, $enddate, PDO::PARAM_STR);
    $sql_list_invoice->execute();
    $query_list_invoice = $sql_list_invoice->fetchAll(PDO::FETCH_ASSOC);
  } else {
    $sql_list_invoice = $pdo->prepare("SELECT * FROM invoices WHERE stt = ? AND invoices.CreateDate between DATE_ADD(?,INTERVAL 0 DAY) AND DATE_ADD(?,INTERVAL 1 DAY) ORDER BY CreateDate DESC");
    $sql_list_invoice->bindParam(1, $_GET['filter'], PDO::PARAM_STR);
    $sql_list_invoice->bindParam(2, $startdate, PDO::PARAM_STR);
    $sql_list_invoice->bindParam(3, $enddate, PDO::PARAM_STR);
    $sql_list_invoice->execute();
    $query_list_invoice = $sql_list_invoice->fetchAll(PDO::FETCH_ASSOC);
  }
}

$stmt = $pdo->prepare("SELECT * FROM invoice_noti");
$stmt->execute();
$invoice_notis = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<link rel="stylesheet" href=".././style.css">

<table style="width: 100%; background-color:rgb(104, 10, 38); color:white; height:50px">
  <tr>
    <td style="width: 15%; text-align:center ; position:relative"> New invoices:
      <i class="fas fa-bell txt-color-black" style="position:relative"><span id="noti" style="top: -5px;left: 10px ;position: absolute;"></span></i>
    </td>
    <td style="width: 85%;">
      <form action="">
        <input type="text" name="action" value="invoicemanager" hidden>
        <input type="text" name="query" value="list" hidden>
        <button type="submit" class="btn btn-danger" name="filter" value="0">Pending</button>
        <button type="submit" class="btn btn-danger" name="filter" value="2">Shipping</button>
        <button type="submit" class="btn btn-danger" name="filter" value="3">Declined</button>
        <button type="submit" class="btn btn-warning" name="filter" value="1">Canceled</button>
        <button type="submit" class="btn btn-warning" name="filter" value="6">PARTIALLY SHIPPED</button>
        <button type="submit" class="btn btn-warning" name="filter" value="4">Shipped back</button>
        <button type="submit" class="btn btn-success" name="filter" value="5">Completed</button>
        <button type="submit" class="btn btn-info" name="filter" value="7">Total revenue</button>
      </form>

    </td>
  </tr>
</table>
<script>
  function loadDoc() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("noti").innerHTML = this.responseText;
        var lastResponse = document.getElementById("noti").innerHTML;
      }
    };
    xhttp.open("GET", "data.php", true);
    xhttp.send();

    setInterval(function() {
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          var lastResponse = document.getElementById("noti").innerHTML;
          document.getElementById("noti").innerHTML = this.responseText;
          if (document.getElementById("noti").innerHTML !== lastResponse) {
            var audio = new Audio('good_notification.mp3')
            audio.play()
          }
        }
      };
      xhttp.open("GET", "data.php", true);
      xhttp.send();

    }, 500)


  }
  loadDoc();
</script>
<div style="height: 50vw">
  <br>
  <h2>Invoice List</h2>
  <form action="" method="get">
    <?php if (isset($_GET['filter'])) echo '<input type="text" name="filter" value="' . $_GET['filter'] . '" hidden>' ?>
    <input type="text" name="action" value="invoicemanager" hidden>
    <input type="text" name="query" value="list" hidden>

    from <input type="date" name="startdate" id="startdate" max="" onchange="updatedate1();">
    to <input type="date" name="enddate" id="enddate" min="" onchange="updatedate2();"> <input type="submit">

    <script>
      function updatedate1() {
        var firstdate = document.getElementById("startdate").value;
        document.getElementById("enddate").setAttribute("min", firstdate);
      }

      function updatedate2() {
        var lastdate = document.getElementById("enddate").value;
        document.getElementById("startdate").setAttribute("max", lastdate);
      }

      $(document).ready(function() {
        $("#startdate").val("<?php echo $startdate ?>");
        $("#enddate").val("<?php echo $enddate ?>");
      });
    </script>
  </form>
  <br>
  <table class="table-warning table-hover" border="1" style="width:90% ; font-size:14px">
    <thead class="bg-info">
      <tr class="my-2">
        <th>ID</th>
        <th>Invoice Number</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Created date</th>
        <th>FREESHIPPING?</th>
        <th>Shipping Fee</th>
        <th>Pre-calc-Profit</th>
        <th>Status</th>
        <?php
      if (isset($_GET['filter']) && ($_GET['filter'] == 7 || $_GET['filter'] == 4) ){ ?>
      <th>Buyer Paid</th>
      <?php } ?>
        <th></th>        
      </tr>
    </thead>
    <?php
    $i = 0;
    $totalcost = 0.00;
    $totalshippingfee = 0.00;
    $totalbuyerpaid = 0.00;
    foreach ($query_list_invoice as $row) {

      $totalbuyerpaid += $row['buyerpaid'];
      $sql_list_items = $pdo->prepare("SELECT * FROM view_customer WHERE invoiceID = ?");
      $sql_list_items->bindParam(1, $row['invoiceID'], PDO::PARAM_STR);
      $sql_list_items->execute();
      $sql_list_items = $sql_list_items->fetchAll(PDO::FETCH_ASSOC);
      $totalcostbilling = 0.00;
      foreach ($sql_list_items as $item) {
        if ($item['itemstt'] == 0) {
          $totalcostbilling += $item['price'] * $item['quantity'];
        }
      }
      if ($row['freeshipping'] == 1 || $row['stt'] == 4) {
        $totalshippingfee += $row['shippingfee'];
      }
      if ($row['stt'] == 5 || $row['stt'] == 4) {
        $totalcost += $totalcostbilling;
      }
      $i++;
    ?>
      <tr>
        <td><?php echo $i ?></td>
        <td><?php echo $row['invoiceID'];
            foreach ($invoice_notis as $invoice_noti) {
              if ($row['invoiceID'] == $invoice_noti['invoiceID'])
                echo "<a href='?action=invoicemanager&query=invoice&invoicenumber=" . $row['invoiceID'] . "' style='color: blue;'> NEW</a>";
            }
            ?> </td>
        <td><?php echo $row['name'] ?></td>
        <td><?php echo $row['phone'] ?></td>
        <td><?php echo $row['city'] ?></td>
        <td><?php echo $row['CreateDate'] ?></td>
        <td><?php if ($row['freeshipping'] == 0) {
              echo 'NO';
            }
            if ($row['freeshipping'] == 1) {
              echo 'YES';
            }
            ?>
        </td>
        <td <?php
            if (($row['freeshipping'] == 1 || $row['stt'] == 4) && $row['shippingfee'] > 0) {
              echo 'class="bg-danger" style=" color:white"';
            }
            if (($row['freeshipping'] == 0 && $row['stt'] == 3) && $row['shippingfee'] > 0) {
              echo 'class="bg-warning" style=" color:black"';
            }
            ?>>$<?php echo $row['shippingfee'] ?></td>
        <td <?php
            if ($row['stt'] == 5 || $row['stt'] == 4 || $row['stt'] == 6) {
              echo 'class="bg-success" style="color:white"';
            } ?>>
          $<?php echo $totalcostbilling ?></td>
        <td><?php if ($row['stt'] == 0) {
              echo 'PENDING';
            } elseif ($row['stt'] == 1) {
              echo 'CANCELLED';
            } elseif ($row['stt'] == 2) {
              echo 'SHIPPING';
            } elseif ($row['stt'] == 3) {
              echo 'DECLINED - SHIPPING BACK';
            } elseif ($row['stt'] == 5) {
              echo 'COMPLETED';
            } elseif ($row['stt'] == 4) {
              echo 'SHIPPED BACK';
            } elseif ($row['stt'] == 6) {
              echo 'PARTIALLY SHIPPED';
            }
            ?>
        </td> <?php
      if (isset($_GET['filter']) && ($_GET['filter'] == 7 || $_GET['filter'] == 4)) { ?>
      <td <?php if ($row['buyerpaid'] != 0) echo 'class="bg-success" style="color:white"' ?>><?=$row['buyerpaid']?> </td>
      <?php } ?>
        <td>
          <a href="?action=invoicemanager&query=invoice&invoicenumber=<?php echo $row['invoiceID'] ?>">Details</a>
        </td>

      </tr>

    <?php
    } ?>
  </table>
  <br><br>

  <?php
  if (isset($_GET['filter']) && $_GET['filter'] == 7) {
  ?>
    Total shipping fee that the shop had to paid: -$<?= $totalshippingfee ?>
    <br>
    Total shipping fee that the buyer paid for shipping back: +$<?= $totalbuyerpaid ?>
    <br>
    Total profit from selling: +$<?= $totalcost ?>
    <br>
    Subtotal profit: $<?= $totalcost - $totalshippingfee + $totalbuyerpaid ?>
  <?php } ?>

</div>