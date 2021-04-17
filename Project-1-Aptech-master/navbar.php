<nav class="navbar navbar-expand-lg bg-pink navbar-dark Vegur sticky-top p-0 my-transparent" style="width:100%; font-size: 40px ; top:150px ; ">
    <button style="border-width: 0px" class="navbar-toggler custom-toggler navbar navbar-expand-lg navbar-dark Vegur  p-0 sticky-top  " type="button" data-toggle="collapse" data-target="#navbarSupportedContentXL" aria-controls="navbarSupportedContentXL" aria-expanded="false" aria-label="Toggle navigation">
        <span style="font-size: 30px; position:absolute ; top:-140px ; left:10px" class=" navbar-toggler-icon custom-toggler sticky-top"></span>
    </button>
</nav>
<nav class="navbar navbar-expand-lg bg-pink navbar-dark Vegur sticky-top p-0 my-transparent magic-wrapper" style="width:100%;">
    <div class="collapse navbar-collapse justify-content-center m-0 my-transparent1 magic" id="navbarSupportedContentXL">
        <ul class="nav navbar-nav navbar-center justify-content-center my-side-bar nav-pills nav-stacked my-transparent2">
            <div class="d-inline d-lg-none menu-top sticky-top ">
                <div style="display:flex; width:100%">
                    <h4 style="color: white; align-self:center" class="Vegur mx-auto">Menu</h4>
                </div>
                <button style="position:absolute; top:0px;right:2% ;height:0px" data-toggle="collapse" data-target="#navbarSupportedContentXL" aria-controls="navbarSupportedContentXL" aria-expanded="false" aria-label="Toggle navigation" class="close closed">&times;</button>
            </div>
            <?php
            if (isset($_GET['brand'])) {
                $brand['brandID'] = ($_GET['brand']);
            } else {
                $brand['brandID'] = '';
            }
            ?>
            <div class="dropdown mx-2 mymaindropdown">
                <li class=" menu-large text-left maincategory-button1">
                    <div class="mydropdownbtn" style=" width:100%;  height: 40px ; ">
                    </div>
                    <a class="dropdown main-category-link Vegur txt-color-dark-pink" href="index?page=category&searchinfo=">ALL</a>
                </li>
            </div>
            <?php
            $stmt = $pdo->prepare('SELECT * FROM main_categories WHERE stt = 1 ORDER BY maincategoryID ');
            $stmt->execute();
            $main_categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($main_categories  as $main_category) : ?>
                <div class="dropdown mx-2 mymaindropdown">
                    <li class=" menu-large text-left maincategory-button1">
                        <div class="mydropdownbtn" data-target="drop<?= $main_category['maincategoryID'] ?>" id="button<?=$main_category['maincategoryID']?>" style="width:100%;  height: 40px ; ">
                        </div>
                        <a class="dropdown main-category-link Vegur txt-color-dark-pink" href="index?page=category&maincategory=<?= $main_category['name'] ?>"><?= $main_category['name'] ?></a>
                        <div class="dropdown-menu dropdown-menu-111" id="menux<?=$main_category['maincategoryID']?>" style=" width: fit-content; height: 0px">
                            <ul role="menu" class="dropdown-menu-111 dropdown-menu12" id="drop<?=$main_category['maincategoryID']?>" class="list-unstyled" style="width:100%;">
                                <?php
                                $main_category_id = (array)$main_category['maincategoryID'];
                                $stmt = $pdo->prepare('SELECT * FROM categories WHERE maincategoryID = ?  && stt = 1');
                                $stmt->execute($main_category_id);
                                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($categories  as $category) : ?>
                                <li>
                                        <a class="noSelect dropdown-item txt-color-dark-pink txt-color-dark-pink1 Vegur-r py-2" style="width:100%;" href="index?page=category&maincategory=<?=$main_category['name']?>&category=<?= $category['name'] ?>"><?= $category['name'] ?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </li>
                </div>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>

<!-- script for sidebar dropdown menu -->

<script>
$(document).ready(function () { 
    <?php foreach ($main_categories  as $main_category) :
        $rows = $pdo->query('SELECT * FROM categories WHERE maincategoryID = "' . $main_category['maincategoryID'] . '" && stt = 1')->rowCount();
    ?>
        var menu<?= $main_category['maincategoryID'] ?> = document.getElementById('drop<?=$main_category['maincategoryID']?>'),
            btn<?= $main_category['maincategoryID'] ?> = document.getElementById('button<?=$main_category['maincategoryID']?>'),
            menux<?= $main_category['maincategoryID'] ?> = document.getElementById('menux<?=$main_category['maincategoryID']?>'),
            aaa = menux<?= $main_category['maincategoryID'] ?>.className,
            height<?= $main_category['maincategoryID'] ?> = (<?= $rows ?> * 25),
            bbb = menu<?= $main_category['maincategoryID'] ?>.className;
        btn<?= $main_category['maincategoryID'] ?>.addEventListener('click', function() {
            if (menu<?= $main_category['maincategoryID'] ?>.style.display == "block") {
                menux<?= $main_category['maincategoryID'] ?>.style.height = 0;
                menu<?= $main_category['maincategoryID'] ?>.className = bbb + " fadeout ";
                setTimeout(function() {
                    menux<?= $main_category['maincategoryID'] ?>.className = aaa ;
                    $(menu<?= $main_category['maincategoryID'] ?>).css('display', 'none');
                }, 10);
            } else {
                menux<?= $main_category['maincategoryID'] ?>.className = aaa + ' show';
                $(menu<?= $main_category['maincategoryID'] ?>).css('display', 'block');
                setTimeout(function() {
                    menu<?= $main_category['maincategoryID'] ?>.className = bbb + ' fadein';
                    menux<?= $main_category['maincategoryID'] ?>.style.height = height<?= $main_category['maincategoryID'] ?>;
                }, 1);
            }
        })
    <?php endforeach; ?>
    
});
</script>