<?php
if (($_SERVER["REQUEST_URI"] == "/admin/" || $_SERVER["REQUEST_URI"] == "/admin/index.php") || $_SERVER["REQUEST_URI"] == "/admin/?page=" || $_SERVER["REQUEST_URI"] == "/admin/index.php?page=") {
    header("location: /admin/?page=home");
    exit;
} else if ($_SERVER["REQUEST_URI"] == "/admin/?page=orders" || $_SERVER["REQUEST_URI"] == "/admin/index.php?page=orders") {
    header("location: /admin/?page=orders&tabs=all");
    exit;
}

session_start();
require_once __DIR__ . "/../lib/util.php";
$admin_id = isset($_SESSION["user_login"]) ? header("location: ../") : (isset($_SESSION["admin_login"]) ? $_SESSION["admin_login"] : header("location: ./login-admin.php"));
if ($admin_id) {
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$admin_id])->fetch(PDO::FETCH_ASSOC);
}
$linkPageAdmin = [
    [
        "thText" => "หน้าแรก",
        "engText" => "home",
        "icon" => '<i class="fa-solid fa-house"></i>'
    ],
    [
        "thText" => "จัดการสมาชิก",
        "engText" => "manage-user",
        "icon" => '<i class="fa-solid fa-user"></i>'
    ],
    [
        "thText" => "รายการสินค้า",
        "engText" => "products",
        "icon" => '<i class="fa-solid fa-cart-shopping"></i>'
    ],
    [
        "thText" => "คำสั่งซื้อที่เพิ่มเข้ามา",
        "engText" => "orders",
        "icon" => '<i class="fa-solid fa-clipboard-list"></i>'
    ],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <?php require_once __DIR__ . "/../lib/link.php"; ?>
</head>

<body>
    <div class="w-100 vh-100 p-4" style="min-width: 1600px;">
        <div class="bg-white rounded-4 h-100 border shadow d-flex">
            <div class="border h-100 bg-cyan text-white d-flex flex-column justify-content-between p-4" style="width: 400px;border-radius: 1rem 0rem 0rem 1rem;white-space: nowrap;">
                <div>
                    <div class="text-center mb-5 mt-4 fs-3">ADMIN DASHBOARD</div>
                    <ul class="p-0" style="list-style:none;">
                        <?php foreach ($linkPageAdmin as $index => $link) { ?>
                            <li>
                                <a href="?page=<?= $link['engText']; ?>" class="btn btn-outline-light w-100 fs-5 text-start p-3 d-flex align-items-center mb-2 <?= isset($_GET["page"]) && $_GET["page"] == $link['engText'] ? "active" : ""; ?>" style="gap:10px;"><?= $link["icon"] . " " . $link["thText"]; ?>
                                    <?php
                                    $ordersBadge = sql("SELECT COUNT(*) as `count` FROM `orders` WHERE `status` = ?", ["waiting"])->fetch()["count"];
                                    if ($ordersBadge) {
                                        echo $link['engText'] == "orders" ? "<span class='badge text-bg-danger'>$ordersBadge</span>" : null;
                                    }
                                    ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="dropup">
                    <div class="d-flex justify-content-start align-items-center btn btn-outline-light border-0 rounded-3" data-bs-toggle="dropdown">
                        <div class="dropdown-toggle d-flex align-items-center" style="gap:10px">
                            <img src="<?= pathImage($row["profile_image"]); ?>" width="60px" height="60px" class="rounded-circle border object-fit-cover">
                            <?= $row["firstname"] ?>
                            <?= $row["lastname"] ?>
                        </div>
                    </div>
                    <ul class="dropdown-menu px-2">
                        <li><a href="?page=manage-account" class="p-3 d-flex align-items-center text-decoration-none btn btn-light" style="gap: 10px;white-space: nowrap;"><i class="fa-solid fa-gear fs-5"></i> การจัดการบัญชีของฉัน</a></li>
                        <div class="dropdown-divider"></div>
                        <li><a href="?logout" class="p-3 d-flex align-items-center btn btn-outline-danger border-0" style="gap: 10px;white-space: nowrap;"><i class="fa-solid fa-right-from-bracket fs-5"></i>ออกจากระบบ!</a></li>
                    </ul>
                </div>
            </div>
            <div class="bg-light border rounded-4 rounded-start-0 p-5 overflow-hidden" style="white-space: wrap;width: calc(100% - 400px);">
                <?php foreach ($linkPageAdmin as $index => $link) {
                    if (isset($_GET["page"]) && $_GET["page"] == $link['engText']) {
                        require_once __DIR__ . "/components/" . $link['engText'] . ".php";
                    } elseif (isset($_GET["page"]) && $_GET["page"] == "manage-account") {
                        require_once "../components/manage_account.php";
                    }
                } ?>
            </div>
        </div>
    </div>
</body>

</html>