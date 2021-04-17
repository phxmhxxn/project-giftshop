 

<?php
if (!isset($_SESSION['login1'])) {
    header('index?page=login');
}

include 'navbar.php'
?>

<?php
$stmt = $pdo->prepare('SELECT * FROM customer_user WHERE userID = ?');
$stmt->bindParam(1, $_SESSION['userID'], PDO::PARAM_STR);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);


$stmt = $pdo->prepare('SELECT invoiceID, CreateDate FROM invoices WHERE phone = ? OR userID = ? ORDER BY CreateDate DESC ');
$stmt->bindParam(1, $user['phone'], PDO::PARAM_STR);
$stmt->bindParam(2, $_SESSION['userID'], PDO::PARAM_STR);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$invoice = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmt = $pdo->prepare('SELECT * FROM view_customer WHERE phone = ? OR userID = ? ORDER BY CreateDate DESC ');
$stmt->bindParam(1, $user['phone'], PDO::PARAM_STR);
$stmt->bindParam(2, $_SESSION['userID'], PDO::PARAM_STR);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<div class="wrapper-user d-flex justify-content-center mx-auto" style="width:90%; min-height: 300px; flex-wrap:wrap">
    <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12 col-12 py-3 px-1">
        <table class="table table-danger table-hover table-bordered" style=" text-align: start; "> 
            <tr>
                <td colspan="2">
                    <h3 class="truncated">Informations</h3>
                </td>
            </tr> 
            <tr>
                <td>First Name</td>
                <td><?php echo $user['customerFname'] ?></td>
            </tr>
            <tr>
                <td>Family Name</td>
                <td><?php echo $user['customerLname'] ?></td>
            </tr>
            <tr>
                <td>Phone</td>
                <td><?php echo $user['phone'] ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><p class="truncated"><?php echo $user['email'] ?></p></td>
            </tr>
            <tr>
                <td>Address</td>
                <td><p class="truncated"><?php echo $user['address'] ?></p></td>
            </tr>
            <tr>
                <td><a class="truncated" style="white-space: wrap;" href="index?page=change">Edit</a>
                </td>
                <td><a class="truncated" style="white-space: wrap;" href="index?page=changePassword">Change Password</a></td>
            </tr>
        </table>
    </div>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 col-12 py-3 px-1">
        <table class="table table-warning table-hover table-bordered">
            <tr>
                <td colspan="2">
                    <h5>ALL THE ORDERS:</h5>
                </td>
            </tr>
            <?php foreach ($invoice as $i) :  ?>
                 
                <tr>
                    <td>
                        <a href="index?page=displayBills&id=<?= $i['invoiceID'] ?>"><?php echo $i['invoiceID'] ?></a>
                    </td>
                    <td><?php echo substr($i['CreateDate'],0,10) ?>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
    <div class="col-lg-5 col-md-12 col-sm-12 col-xs-12 col-12 py-3 px-1">
        <table class="table table-primary table-hover table-bordered">
            <tr>
                <td>
                    <h5>Product ever purchased:</h5>
                </td>
            </tr>
            <?php foreach ($products as $product) :  ?>
                 
                <tr>
                    <td><a href="index?page=product&id=<?= $product['productID'] ?>">
                    <img src="imgs/<?= $product['img']?>" width="30" height="30" alt="<?=$product['productNAME']?>">
                          - <?php echo $product['productNAME'] ?> - $<?=$product['price']?></a>
                    </td>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</div>