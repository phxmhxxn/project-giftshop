<?php
session_start();
include('config/connect.php');
if (isset($_POST['login'])) {
    $account = $_POST['username'];
    $stmt = $pdo->prepare("SELECT COUNT(*) AS numberOfUsers FROM tbl_admin WHERE username = ? AND password = ? LIMIT 1;");
    $password = md5($_POST['password']);
    $stmt->bindParam(1, $account, PDO::PARAM_STR);
    $stmt->bindParam(2, $password, PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute(); 
    $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultSet as $row) {
        $count = intval($row['numberOfUsers']);
        if ($count > 0) {
            $_SESSION['loginadmin'] = $account;
            $_SESSION['passwordadmin'] = $_POST['password'];
            header("Location:index");
        } else {
            echo '<script>alert("Account or password is incorrect,please re-enter.")</script>';
            header("Location:login");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <center>
    <div class="wrapper-login">
        <form action="" autocomplete="off" method="POST">
            <table class="table-login" border="1" style="text-align: center;">
                <tr>
                    <td colspan="2">
                        <h3>Login Admin</h3>
                    </td>
                </tr>
                <tr>
                    <td>UserName</td>
                    <td><input type="text" name="username"></td>
                </tr>
                <tr>
                    <td>PassWord</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="login" value="login"></td>
                </tr>
            </table>
        </form>
    </div>
    </center>
</body>

</html>