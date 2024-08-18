<h1 class="d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-house"></i> หน้าแรก</h1>

<div class="mt-4 p-2 overflow-y-auto overflow-x-hidden" style="height: calc(100% - 15%);">
    <div class="d-flex flex-column gap-2">
        <div class="d-flex">
            <div class="bg-primary rounded-3 p-5 position-relative" style="width: 600px;">
                <div class="d-flex gap-4 align-items-center justify-content-start">
                    <i class="fa-solid fa-user text-white" style="font-size: 60px;"></i>
                    <h1 class="text-white">จำนวนสมาชิก <?= sql("SELECT COUNT(*) AS `countUser` FROM `users` WHERE `role` = 'user'")->fetch()["countUser"] ?> คน</h1>
                </div>
            </div>
        </div>
        <div class="d-flex">
            <div class="bg-warning rounded-3 p-5 position-relative" style="width: 600px;">
                <div class="d-flex gap-4 align-items-center justify-content-start">
                    <i class="fa-solid fa-cart-shopping text-white" style="font-size: 60px;"></i>
                    <h1 class="text-white">จำนวนสินค้า <?= sql("SELECT COUNT(*) AS `countProduct` FROM `products`")->fetch()["countProduct"] ?> รายการ</h1>
                </div>
            </div>
        </div>
    </div>
</div>