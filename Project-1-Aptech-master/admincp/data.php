<?php
include("config/connect.php");

$stmt = "Select * from invoice_noti";
$result = $pdo->query($stmt) ;

echo $result->rowCount();
// if ($result->num_rows > 0) {
//     while($row = $result->FETCH_ASSOC()) {
//         echo "id: ".$row['invoiceID']." - notification: ". $row['name'] ;
//     }
// }
// else {
//     echo "0 result" ;
// } 
$pdo= null;
?>