<div style="height:65px;" class="w-100 bg-dark d-flex align-items-center min-width-container">
    <div class="container min-width-container">
        <div class="d-flex justify-content-between align-items-center">
            <h5 class="text-white"><?php echo $header_text_var; ?></h5>
            <div class="d-flex align-items-center" style="gap:20px">
                <a href="<?php echo $facebook_link_var; ?>" target="_blank" class="d-flex align-items-center text-decoration-none btn btn-dark rounded-4" style="gap:10px">
                    <i class="fa-brands fa-square-facebook text-white fs-3"></i>
                    <p class="text-white"><?php echo $facebook_var; ?></p>
                </a>
                <a href="<?php echo $instagram_link_var; ?>" target="_blank" class="d-flex align-items-center text-decoration-none btn btn-dark rounded-4" style="gap:10px">
                    <i class="fa-brands fa-square-instagram text-white fs-3"></i>
                    <p class="text-white"><?php echo $instagram_var; ?></p>
                </a>
                <a class="d-flex align-items-center text-decoration-none btn btn-dark rounded-4" style="gap:10px">
                    <i class="fa-solid fa-phone text-white fs-3"></i>
                    <p class="text-white"><?php echo $telephone_var; ?></p>
                </a>
            </div>
        </div>
    </div>
</div>


<div class="bg-white d-flex shadow position-sticky top-0 mb-2 min-width-container rounded-bottom-4" style="z-index:999;">
    <div class="container min-width-container p-3 d-flex justify-content-between">

        <div class="flex-grow-1 text-center d-flex align-items-center justify-content-start">
            <a href="/" class="text-decoration-none text-cyan">
                <div class="d-flex align-items-center gap-2">
                    <img class="rounded-circle border" src="<?= pathImage($logo_image, "web"); ?>" width="55px" height="55px" style="object-fit:cover;">
                    <h1><?= $web_name_var; ?></h1>
                </div>
            </a>
        </div>

        <div class="flex-grow-1 d-flex align-items-center justify-content-center gap-2 me-5">
            <div class="position-relative w-100">
                <i class="fa-solid fa-magnifying-glass position-absolute" style="top: 12px;left: 1rem;"></i>
                <input type="search" class="form-control border ps-5" placeholder="ค้นหา" id="searchInputNavbar">
            </div>
            <button class="btn btn-cyan d-flex gap-2 align-items-center" onclick='searchProduct($("#searchInputNavbar").val())'>
                <i class="fa-solid fa-magnifying-glass fs-4"></i>
            </button>
        </div>

        <?php if (isset($_SESSION["user_login"])) { ?>
            <div class="nav-menu d-flex flex-row align-items-center justify-content-end flex-grow-1" style="gap:2rem">
                <a href="<?= linkPage("cart.php"); ?>">
                    <button type="button" class="btn btn-outline-light border-0 rounded-circle position-relative d-flex justify-content-center align-items-center" style="width:50px;height:50px;">
                        <i class="fa-solid fa-cart-shopping text-dark fs-3"></i>
                        <div class="text-white position-absolute rounded-circle d-flex justify-content-center align-items-center" style="width:25px;height:25px;top:1.5rem;right:-0.5rem;background-color: #dc3546;">
                            <div style="font-size: 12px;">
                                <?= $amountItem = sql("SELECT COUNT(`item_id`) as `countItem` FROM `carts` WHERE `user_id` = ?", [$row["user_id"]])->fetch()["countItem"]; ?>
                            </div>
                        </div>
                    </button>
                </a>
                <div class="dropdown">
                    <button type="button" data-bs-toggle="dropdown" class="btn btn-outline-light border-0 rounded-3 position-relative d-flex justify-content-center align-items-center dropdown-toggle text-dark" style="gap:10px">
                        <img src="<?= pathImage($row["profile_image"]); ?>" width="50px" height="50px" class="border rounded-circle object-fit-cover">
                        <div class="d-flex">
                            <?= $row["firstname"]; ?>
                            <?= $row["lastname"]; ?>
                        </div>
                    </button>
                    <ul class="dropdown-menu px-2">
                        <li><a href="<?= linkPage("edit-account.php"); ?>" class="p-3 d-flex align-items-center text-decoration-none btn btn-light" style="gap: 10px;white-space: nowrap;"><i class="fa-solid fa-gear fs-5"></i> การจัดการบัญชีของฉัน</a></li>
                        <li><a href="<?= linkPage("manageOrders.php"); ?>" class="p-3 d-flex align-items-center text-decoration-none btn btn-light" style="gap: 10px;white-space: nowrap;"><i class="fa-solid fa-list-check fs-5"></i> การจัดการคำสั่งซื้อของฉัน</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a href="?logout" class="p-3 d-flex align-items-center btn btn-outline-danger border-0" style="gap: 10px;white-space: nowrap;"><i class="fa-solid fa-right-from-bracket fs-5"></i>ออกจากระบบ!</a></li>
                    </ul>
                </div>
            </div>
        <?php } else { ?>
            <div class="flex1 flex-grow-1">
                <div class="d-flex align-items-center justify-content-end" style="gap:10px">
                    <a href="<?= linkPage("register.php"); ?>" class="btn btn-lightV2 rounded-3 fs-4" style="width:170px">สมัครสมาชิก</a>
                    <a href="<?= linkPage("login.php"); ?>" class="btn btn-cyan rounded-3 fs-4" style="width:170px">เข้าสู่ระบบ</a>
                </div>
            </div>
        <?php } ?>
    </div>
</div>