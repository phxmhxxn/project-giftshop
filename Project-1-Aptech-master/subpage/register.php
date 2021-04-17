<?php
 

$account = isset($_POST['username']) ? $_POST['username'] : '' ;
$phone = isset($_POST['phone']) ? $_POST['phone'] : '' ; 
$patternphone = "#(84|0[3|5|7|8|9])+([0-9]{8})\b#";
$patternacc = "#[a-zA-Z][a-zA-Z0-9]{4,30}#";   

if (isset($_POST['register'])) {
    if (preg_match($patternphone , $phone) == 1 && preg_match($patternacc, $account) == 1) {
    $conn = mysqli_connect('localhost', 'root', '');
    mysqli_select_db($conn, 'ProductDB');
    $s = "select * from customer_user where phone = '$phone'";
    $result = mysqli_query($conn, $s);
    $num = mysqli_num_rows($result);

    if ($num >= 1) {
        echo '<script>alert("This phone number already registered, please re-enter.")</script>';
        header("index?page=register");
    } else {
        $s = "select * from customer_user where username = '$account'";
        $result = mysqli_query($conn, $s);
        $num = mysqli_num_rows($result);
        if ($num >= 1) {
            echo '<script>alert("Username already exists, please re-enter.")</script>';
            header("index?page=register");
        } else {
            
            $password = md5($_POST['password']);
            $reg = "insert into customer_user(username,password,phone) value('$account','$password','$phone')";
            mysqli_query($conn, $reg);
            echo 'echo "<script>
            alert("Register successfully, login now");
            window.location.href="index?page=login&id='.$phone.'";
            </script>";
            ';
        }
    } 

}
    else {
        echo '<script>
        alert("your input is invalid");
        </script>
        ';
    }
}


include 'navbar.php';
?>
<div class="wrapper-login justify-content-center d-flex">
    <div class=" m-auto">
        <form action="" autocomplete="off" method="POST">
            <table class="table table-danger table-bordered" style="text-align: start; border-width:1 ">
                <tr>
                    <td colspan="2">
                        <h3>Register User</h3>
                    </td>
                </tr>
                <tr>
                    <td>Your phone number</td>
                    <td><input min="0" name="phone" type="tel" required pattern="(84|0[3|5|7|8|9])+([0-9]{8})\b" oninput=" this.setCustomValidity(this.validity.patternMismatch ? 
            'Please enter correct phone number.' : '');
                        if(this.checkValidity()) {document.getElementById('mobi').style.color = 'green'}
                        else  {document.getElementById('mobi').style.color = 'coral'}" value="<?=$phone?>">
                        <p id="mobi" style="display: inline; color: coral;">(10 digit number)</p>
                    </td>
                </tr>
                <tr>
                    <td>Your user name</td>
                    <td><input name="username" type="text" required pattern="[a-zA-Z]+[a-zA-Z0-9]{4,30}" oninput="
                    this.setCustomValidity(this.validity.patternMismatch ? 
            'UserID must have at least 5 characters and must start with a letter, others could be letters or numbers.' : '');
                        if(this.checkValidity()) {document.getElementById('fName').style.color = 'green'}
                        else {document.getElementById('fName').style.color = 'coral'}" value="<?=$account?>">
                        <p id="fName" style="display: inline; color: coral;">(5-30 chars, a-z and A-Z)</p>
                    </td>
                </tr>
                <tr>
                    <td>Your password</td>
                    <td><input id="input" name="password" type="password" pattern="{5,}" oninput="
                    this.setCustomValidity(this.validity.patternMismatch ? 
            'Password must have at least 6 characters.' : '');
                    if(this.checkValidity()) form.password2.pattern = this.value;" required></td>
                </tr>
                <tr>
                    <td>Confirm your password</td>
                    <td>
                        <input id="input" name="password2" type="password" oninput="this.setCustomValidity(this.validity.patternMismatch ? 
            'Please enter the same Password as above' : '');" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><input type="submit" name="register" value="register"></td>
                </tr>
            </table>
        </form>
    </div>
</div>