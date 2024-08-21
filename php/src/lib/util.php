<?php
$servername = "mysql-thodlen";
$username = "username";
$password = "password";
$database = "thodlen_db";

require_once $_SERVER['DOCUMENT_ROOT'] . "/config_function/config_db.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/config_function/function.php";

$web_name_var = "Thodlen";
$header_text_var = "";
$telephone_var = "000-000-0000";

$facebook_var = "facebook";
$facebook_link_var = "https://www.facebook.com/facebook";

$instagram_var = "instagram";
$instagram_link_var = "https://www.instagram.com/instagram/";

$bannerTitle = [
    "ทอดสดใหม่ กรอบอร่อยทุกวัน !",
    "ที่คุณจะต้องหลงรัก",
    "โปรแรง! ซื้อ 1 แถม 1 ทุกวันศุกร์ ส่งตรงถึงหน้าบ้านคุณสั่งซื้อได้แล้ววันนี้!"
];

$logo_image = "logo.png";

$email_var = "example@email.com";
$address_var = "193 ถนน มาตุลี ตำบลปากน้ำโพ อำเภอเมืองนครสวรรค์ นครสวรรค์ 60000";
$copyright_text_var = "© 2024 - All Rights Reserved";

$imageBanner = [
    pathImage("banner1.png", "banner"),
    pathImage("banner2.png", "banner"),
    pathImage("banner3.png", "banner")
];
$interval_slide_banner = "2000";