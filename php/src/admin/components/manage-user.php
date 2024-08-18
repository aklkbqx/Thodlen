<div class="d-flex justify-content-between align-items-center">
    <h1 class="d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-user"></i> จัดการสมาชิกทั้งหมด</h1>
    <div class="d-flex justify-content-end">
        <button class="btn btn-cyan fs-4" type="button" data-bs-toggle="modal" data-bs-target="#add_user"><i class="fa-solid fa-user-plus"></i> เพิ่มสมาชิก</button>
    </div>
</div>

<div class="modal fade" id="add_user">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <form action="../api/manage_user-admin.php?add" method="POST" enctype="multipart/form-data" class="modal-content m-0" autocomplete="off">
            <div class="modal-header">
                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-user-plus"></i> เพิ่มข้อมูลสมาชิก</h3>
                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-xl-4 col-12">
                        <div class="d-flex flex-column align-items-center rounded-3">
                            <img src="<?= pathImage($row["profile_image"]); ?>" id="profile_image_preview" width="300px" height="300px" class="rounded-circle pointer border" style="object-fit:cover" onclick="document.getElementById('profile<?= $user['user_id'] ?>').click()">
                            <div class="d-flex align-items-center my-3" style="gap:10px">
                                <label for="profile<?= $user['user_id'] ?>" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                                <button id="trash-can<?= $user['user_id'] ?>" type="button" class="btn btn-danger d-none" onclick="$('#profile_image_preview<?= $user['user_id'] ?>').attr('src','<?= pathImage($row['profile_image']); ?>');$('#profile<?= $user['user_id'] ?>').val('');$(this).addClass('d-none');">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-8 col-12" style="position: relative;">
                        <div class="form-floating">
                            <input type="text" class="form-control rounded-3" name="firstname" placeholder="Firstname" required>
                            <label for="firstname">ชื่อ</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="text" class="form-control rounded-3" name="lastname" placeholder="Lastname" required>
                            <label for="lastname">นามสกุล</label>
                        </div>
                        <div class="form-floating mt-4">
                            <textarea class="form-control rounded-3" name="address" placeholder="address" style="min-height: 100px;" required></textarea>
                            <label for="address">ที่อยู่</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="number" class="form-control rounded-3" name="tel" placeholder="0xxxxxxxx" required>
                            <label for="tel">เบอร์โทรศัพท์</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="email" class="form-control rounded-3" name="email" placeholder="name@example.com" required">
                            <label for="email">อีเมล</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="password" class="form-control rounded-3" name="password" placeholder="password" oninput="handleInputChange($(this))">
                            <label for="password">เปลี่ยนรหัสผ่านใหม่</label>
                        </div>
                        <div data-text-validate="text-validate-password" class="d-flex justify-content-end position-absolute text-danger" style="right: 15px;opacity: 0;bottom: 58px;font-size: 14px;">
                            รหัสผ่านไม่ตรงกัน
                        </div>
                        <div class="form-floating mt-4">
                            <input type="password" class="form-control rounded-3" name="c_password" placeholder="confirm password" oninput="handleInputChange($(this))">
                            <label for="password">ยืนยันรหัสผ่านใหม่อีกครั้ง</label>
                        </div>
                        <input name="profile" id="profile" type="file" onchange="$('#profile_image_preview<?= $user['user_id'] ?>').attr('src',window.URL.createObjectURL($(this)[0].files[0]));$('#trash-can<?= $user['user_id'] ?>').removeClass('d-none')" hidden>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                    <button type="reset" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" name="add_user" class="btn btn-cyan w-100">เพิ่ม</button>
                </div>
            </div>
        </form>
    </div>
</div>


