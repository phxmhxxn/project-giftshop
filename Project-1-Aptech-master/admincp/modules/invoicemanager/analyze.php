<?php
include('../../config/connect.php');

if (isset($_POST['editinvoice'])) {
    try {
        $sql_update = $pdo->prepare("UPDATE `invoices` SET phone = ? , city = ? , `address` = ? , freeshipping = ? WHERE invoiceID = ? ;");
        $sql_update->bindParam(1, $_POST['phone'], PDO::PARAM_STR);
        $sql_update->bindParam(2, $_POST['city'], PDO::PARAM_STR);
        $sql_update->bindParam(3, $_POST['address'], PDO::PARAM_STR);
        $sql_update->bindParam(4, $_POST['freeshipping'], PDO::PARAM_STR);
        $sql_update->bindParam(5, $_POST['invoiceid'], PDO::PARAM_STR);
        $sql_update->execute();
    } catch (PDOException $exception) {
        echo "cannot update details of the invoice";
        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
    }
}

if (isset($_POST['invoiceaction'])) {

    try {
        $sql_update = $pdo->prepare("UPDATE `invoices` SET `stt` = ? WHERE invoiceID = ? ;");
        $sql_update->bindParam(1, $_POST['invoiceaction'], PDO::PARAM_STR);
        $sql_update->bindParam(2, $_POST['invoiceid'], PDO::PARAM_STR);
        $sql_update->execute();
    } catch (PDOException $exception) {
        echo "cannot update status of the invoice";
        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
    }

    if ($_POST['invoiceaction'] == 2) {
        try {
            $sql_update = $pdo->prepare("UPDATE `invoices` SET `shippingfee` = ? WHERE invoiceID = ? ;");
            $sql_update->bindParam(1, $_POST['shippingfee'], PDO::PARAM_STR);
            $sql_update->bindParam(2, $_POST['invoiceid'], PDO::PARAM_STR);
            $sql_update->execute();
        } catch (PDOException $exception) {
            echo "cannot update status of the invoice";
            header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
        }
    }
    if ($_POST['invoiceaction'] == 4) {
        try {
            $sql_update = $pdo->prepare("UPDATE `invoices` SET `shippingfee` = `shippingfee` + ? , `buyerpaid` = ? WHERE invoiceID = ? ;");
            $sql_update->bindParam(1, $_POST['shippingfee'], PDO::PARAM_STR);
            $sql_update->bindParam(2, $_POST['buyerpaid'], PDO::PARAM_STR);
            $sql_update->bindParam(3, $_POST['invoiceid'], PDO::PARAM_STR);
            $sql_update->execute();
        } catch (PDOException $exception) {
            echo "cannot update status of the invoice";
            header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
        }
    }
    if ($_POST['invoiceaction'] == 1 || $_POST['invoiceaction'] == 4) {
        try {

            $sql_list_invoice = $pdo->prepare("SELECT * FROM billing WHERE invoiceID = ? ");
            $sql_list_invoice->bindParam(1, $_POST['invoiceid'], PDO::PARAM_STR);
            $sql_list_invoice->execute();
            $query_list_invoice = $sql_list_invoice->fetchAll(PDO::FETCH_ASSOC);

            foreach ($query_list_invoice as $row) {
                if ($row['stt'] == 1) {
                    $stmt = $pdo->prepare('UPDATE `products` SET `quantity` = `quantity` + ? WHERE `products`.`productID` = ?');
                    $stmt->bindParam(1, $row['quantity'], PDO::PARAM_STR);
                    $stmt->bindParam(2, $row['productID'], PDO::PARAM_STR);
                    $stmt->execute();
                }
            }
        } catch (PDOException $exception) {
            echo "cannot update status of the invoice";
            header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
        }
    }
    if ($_POST['invoiceaction'] == 3) {
        try {

            $sql_list_invoice = $pdo->prepare("SELECT * FROM billing WHERE invoiceID = ? ");
            $sql_list_invoice->bindParam(1, $_POST['invoiceid'], PDO::PARAM_STR);
            $sql_list_invoice->execute();
            $query_list_invoice = $sql_list_invoice->fetchAll(PDO::FETCH_ASSOC);

            foreach ($query_list_invoice as $row) {

                $stmt = $pdo->prepare('UPDATE `billing` SET `stt` = 1 WHERE productID = ? AND invoiceID = ?');
                $stmt->bindParam(1, $row['productID'], PDO::PARAM_STR);
                $stmt->bindParam(2, $_POST['invoiceid'], PDO::PARAM_STR);
                $stmt->execute();
            }
        } catch (PDOException $exception) {
            echo "cannot update status of the invoice";
            header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
        }
    }
}

if (isset($_GET['removeitem'])) {
    try {
        $sql_update = $pdo->prepare("DELETE FROM billing WHERE id = ?");
        $sql_update->bindParam(1, $_GET['removeitem'], PDO::PARAM_STR);
        $sql_update->execute();

        $stmt = $pdo->prepare('UPDATE `products` SET `quantity` = `quantity` + ? WHERE `products`.`productID` = ?');
        $stmt->bindParam(1, $_GET['quantity'], PDO::PARAM_STR);
        $stmt->bindParam(2, $_GET['productid'], PDO::PARAM_STR);
        $stmt->execute();


        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_GET['invoiceid']);
        die();
    } catch (PDOException $exception) {
        echo "cannot delete item";
        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_GET['invoiceid']);
    }
}

if (isset($_POST['additem'])) {
    try {
        $stmt = $pdo->prepare('SELECT * FROM products WHERE productID = ? LIMIT 1');
        $stmt->bindParam(1, $_POST['additem'], PDO::PARAM_STR);
        $stmt->execute();
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $exception) {
        echo "product is not exist!";
        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
    }
    if (!empty($products)) {

        foreach ($products as $product) {
            if ($_POST['quantity'] <= $product['quantity']) {


                try {
                    $stmt = $pdo->prepare('UPDATE `products` SET `quantity` = `quantity` - ? WHERE `products`.`productID` = ?');
                    $stmt->bindParam(1, $_POST['quantity'], PDO::PARAM_STR);
                    $stmt->bindParam(2, $product['productID'], PDO::PARAM_STR);
                    $stmt->execute();

                    $stmt = $pdo->prepare('INSERT INTO `billing` '
                        . '(`invoiceID`, `ProductID`, `price` ,`quantity`)' .
                        ' VALUES (?, ?, ?, ?);');
                    $stmt->bindParam(1, $_POST['invoiceid'], PDO::PARAM_STR);
                    $stmt->bindParam(2, $product['productID'], PDO::PARAM_STR);
                    $stmt->bindParam(3, $product['price'], PDO::PARAM_STR);
                    $stmt->bindParam(4, $_POST['quantity'], PDO::PARAM_STR);
                    $stmt->execute();
                } catch (PDOException $exception) {
                    echo "cannot update items of the invoice";
                    header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
                }
            } else {

                echo "exceed amount of product in stock";
                header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
            }
        }
    } else {
        echo "
        <center>product not exist";
        header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
    }

    header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
}

echo 'done!';
header('Location:../../../admincp/index?action=invoicemanager&query=invoice&invoicenumber=' . $_POST['invoiceid']);
