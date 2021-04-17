<div class="clear"></div>
<div class="main">
    <?php
    if (isset($_GET['action']) && $_GET['query']) {
        $action =  $_GET['action'];
        $query = $_GET['query'];
    } else {
        $action = '';
        $query = '';
    }


    if ($action == 'invoicemanager' && $query == 'list') {
        if ($role  == 0 || $role  == 2) {
            include("modules/invoicemanager/list.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'invoicemanager' && $query == 'invoice') {
        if ($role  == 0 || $role  == 2) {
            include("modules/invoicemanager/invoice.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'invoicemanager' && $query == 'edit') {
        if ($role  == 0 || $role  == 2) {
            include("modules/invoicemanager/edit.php");
        } else {
            echo "permission denied";
        }
    }

    if ($action == 'brandmanager' && $query == 'add') {
        if ($role  == 0 || $role  == 1) {
            include("modules/brandmanager/add.php");
            include("modules/brandmanager/list.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'brandmanager' && $query == 'edit') {
        if ($role  == 0 || $role  == 1) {
            include("modules/brandmanager/edit.php");
        } else {
            echo "permission denied";
        }
    }

    if ($action == 'categorymanager' && $query == 'add') { //trường hợp của quản lý danh mục sản phẩm
        if ($role  == 0 || $role  == 1) {
            include("modules/categorymanager/add.php");
            include("modules/categorymanager/list.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'categorymanager' && $query == 'edit') {
        if ($role  == 0 || $role  == 1) {
            include("modules/categorymanager/edit.php");
        } else {
            echo "permission denied";
        }
    }

    if ($action == 'maincategorymanager' && $query == 'add') { //trường hợp của quản lý danh mục sản phẩm
        if ($role  == 0 || $role  == 1) {
            include("modules/maincategorymanager/add.php");
            include("modules/maincategorymanager/list.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'maincategorymanager' && $query == 'edit') {
        if ($role  == 0 || $role  == 1) {
            include("modules/maincategorymanager/edit.php");
        } else {
            echo "permission denied";
        }
    }
    //trường hợp của quản lý sản phẩm
    elseif ($action == 'productmanage' && $query == 'add') {
        if ($role  == 0 || $role  == 1) {
            include("modules/productmanage/add.php");
            include("modules/productmanage/list.php");
        } else {
            echo "permission denied";
        }
    } elseif ($action == 'productmanage' && $query == 'edit') {
        if ($role  == 0 || $role  == 1) {
            include("modules/productmanage/edit.php");
        } else {
            echo "permission denied";
        }
    } elseif (!$action) {

        if ($role  == 0) {
            include("modules/dashboard.php");
        }
    }
    ?>
</div>