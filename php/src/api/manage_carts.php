<?php
session_start();
require_once __DIR__ . "/../lib/util.php";

if (isset($_GET["addToCart"]) && isset($_GET["product_id"]) && isset($_GET["amount"])) {
    $product_id = $_GET["product_id"];
    $amount = $_GET["amount"];
    $user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : msg("กรุณาทำการเข้าสู่ระบบก่อน", 'danger', "../pages/login.php");

    $products = sql("SELECT * FROM `products` WHERE `product_id` = ?", [$product_id])->fetch(PDO::FETCH_ASSOC);
    $carts = sql("SELECT * FROM `carts` WHERE `product_id` = ? AND `user_id` = ?", [$product_id, $user_id]);

    if ($carts->rowCount() > 0) {
        $cart = $carts->fetch(PDO::FETCH_ASSOC);
        $updateAmount = sql("UPDATE `carts` SET `amount` = ? WHERE `product_id` = ? AND `user_id` = ?", [
            $cart["amount"] + $amount, $product_id, $user_id
        ]);
    } else {
        $insert = sql("INSERT INTO `carts`(`product_id`,`amount`,`user_id`) VALUES(?,?,?)", [
            $product_id, $amount, $user_id
        ]);
    }
    header("Location: ../pages/cart.php");
    exit;
}

if (isset($_GET["deleteItemOnCart"]) && isset($_GET["product_id"])) {
    $product_id = $_GET["product_id"];
    $user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : msg("กรุณาทำการเข้าสู่ระบบก่อน", 'danger', "../pages/login.php");

    $carts = sql("DELETE FROM `carts` WHERE `product_id` = ? AND `user_id` = ?", [$product_id, $user_id]);
    header("Location: ../pages/cart.php");
    exit;
}

if (isset($_GET["plusAmountItem"]) && isset($_GET["product_id"])) {
    $amount = 1;
    $product_id = $_GET["product_id"];
    $user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : msg("กรุณาทำการเข้าสู่ระบบก่อน", 'danger', "../pages/login.php");

    $cart = sql("SELECT * FROM `carts` WHERE `product_id` = ? AND `user_id` = ?", [$product_id, $user_id])->fetch(PDO::FETCH_ASSOC);
    $updateAmount = sql("UPDATE `carts` SET `amount` = ? WHERE `product_id` = ? AND `user_id` = ?", [
        $cart["amount"] + $amount, $product_id, $user_id
    ]);
    header("Location: ../pages/cart.php");
    exit;
}

if (isset($_GET["minusAmountItem"]) && isset($_GET["product_id"])) {
    $amount = 1;
    $product_id = $_GET["product_id"];
    $user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : msg("กรุณาทำการเข้าสู่ระบบก่อน", 'danger', "../pages/login.php");
    $cart = sql("SELECT * FROM `carts` WHERE `product_id` = ? AND `user_id` = ?", [$product_id, $user_id])->fetch(PDO::FETCH_ASSOC);
    if ($cart["amount"] == 1) {
        msg("ไม่สามารถลดจำนวนลงได้อีก!", 'warning', "../pages/cart.php");
    } else {
        $updateAmount = sql("UPDATE `carts` SET `amount` = ? WHERE `product_id` = ? AND `user_id` = ?", [
            $cart["amount"] - $amount, $product_id, $user_id
        ]);
        header("Location: ../pages/cart.php");
        exit;
    }
}
