<?php
if (isset($_GET['logoutadmin']) && $_GET['logoutadmin'] == 1) {
    unset($_SESSION['loginadmin']);
    header('Location:login');
}


function checkrole($username, $password)
{
    $pdo = pdo_connect_mysql();
    $stmt = $pdo->prepare("SELECT * FROM tbl_admin WHERE username = ? AND password = ? LIMIT 1;");
    $password1 = md5($password);
    $stmt->bindParam(1, $username, PDO::PARAM_STR);
    $stmt->bindParam(2, $password1, PDO::PARAM_STR);
    $stmt->execute();
    $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultSet as $row) {
        return $row['role'];
    }
}
$role = checkrole($_SESSION['loginadmin'], $_SESSION['passwordadmin']);



?>
(<?php if (isset($_SESSION['loginadmin'])) {
                echo $_SESSION['loginadmin'];
                if ($role == 0) echo ' - Master admin';
                if ($role == 1) echo ' - Product management';
                if ($role == 2) echo ' - Invoice management';
            } ?>)
<p><a href="index?logoutadmin=1">Log out </a></p>