<div class="mt-4">
    <h4 class="text-end"><i class="fa-solid fa-user"></i> จำนวนสมาชิกทั้งหมด <?= sql("SELECT COUNT(*) AS `countUser` FROM `users` WHERE `role` = 'user'")->fetch()["countUser"] ?> คน</h4>

    <?php $fetchAllUser = sql("SELECT * FROM `users` WHERE `role` = 'user'");
    if ($fetchAllUser->rowCount() > 0) { ?>
        <div class="d-flex flex-column gap-2">
            <?php while ($user = $fetchAllUser->fetch()) { ?>

                <div class="d-flex justify-content-between align-items-center my-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="<?= pathImage($user["profile_image"], "user_images"); ?>" width="100px" height="100px" class="rounded-circle border object-fit-cover">
                        <div class="d-flex flex-column">
                            <h4><?= $user["firstname"] . " " . $user["lastname"] ?></h4>
                            <div><?= $user["email"] ?></div>
                            <div><?= $user["tel"] ?></div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <button type="button" class="btn btn-warning fs-5" data-bs-toggle="modal" data-bs-target="#edit_user<?= $user["user_id"] ?>">แก้ไข</button>
                        <button type="button" class="btn btn-danger fs-5" data-bs-toggle="modal" data-bs-target="#delete_user<?= $user["user_id"] ?>">ลบ</button>
                    </div>
                </div>

                <div class="modal fade" id="edit_user<?= $user["user_id"] ?>">
                    <div class="modal-dialog modal-dialog-centered modal-xl">
                        <form action="../api/manage_user-admin.php?edit&user_id=<?= $user["user_id"] ?>" method="POST" enctype="multipart/form-data" class="modal-content m-0" autocomplete="off">
                            <div class="modal-header">
                                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-user-pen"></i> แก้ไขข้อมูลของคุณ <?= $user["firstname"] . " " . $user["lastname"] ?>​</h3>
                                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-xl-4 col-12">
                                        <div class="d-flex flex-column align-items-center rounded-3">
                                            <img src="<?= pathImage($row["profile_image"]); ?>" id="profile_image_preview<?= $user["user_id"] ?>" width="300px" height="300px" class="rounded-circle pointer border" style="object-fit:cover" onclick="document.getElementById('profile<?= $user['user_id'] ?>').click()">
                                            <div class="d-flex align-items-center my-3" style="gap:10px">
                                                <label for="profile<?= $user['user_id'] ?>" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                                                <button id="trash-can<?= $user['user_id'] ?>" type="button" class="btn btn-danger d-none" onclick="$('#profile_image_preview<?= $user['user_id'] ?>').attr('src','<?= pathImage($row['profile_image']); ?>');$('#profile<?= $user['user_id'] ?>').val('');$(this).addClass('d-none');">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-12" style="position: relative;">
                                        <div class="form-floating">
                                            <input type="text" class="form-control rounded-3" name="firstname" placeholder="Firstname" required value="<?= $user["firstname"] ?>">
                                            <label for="firstname">ชื่อ</label>
                                        </div>
                                        <div class="form-floating mt-4">
                                            <input type="text" class="form-control rounded-3" name="lastname" placeholder="Lastname" required value="<?= $user["lastname"] ?>">
                                            <label for="lastname">นามสกุล</label>
                                        </div>
                                        <div class="form-floating mt-4">
                                            <textarea class="form-control rounded-3" name="address" placeholder="address" style="min-height: 100px;" required><?= $user["address"] ?></textarea>
                                            <label for="address">ที่อยู่</label>
                                        </div>
                                        <div class="form-floating mt-4">
                                            <input type="number" class="form-control rounded-3" name="tel" placeholder="0xxxxxxxx" required value="<?= $user["tel"] ?>">
                                            <label for="tel">เบอร์โทรศัพท์</label>
                                        </div>
                                        <div class="form-floating mt-4">
                                            <input type="email" class="form-control rounded-3" name="email" placeholder="name@example.com" required value="<?= $user["email"] ?>">
                                            <label for="email">อีเมล</label>
                                        </div>
                                        <div class="form-floating mt-4">
                                            <input type="password" class="form-control rounded-3" name="password" placeholder="password" oninput="handleInputChange($(this))">
                                            <label for="password">เปลี่ยนรหัสผ่านใหม่</label>
                                        </div>
                                        <div data-text-validate="text-validate-password" class="d-flex justify-content-end position-absolute text-danger" style="right: 15px;opacity: 0;bottom: 58px;font-size: 14px;">
                                            รหัสผ่านไม่ตรงกัน
                                        </div>
                                        <div class="form-floating mt-4">
                                            <input type="password" class="form-control rounded-3" name="c_password" placeholder="confirm password" oninput="handleInputChange($(this))">
                                            <label for="password">ยืนยันรหัสผ่านใหม่อีกครั้ง</label>
                                        </div>
                                        <input name="profile" id="profile<?= $user["user_id"] ?>" type="file" onchange="$('#profile_image_preview<?= $user['user_id'] ?>').attr('src',window.URL.createObjectURL($(this)[0].files[0]));$('#trash-can<?= $user['user_id'] ?>').removeClass('d-none')" hidden>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                                    <button type="reset" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" name="save-editUser" class="btn btn-cyan w-100">บันทึก</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="modal fade" id="delete_user<?= $user["user_id"] ?>">
                    <div class="modal-dialog modal-dialog-centered modal-md">
                        <form action="../api/manage_user-admin.php?delete&user_id=<?= $user["user_id"] ?>" method="POST" class="modal-content m-0">
                            <div class="modal-header">
                                <h3 class="modal-title d-flex align-items-center" style="gap:10px"><i class="fa-solid fa-trash"></i> ลบบัญชีของคุณ <?= $user["firstname"] . " " . $user["lastname"] ?></h3>
                                <button type="reset" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <h4 class="text-center mb-3">คุณแน่ใจที่จะทำการลบบัญชีนี้ใช่หรือไม่?</h4>
                                <div class="d-flex justify-content-center">
                                    <img src="<?= pathImage($user["profile_image"], "user_images"); ?>" width="200px" height="200px" class="border rounded-circle object-fit-cover">
                                </div>
                                <h6 class="mt-3 fs-5">ชื่อ-นามสกุล: <?= $user["firstname"] . " " . $user["lastname"] ?></h6>
                                <h6 class="mt-3 fs-5">อีเมล: <?= $user["email"]; ?></h6>
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex align-items-center flex-row w-100" style="gap: 10px;">
                                    <button type="reset" class="btn btn-secondary w-100" data-bs-dismiss="modal">ปิด</button>
                                    <button type="submit" name="delete_user" class="btn btn-danger w-100">ยืนยันการลบ</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php } ?>
        </div>
    <?php } ?>
