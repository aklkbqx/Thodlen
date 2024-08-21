<?php
session_start();
require_once __DIR__ . "/lib/util.php";
$user_id = isset($_SESSION["user_login"]) ? $_SESSION["user_login"] : (isset($_SESSION["admin_login"]) ? header("location: ./admin/") : null);
if ($user_id) {
    $row = sql("SELECT * FROM `users` WHERE `user_id` = ?", [$user_id])->fetch(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $web_name_var; ?></title>
    <?php require_once __DIR__ . "/lib/link.php"; ?>
</head>

<body>
    <?php require_once __DIR__ . "/components/navbar.php"; ?>

    <div class="w-100 min-width-container mb-2">
        <div id="carouselBanner" class="carousel slide position-relative" data-bs-ride="carousel">
            <div class="carousel-indicators" style="gap:1rem">
                <?php foreach ($imageBanner as $index => $imageSrc) { ?>
                    <button type="button" data-bs-target="#carouselBanner" data-bs-slide-to="<?= $index; ?>" <?= $index == 0 ? 'class="active" aria-current="true"' : ""; ?> aria-label="Slide <?= $index + 1; ?>"></button>
                <?php } ?>
            </div>
            <div class="carousel-inner">
                <?php foreach ($imageBanner as $index => $imageSrc) { ?>
                    <div class="carousel-item <?= $index == 0 ? "active" : "" ?>" data-bs-interval="<?= $interval_slide_banner ?>">
                        <img src="<?= $imageSrc; ?>" class="d-block w-100 image-banner" alt="banner <?= $index + 1; ?>" style="object-fit:cover;" draggable="false">
                    </div>
                <?php } ?>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanner" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselBanner" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            <div class="w-100 w-100 h-100 position-absolute top-0 left-0" style="background: linear-gradient(45deg, #414141, transparent);"></div>

            <div class="title-banner">
                <div class="fw-semibold" style="font-size:50px;">
                    <?= $bannerTitle[0]; ?>
                    <div class="fw-medium">
                        <?= $bannerTitle[1]; ?>
                    </div>
                </div>
                <p style="width: 400px;" class="mt-3 fs-5">
                    <?= $bannerTitle[2]; ?>
                </p>
            </div>
        </div>
    </div>

    <div class="container min-width-container" style="min-height: 400px;">

     <div class="d-flex w-100 justify-content-start my-4">
            <div class="bg-cyan rounded-3 p-2">
                <h3 class="text-white"><i class="fa-solid fa-cart-shopping"></i> สินค้าทั้งหมดภายในร้านของเรา</h3>
            </div>
        </div>

        <div class="d-flex justify-content-center flex-column align-items-center d-none" id="productSearchNotFound">
            <div class="d-flex align-items-center justify-content-center h-100 w-100 p-5 pb-0" style="gap: 10px;">
                <h3 class="text-muted">ไม่พบสินค้าที่คุณต้องการค้นหา</h3>
                <div class="d-flex align-items-center" style="gap:10px">
                    <div class="spinner-grow spinner-grow-sm" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow" role="status" style="width: 1.5rem !important;height: 1.5rem !important;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="spinner-grow spinner-grow-lg" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
            <img src="./assets/images/web/searchNotFoundIcon.png">
        </div>


        <div class="row">
            <?php $product_data = sql("SELECT `product_id`,`name`,`detail`,`price`,`product_image` FROM `products`");
            if ($product_data->rowCount() > 0) {
                while ($product = $product_data->fetch()) { ?>
                    <div data-product-card="<?= $product["product_id"] ?>" class="col-3 my-3">
                        <div class="card-order border p-0">
                            <div style="cursor:pointer" data-bs-toggle="modal" data-bs-target="#modalProduct<?= $product["product_id"] ?>">
                                <img src="<?= pathImage($product["product_image"], "product_images"); ?>" width="100%" height="200px" class="object-fit-cover">
                                <div style="padding: 0.8rem;">
                                    <div>
                                        <h6 data-product-name="<?= $product["product_id"] ?>" class="my-2 fs-5"><?= $product["name"] ?></h6>
                                        <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; height: 50px;"><?= $product["detail"] ?></div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-1">
                                        <div class="text-cyan">ราคา <span><?= $product["price"] ?></span> บาท</div>
                                        <div class="d-flex align-items-center" style="gap:10px">
                                            <button class="btn btn-cyan w-100">
                                                <i class="fa-solid fa-cart-plus"></i>
                                                เพิ่มลงตะกร้า
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="modalProduct<?= $product["product_id"] ?>">
                        <div class="modal-dialog modal-dialog-centered modal-xl">
                            <div class="modal-content rounded-4 shadow-lg border-2" style="border-color:var(--cyan-color1)">
                                <div class="modal-body position-relative p-5">
                                    <div class="p-2 d-flex justify-content-end position-absolute bg-white rounded-circle" style="top: -20px;right:-20px;border:2px solid var(--cyan-color1);border-bottom: none;border-left: none;">
                                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6 col-12" style="max-width: 558px;">
                                            <img src="<?= pathImage($product["product_image"], "product_images"); ?>" class="border rounded-4 object-fit-cover" style="width:100%;height:400px;">
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="mt-3 mt-lg-0">
                                                <div class="d-flex align-items-start justify-content-between">
                                                    <h6 class="fs-2"><?= $product["name"] ?></h6>
                                                </div>
                                                <div class="mt-1 fs-5"><?= $product["detail"] ?></div>
                                            </div>
                                            <div class="fs-4 d-flex mb-3 mt-3 justify-content-start text-cyan" style="white-space: nowrap;gap:5px;">
                                                ราคา<span><?= $product["price"] ?></span>บาท
                                            </div>
                                            <div class="d-flex justify-content-center flex-column align-items-center">
                                                <div class="fs-5 text-center">จำนวน</div>
                                                <div class="d-flex align-items-center rounded-4 overflow-hidden">
                                                    <button onclick="minusAmountItem($(this).parent().find('.amountItem'))" type="button" class="btn btn-lightV2 text-dark rounded-0">-</button>
                                                    <input oninput="inputAmountItem($(this))" type="number" class="form-control text-center rounded-0 amountItem" style="width: 60px;" value="1">
                                                    <button onclick="plusAmountItem($(this).parent().find('.amountItem'))" type="button" class="btn btn-lightV2 text-dark rounded-0">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-5 pt-0">
                                    <div class="d-flex align-items-center flex-row w-100 flex-sm-nowrap flex-wrap" style="gap: 10px;">
                                        <button type="button" class="btn btn-secondary w-100 rounded-4" data-bs-dismiss="modal">ปิด</button>
                                        <a href="./api/manage_carts.php?addToCart&product_id=<?= $product["product_id"] ?>&amount=1" class="w-100 addToCart">
                                            <button class="btn btn-cyan w-100 rounded-4">
                                                เพิ่มลงตะกร้า <i class="fa-solid fa-cart-plus"></i>
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="d-flex align-items-center justify-content-center h-100 w-100 p-5 pb-0" style="gap: 10px;">
                    <h3>ขณะนี้ยังไม่มีข้อมูลสินค้า...</h3>
                    <div class="d-flex align-items-center" style="gap:10px">
                        <div class="spinner-grow spinner-grow-sm" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow" role="status" style="width: 1.5rem !important;height: 1.5rem !important;">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <div class="spinner-grow spinner-grow-lg" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                </div>
                <img class="mb-5" src="./assets/images/web/empty_product.png" style="width: 100%;height: 350px;object-fit: contain;" draggable="false">
            <?php } ?>
        </div>
    </div>

    <script>
        function searchProduct(query) {
            const product_name = $("[data-product-name]");
            const product_card = $("[data-product-card]");

            product_name.each(function(index, product) {
                const productName = $(product).text().toLowerCase();
                if (productName.includes(query.toLowerCase())) {
                    $(product_card[index]).removeClass("d-none");
                    $("#productSearchNotFound").addClass("d-none");
                } else {
                    $(product_card[index]).addClass("d-none");
                    if ($(product_card).not(".d-none").length === 0) {
                        $("#productSearchNotFound").removeClass("d-none");
                    }
                }
            });
        }

        function minusAmountItem(input) {
            let amount = parseInt(input.val());
            if (amount > 1) {
                input.val(amount - 1);
                updateHref(input);
            }
        }

        function plusAmountItem(input) {
            let amount = parseInt(input.val());
            input.val(amount + 1);
            updateHref(input);
        }

        function inputAmountItem(input) {
            let amount = parseInt(input.val());
            if (amount >= 1) {
                updateHref(input);
            } else {
                input.val(1);
                updateHref(input);
            }
        }

        function updateHref(input) {
            let amount = parseInt(input.val());
            let href = input.closest(".modal-content").find(".addToCart").attr("href");
            let newHref = href.replace(/amount=\d+/, `amount=${amount}`);
            input.closest(".modal-content").find(".addToCart").attr("href", newHref);
        }

        const searchInputNavbar = $("#searchInputNavbar");
        searchInputNavbar.on("keypress", (e) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchProduct(searchInputNavbar.val())
            }
        })
    </script>

    <?php require_once __DIR__ . "/components/footer.php"; ?>
</body>

</html>