<?php
session_start();
require_once __DIR__ . "/../lib/util.php";
$user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : (isset($_SESSION["admin_login"]) ? header("location: ../") : header("location: ./login.php"));
if ($user_id) {
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CART</title>
    <?php require_once __DIR__ . "/../lib/link.php"; ?>
</head>

<body>
    <?php require_once __DIR__ . "/../components/navbar.php"; ?>

    <div class="container min-width-container p-4">
        <div class="d-flex justify-content-start mb-2">
            <a href="../" class="d-flex align-items-center text-cyan" style="gap:10px">
                <i class="fa-solid fa-left-long"></i>
                <h5>กลับ</h5>
            </a>
        </div>
        <h4 class="d-flex align-items-center my-3 fw-semibold fs-1">ตะกร้าสินค้า <i class="fa-solid fa-cart-shopping"></i></h4>

        <?php
        $cart = sql("SELECT * FROM `carts` WHERE user_id = ?", [$row['user_id']]);
        if ($cart->rowCount() > 0) { ?>
            <table class="table mt-4">
                <thead class="table-light text-center">
                    <tr>
                        <th scope="col" style="width: 100px;">#</th>
                        <th scope="col" style="width: 300px;">สินค้า</th>
                        <th scope="col" style="width: 380px;">จำนวนสินค้า</th>
                        <th scope="col" style="width: 300px;">ราคา ต่อชิ้น</th>
                        <th scope="col" style="width: 300px;">ราคา รวม</th>
                        <th scope="col" style="width: 150px;">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    <?php
                    $items = sql("SELECT * FROM `carts` WHERE user_id = ?", [$row['user_id']]);
                    $orderItem = 1;
                    $totalPrice = 0;
                    while ($item = $items->fetch()) {
                        $product = sql("SELECT * FROM `products` WHERE `product_id` = ?", [$item["product_id"]])->fetch(PDO::FETCH_ASSOC);
                        $totalPrice += ($product["price"] * $item["amount"]); ?>
                        <tr class="align-middle">
                            <th scope="row"><?= $orderItem; ?></th>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="<?= pathImage($product["product_image"], "product_images"); ?>" width="100px" height="100px" class="object-fit-cover rounded-3">
                                    <h5><?= $product["name"] ?></h5>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <a href="../api/manage_carts.php?minusAmountItem&product_id=<?= $product["product_id"] ?>" class="btn btn-lightV2 text-dark rounded-0">-</a>
                                    <input type="number" class="form-control text-center rounded-0" style="width: 60px;" value="<?= $item["amount"] ?>" readonly>
                                    <a href="../api/manage_carts.php?plusAmountItem&product_id=<?= $product["product_id"] ?>" class="btn btn-lightV2 text-dark rounded-0">+</a>
                                </div>
                            </td>
                            <td><?= formatNumberWithComma($product["price"]) ?> บาท</td>
                            <td>
                                <div class="">
                                    <?= formatNumberWithComma($product["price"] * $item["amount"]); ?> บาท
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center justify-content-center">
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#sureToDeleteItem<?= $product["product_id"] ?>" class="btn btn-danger fs-4"><i class="fa-solid fa-trash-can"></i></button>
                                </div>

                                <div class="modal fade" id="sureToDeleteItem<?= $product["product_id"] ?>">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title">ลบออกจากตะกร้า?</h4>
                                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body p-4">
                                                <div class="d-flex align-items-center justify-content-center fs-1 mb-3 text-danger" style="gap:10px">
                                                    <i class="fa-solid fa-cart-shopping"></i>
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </div>
                                                <h5 class="text-center">คุณแน่ใจที่จะทำการลบสินค้าออกใช่หรือไม่?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="d-flex align-items-center w-100" style="gap:10px;">
                                                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด​</button>
                                                    <a href="../api/manage_carts.php?deleteItemOnCart&product_id=<?= $product["product_id"] ?>" class="btn btn-danger w-100" data-bs-dissmiss="modal">ลบ</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php $orderItem++;
                    } ?>
                </tbody>
                <tfoot>
                    <tr class="table-light">
                        <th colspan="6" class="text-end p-4 fs-5">
                            <i class="fa-solid fa-money-bill text-success"></i>
                            รวมเป็นเงินทั้งหมด:
                            <span class="text-success"><?= formatNumberWithComma($totalPrice); ?> บาท</span>
                        </th>
                    </tr>
                </tfoot>
            </table>

            <div class="d-flex justify-content-end">
                <a href="../api/manage_orders.php?placeOrder&totalPrice=<?= $totalPrice; ?>" class="btn btn-success"><i class="fa-solid fa-circle-check"></i> สั่งซื้อสินค้า</a>
            </div>
        <?php } else { ?>
            <div class="d-flex justify-content-center align-items-center flex-column">
                <img src="../assets/images/web/cartisempty.png" height="400px">
                <h4 class="text-muted">ยังไม่มีสินค้าในตะกร้าของคุณ <a href="/">เริ่มสั่งสินค้าเลย!</a></h4>
            </div>
        <?php } ?>
    </div>

</body>

</html>