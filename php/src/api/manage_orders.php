<?php
session_start();
require_once __DIR__ . "/../lib/util.php";

if (isset($_GET["placeOrder"]) && isset($_GET["totalPrice"])) {
    $totalPrice = $_GET["totalPrice"];
    $user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : msg("กรุณาทำการเข้าสู่ระบบก่อน", 'danger', "../pages/login.php");
    $carts = sql("SELECT * FROM `carts` WHERE `user_id` = ?", [$user_id])->fetchAll(PDO::FETCH_ASSOC);
    $response = [
        "totalPrice" => $totalPrice,
        "user_id" => $user_id,
        "carts" => $carts
    ];
    $oders_json = json_encode($response);
    $insert_order = sql("INSERT INTO `orders` (`oders_json`,`user_id`) VALUES(?,?)", [$oders_json, $user_id]);
    if ($insert_order) {
        $deleteCart = sql("DELETE FROM `carts` WHERE `user_id` = ?", [$user_id]);
        if ($deleteCart) {
            msg("สั่งซื้อเรียบร้อย!", "success", "../pages/manageOrders.php");
        }
    }
}


if (isset($_GET["cancelOrder"]) && isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    $orders = sql("UPDATE `orders` SET `status` = ? WHERE `order_id` = ?", ["canceled", $order_id])->fetch();
    msg("ยกเลิกแล้ว!", "success", $_SERVER["HTTP_REFERER"]);
}

if (isset($_GET["deliveryOrder"]) && isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    $orders = sql("UPDATE `orders` SET `status` = ? WHERE `order_id` = ?", ["delivering", $order_id])->fetch();
    msg("ยกเลิกแล้ว!", "success", $_SERVER["HTTP_REFERER"]);
}

if (isset($_GET["successfullyOrder"]) && isset($_GET["order_id"])) {
    $order_id = $_GET["order_id"];
    $orders = sql("UPDATE `orders` SET `status` = ? WHERE `order_id` = ?", ["successfully", $order_id])->fetch();
    msg("ยกเลิกแล้ว!", "success", $_SERVER["HTTP_REFERER"]);
}