</div>

<script>
    const updateClass = (element, addClass, removeClass) => {
        element.addClass(addClass).removeClass(removeClass);
    }
    const checkPasswordMatch = (input) => {
        const textValidPassword = $(input).closest("form").find("[data-text-validate='text-validate-password']");
        const password = $(input).closest("form").find("[name=password]");
        const confirmPassword = $(input).closest("form").find("[name=c_password]");

        if (password.val() === confirmPassword.val()) {
            updateClass(password, "border-success", "border-danger");
            updateClass(confirmPassword, "border-success", "border-danger");
            textValidPassword.css("opacity", 0);
        } else {
            textValidPassword.css("opacity", 1);
            updateClass(password, "border-danger", "border-success");
            updateClass(confirmPassword, "border-danger", "border-success");
        }
    }
    const handleInputChange = (input) => {
        const textValidPassword = $(input).closest("form").find("[data-text-validate='text-validate-password']");
        const password = $(input).closest("form").find("[name=password]");
        const confirmPassword = $(input).closest("form").find("[name=c_password]");
        if (confirmPassword.val() !== "") {
            checkPasswordMatch(input);
        } else {
            confirmPassword.removeClass("border-danger border-success");
        }
        if ((password.val() === "") || (confirmPassword.val() === "")) {
            password.removeClass("border-danger border-success");
            confirmPassword.removeClass("border-danger border-success");
            textValidPassword.css("opacity", 0);
        }
    }
</script>