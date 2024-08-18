<div class="d-flex align-items-center justify-content-between">
    <h1 class="d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-cart-shopping"></i> รายการสินค้าทั้งหมด</h1>
    <div class="d-flex justify-content-end">
        <button class="btn btn-cyan fs-4" type="button" data-bs-toggle="modal" data-bs-target="#add_product"><i class="fa-solid fa-plus"></i> เพิ่มรายการสินค้า</button>
    </div>
</div>
<div class="modal fade" id="add_product">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <form action="../api/manage_products.php?add" method="POST" enctype="multipart/form-data" class="modal-content m-0">
            <div class="modal-header">
                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-plus"></i> เพิ่มรายการสินค้า</h3>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-6 col-12" style="max-width: 558px;">
                        <img id="product_image_preview" src="../assets/images/product_images/image_placeholder.jpg" class="border rounded-3 object-fit-cover" style="width:100%;height:400px;">
                        <div class="d-flex align-items-center mt-3" style="gap:10px">
                            <label for="product_image" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                            <button id="trash-can" type="button" class="btn btn-danger d-none" onclick="document.getElementById('product_image_preview').src = '../assets/images/product_images/image_placeholder.jpg';document.getElementById('product_image').value=''; this.classList.add('d-none')">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="mt-3 mt-lg-0">
                            <div class="form-floating">
                                <input type="text" class="form-control rounded-3" name="name" id="ชื่อสินค้า" placeholder="ชื่อสินค้า" required>
                                <label for="ชื่อสินค้า">ชื่อสินค้า</label>
                            </div>
                            <div class="form-floating mt-4">
                                <textarea class="form-control rounded-3" placeholder="คำอธิบาย" name="detail" id="คำอธิบาย" style="min-height: 100px;max-height:280px;"></textarea>
                                <label for="คำอธิบาย">คำอธิบาย</label>
                            </div>
                            <div class="form-floating mt-4">
                                <input type="number" class="form-control rounded-3" name="price" id="ราคาสินค้า" placeholder="ราคาสินค้า (บาท)" required>
                                <label for="ราคาสินค้า">ราคาสินค้า (บาท)</label>
                            </div>
                        </div>
                    </div>
                </div>
                <input name="productImage" id="product_image" type="file" onchange="document.getElementById('product_image_preview').src = window.URL.createObjectURL(this.files[0]);document.getElementById('trash-can').classList.remove('d-none')" hidden>
            </div>
            <div class="modal-footer">
                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                    <button type="button" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" name="add_product" class="btn btn-cyan w-100">เพิ่มสินค้า</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="mt-4 p-2 overflow-y-auto overflow-x-hidden" style="height: calc(100% - 15%);">

    <?php $product_data = sql("SELECT `product_id`,`name`,`detail`,`price`,`product_image` FROM `products`");
    if ($product_data->rowCount() > 0) { ?>
        <div class="row">
            <?php while ($data = $product_data->fetch()) { ?>
                <div class="col-4 mb-4">
                    <div class="card-order p-0 border" style="cursor: default;height:380px !important;">
                        <div>
                            <img src="<?= pathImage($data["product_image"], "product_images"); ?>" width="100%" height="200px" class="object-fit-cover">
                            <div class="p-2 pb-0">
                                <h6 class="my-2 fs-5"><?= $data["name"] ?></h6>
                                <div style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; text-overflow: ellipsis; height: 50px;"><?= $data["detail"] ?></div>
                            </div>
                        </div>
                        <div class="p-2 pt-0">
                            <div class="mb-2 text-cyan">
                                ราคา <span><?= $data["price"] ?></span> บาท
                            </div>
                            <div class="d-flex align-items-center" style="gap:10px">
                                <button class="btn btn-cyan w-100" data-bs-toggle="modal" data-bs-target="#edit_product<?= $data["product_id"] ?>">
                                    <i class="fa-solid fa-pen-to-square"></i> แก้ไข
                                </button>
                                <button class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#delete_product<?= $data["product_id"] ?>">
                                    <i class="fa-solid fa-trash-can"></i> ลบ
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="edit_product<?= $data["product_id"] ?>">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <form action="../api/manage_products.php?edit&product_id=<?= $data["product_id"] ?>" method="POST" enctype="multipart/form-data" class="modal-content m-0">
                            <div class="modal-header">
                                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-pen-to-square"></i> แก้ไขสินค้า</h3>
                                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-lg-6 col-12" style="max-width: 558px;">
                                        <img id="product_image_preview<?= $data['product_id'] ?>" src="<?= pathImage($data["product_image"], "product_images"); ?>" class="border rounded-3 object-fit-cover" style="width:100%;height:400px;">
                                        <div class="d-flex align-items-center mt-3" style="gap:10px">
                                            <label for="product_image<?= $data["product_id"] ?>" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                                            <button id="trash-can<?= $data['product_id'] ?>" type="button" class="btn btn-danger d-none" onclick="document.getElementById('product_image_preview<?= $data['product_id'] ?>').src = '<?= pathImage($data['product_image'], 'product_images'); ?>';document.getElementById('product_image<?= $data['product_id'] ?>').value=''; this.classList.add('d-none')">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-12">
                                        <div class="mt-3 mt-lg-0">
                                            <div class="form-floating">
                                                <input type="text" class="form-control rounded-3" name="name" id="ชื่อสินค้า" placeholder="ชื่อสินค้า" value="<?= $data["name"] ?>" required>
                                                <label for="ชื่อสินค้า">ชื่อสินค้า</label>
                                            </div>
                                            <div class="form-floating mt-4">
                                                <textarea class="form-control rounded-3" placeholder="คำอธิบาย" name="detail" id="คำอธิบาย" style="min-height: 100px;max-height:280px;"><?= $data["detail"] ?></textarea>
                                                <label for="คำอธิบาย">คำอธิบาย</label>
                                            </div>
                                            <div class="form-floating mt-4">
                                                <input type="number" class="form-control rounded-3" name="price" id="ราคาสินค้า" placeholder="ราคาสินค้า (บาท)" value="<?= $data["price"] ?>" required>
                                                <label for="ราคาสินค้า">ราคาสินค้า (บาท)</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <input name="productImage" id="product_image<?= $data["product_id"] ?>" type="file" onchange="document.getElementById('product_image_preview<?= $data['product_id'] ?>').src = window.URL.createObjectURL(this.files[0]); document.getElementById('trash-can<?= $data['product_id'] ?>').classList.remove('d-none')" hidden>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                                    <button type="reset" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" name="edit_product" class="btn btn-cyan w-100">บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="delete_product<?= $data["product_id"] ?>">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <form action="../api/manage_products.php?delete&product_id=<?= $data["product_id"] ?>" method="POST" class="modal-content m-0">
                            <div class="modal-header">
                                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-trash"></i> ลบสินค้า</h3>
                                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-center mb-3">คุณแน่ใจที่จะทำการลบใช่หรือไม่?</h4>
                                <img src="<?= pathImage($data["product_image"], "product_images"); ?>" width="100%" height="200px" class="border rounded-3 object-fit-cover">
                                <h6 class="mt-3 fs-5">ชื่อสินค้า: <?= $data["name"] ?></h6>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                                    <button type="reset" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" name="delete_product" class="btn btn-danger w-100">ลบสินค้า</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } else { ?>
        <div class="d-flex align-items-center justify-content-center h-100 w-100 p-5 pb-0" style="gap: 10px;">
            <h3 class="text-muted">คุณยังไม่ได้เพิ่มสินค้า
                <span class="text-primary text-decoration-underline pointer" data-bs-toggle="modal" data-bs-target="#add_product">เพิ่มสินค้าเลย</span>
            </h3>
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
    <?php } ?>
</div>