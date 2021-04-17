<?php

if (isset($_POST['invoiceid'])) {
    $stmt = $pdo->prepare('UPDATE invoices SET `name` = ? ,`phone` = ? ,`address` = ?   WHERE invoiceID = ?');
    $stmt->bindParam(1, $_POST['name'], PDO::PARAM_STR);
    $stmt->bindParam(2, $_POST['phone'], PDO::PARAM_STR);
    $stmt->bindParam(3, $_POST['address'], PDO::PARAM_STR);
    $stmt->bindParam(4, $_POST['invoiceid'], PDO::PARAM_STR);
    $stmt->execute();
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_GET['id'] = $_POST['invoiceid'];
}

if (isset($_POST['cancel'])) {
    $stmt = $pdo->prepare('UPDATE invoices SET `stt` = 1 WHERE invoiceID = ?');
    $stmt->bindParam(1, $_POST['invoiceid'], PDO::PARAM_STR);
    $stmt->execute();
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $_GET['id'] = $_POST['invoiceid'];

    $stmt = $pdo->prepare("DELETE FROM invoice_noti WHERE invoiceID = ?");
    $stmt->bindParam(1, $_POST['invoiceid'], PDO::PARAM_STR);
    $stmt->execute();
}

$total = 0.0;
include 'navbar.php';

if (isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM billing WHERE invoiceID = ?');
    $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);
    $stmt->execute();
    $bills = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($bills)) {
        die('Invoice not exist!');
    }

    $stmt = $pdo->prepare('SELECT * FROM invoices WHERE invoiceID = ?');
    $stmt->bindParam(1, $_GET['id'], PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $invoice = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($invoice)) {
        die('Invoice not exist!');
    }
} else {
    die('Invoice not exist!');
}
?>  

<div class="justify-content-center text-center mx-auto col-10" style="width: 90%;">
<br>
    <table class="table-hover mx-auto">
        <form action="" method="post">
            <input type="text" name="invoiceid" id="" value="<?= $invoice[0]['invoiceID'] ?>" hidden> 
            <tr>
                <td>
                    <h4>Date of the order: <span><?= $invoice[0]['CreateDate'] ?></span></h4>
                </td>
            </tr>
            <tr>
                <td><input type="text" name="name" required value="<?= $invoice[0]['name'] ?>" hidden>
                    <h4>Recipient: <input type="text" name="name" required id="name" value="<?= $invoice[0]['name'] ?>" disabled></h4>
                </td>
            </tr>
            <tr>
                <td><input type="tel" name="phone" required pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" value="<?= $invoice[0]['phone'] ?>" hidden>
                    <h4>Phone: <input type="tel" name="phone" required pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" id="phone" value="<?= $invoice[0]['phone'] ?>" disabled></h4>
                </td>
            </tr>
            <tr>
                <td><input type="tel" name="address" required value="<?= $invoice[0]['address'] ?>" hidden>
                    <h4>Address: <input type="tel" name="address" required id="address" value="<?= $invoice[0]['address'] ?>" disabled></h4>
                </td>
            </tr>
            <tr>
                <td> 
                <h4>Status: <?php if ($invoice[0]['stt'] == 0) { ?>
                                        <a id="editinvoice" href="">EDIT</a> <input type="submit" id="confirm" hidden disabled> <br><br><h4>PENDING</h4>
                                        <input type="submit" name="cancel" onclick="return confirmcancel();" value="Cancel">
                                        <?php   } elseif ($invoice[0]['stt'] == 1) {
                                        echo 'CANCELLED';
                                    } elseif ($invoice[0]['stt'] == 2) {
                                        echo 'SHIPPING';
                                    } elseif ($invoice[0]['stt'] == 3) {
                                        echo 'DECLINED';
                                    } elseif ($invoice[0]['stt'] == 5) {
                                        echo 'COMPLETED';
                                    } elseif ($invoice[0]['stt'] == 4) {
                                        echo 'DECLINED';
                                    }
                                    ?></h4>
                </td>
            </tr>
        </form>
    </table>
    <p>
    <h4>List of goods:</h4>
    </p>
    <table class="table-bordered table-hover table-danger" style="width: 100%;text-align:center;border:solid 1px black; 
    ">
        <tr>
            <th style="border:solid 1px black;">
                <h4>Name</h4>
            </th>
            <th style="border:solid 1px black;">
                <h4>Price</h4>
            </th>
            <th style="border:solid 1px black;">
                <h4>Quantity</h4>
            </th>
        </tr>

        <?php foreach ($bills as $bill) : ?>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ?');
            $stmt->bindParam(1, $bill['productID'], PDO::PARAM_STR);
            $stmt->execute();
            $pro = $stmt->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <tr>

                <td style="border:solid 1px black;padding: 8px; flex-wrap:wrap ;width:60%">
                    <h4><a class="truncated" style="white-space:normal;" href="index?page=product&id=<?= $pro[0]['productID'] ?>">
                            <img src="imgs/<?= $pro[0]['img'] ?>" width="50" height="50" alt="<?= $pro[0]['name'] ?>">
                            <?= $pro[0]['name'] ?></a>
                    </h4>
                </td>
                <td style="border:solid 1px black;">
                    <h4>$<?= $bill['price'] ?></h4>
                    <?php $total += $bill['price'] * $bill['quantity']; ?>
                </td>
                <td style="border:solid 1px black;">
                    <h4><?= $bill['quantity'] ?></h4>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <p>
    <h4>Total cost: $<?= $total ?></h4>
    </p>
</div> 
<script>
    $('#editinvoice').on('click', function() {
        event.preventDefault();
        $('#name').removeAttr('disabled');
        $('#phone').removeAttr('disabled');
        $('#address').removeAttr('disabled');
        $('#confirm').removeAttr('hidden');
        $('#confirm').removeAttr('disabled');
    });
    
    function confirmcancel() {
    if (confirm("Do you really want to cancel order?")) {
       // do stuff
    } else {
      return false;
    }
}

</script>