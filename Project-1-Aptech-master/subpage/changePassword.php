<?php
if (!isset($_SESSION['login1'])) {
    header('index?page=login');
}

include 'navbar.php'
?>

<?php
    $stmt = $pdo->prepare('SELECT * FROM customer_user WHERE username = ?');
    $stmt->bindParam(1, $_SESSION['login1'], PDO::PARAM_STR);
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<?php

    if (isset($_POST['update'])){
        $new_password=md5($_POST['password1']);
        $old_password = md5($_POST['password']);
        if ($old_password != $new_password) {

        $stmt = $pdo->prepare("SELECT * FROM customer_user WHERE `username` = ? AND `password` = ? LIMIT 1;");
        $stmt->bindParam(1, $user['username'], PDO::PARAM_STR);
        $stmt->bindParam(2, $old_password, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();
        $resultSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($resultSet)) {
            echo '<script>alert("Wrong old password.")</script>';
        }
        else{
            $stmt = $pdo->prepare('UPDATE customer_user SET password=?  WHERE username = ?');
            $stmt->bindParam(1, $new_password, PDO::PARAM_STR);
            $stmt->bindParam(2, $user['username'], PDO::PARAM_STR);
            $stmt->execute();
            echo '<script>alert("Change password successfully.")</script>';
        }
    }
    else {
        echo '<script>alert("Your new password needs to be different from your current password.")</script>';}
    }
?>
<div class="wrapper-login justify-content-center d-flex">
            <div class=" m-auto">
        <form action="" autocomplete="off" method="POST">
            <table class="table table-danger table-bordered" style="text-align: center; border-width:1 ">
                <tr>
                    <td colspan="2">
                        <h3>Change Password</h3>
                    </td>
                </tr>
                <tr>
                    <td>Current password</td>
                    <td>
                        <input type="password" name="password"
                        pattern="{5,}" oninput="
                    this.setCustomValidity(this.validity.patternMismatch ? 
            'Password must have at least 6 characters.' : '');
                    if(this.checkValidity()) form.password2.pattern = this.value;" required>
                       
                    </td>
                </tr>
                <tr>
                    <td>New password</td>
                    <td><input id="input" name="password1" type="password" pattern="{5,}" oninput="
                    this.setCustomValidity(this.validity.patternMismatch ? 
            'Password must have at least 6 characters.' : '');
                    if(this.checkValidity()) form.password2.pattern = this.value;" required></td>
                </tr>
                <tr>
                    <td>Confirm your new password</td>
                    <td>
                        <input id="input" name="password2" type="password" oninput="this.setCustomValidity(this.validity.patternMismatch ? 
            'Please enter the same Password as above' : '');" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="update" value="update"></td>
                </tr>
            </table>
        </form></div>
    </div> 