<form action="../api/manage_user-admin.php?edit&user_id=<?= $row["user_id"] ?>" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="d-flex align-items-center justify-content-between">
        <h1>การจัดการบัญชีของฉัน</h1>
        <div>
            <button type="reset" class="btn btn-secondary fs-5">ยกเลิก</button>
            <button type="submit" name="saveChange-account" class="btn btn-cyan fs-5"><i class="fa-solid fa-floppy-disk"></i> บันทึก</button>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-4">
            <div class="d-flex flex-column align-items-center py-3 rounded-3">
                <img src="<?= pathImage($row["profile_image"]); ?>" id="profile_image_preview" width="300px" height="300px" class="rounded-circle pointer" style="object-fit:cover" onclick="document.getElementById('profile').click()">
                <div class="d-flex align-items-center mt-3" style="gap:10px">
                    <label for="profile" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                    <button id="trash-can" type="button" class="btn btn-danger d-none" onclick="document.getElementById('profile_image_preview').src = '<?= pathImage($row['profile_image']); ?>'; document.getElementById('profile').value=''; this.classList.add('d-none')">
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="col-8" style="position: relative;">
            <?php if (isset($_SESSION["user_login"])) { ?>
                <div class="d-flex">
                    <div class="d-flex p-2 px-3 rounded-3 text-white " style="background-color: var(--cyan-color1);">อีเมลของคุณ: <?= $row["email"] ?></div>
                </div>
            <?php } ?>
            <div class="form-floating mt-4">
                <input type="text" class="form-control rounded-3" name="firstname" id="firstname" placeholder="Firstname" required value="<?= $row["firstname"] ?>">
                <label for="firstname">ชื่อ</label>
            </div>
            <div class="form-floating mt-4">
                <input type="text" class="form-control rounded-3" name="lastname" id="lastname" placeholder="Lastname" required value="<?= $row["lastname"] ?>">
                <label for="lastname">นามสกุล</label>
            </div>
            <?php
            if (isset($_SESSION["user_login"])) { ?>
                <div class="form-floating mt-4">
                    <textarea class="form-control rounded-3" name="address" id="address" placeholder="address" style="min-height: 100px;" required><?= $row["address"] ?></textarea>
                    <label for="address">ที่อยู่</label>
                </div>
                <div class="form-floating mt-4">
                    <input type="number" class="form-control rounded-3" name="tel" id="tel" placeholder="0xxxxxxxx" required value="<?= $row["tel"] ?>">
                    <label for="tel">เบอร์โทรศัพท์</label>
                </div>
            <?php } else { ?>
                <div class="form-floating mt-4">
                    <input type="email" class="form-control rounded-3" name="email" id="email" placeholder="name@example.com" required value="<?= $row["email"] ?>">
                    <label for="email">อีเมล</label>
                </div>
            <?php } ?>

            <div class="form-floating mt-4">
                <input type="password" class="form-control rounded-3" name="old_password" id="old_password" placeholder="Old Password" autocomplete="new-password">
                <label for="old_password">รหัสผ่านเดิม</label>
            </div>
            <div class="form-floating mt-4">
                <input type="password" class="form-control rounded-3" name="password" id="password" placeholder="Password" value="">
                <label for="password">รหัสผ่านใหม่</label>
            </div>
            <div class="d-flex justify-content-end position-absolute text-danger" style="right: 15px;opacity: 0;bottom: 58px;font-size: 14px;" id="text-validate-password">
                รหัสผ่านไม่ตรงกัน
            </div>
            <div class="form-floating mt-4">
                <input type="password" class="form-control rounded-3" name="c_password" id="c_password" placeholder="Confirm Password">
                <label for="c_password">ยืนยันรหัสผ่านใหม่</label>
            </div>
            <input name="profile" id="profile" type="file" onchange="document.getElementById('profile_image_preview').src = window.URL.createObjectURL(this.files[0]);document.getElementById('trash-can').classList.remove('d-none')" hidden>
        </div>
    </div>
</form>

<script>
    function updateClass(element, addClass, removeClass) {
        element.addClass(addClass).removeClass(removeClass);
    }
    const textValidPassword = $("#text-validate-password");
    const checkPasswordMatch = () => {
        const password = $("#password");
        const confirmPassword = $("#c_password");

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
    const handleInputChange = () => {
        const password = $("#password");
        const confirmPassword = $("#c_password");
        if (confirmPassword.val() !== "") {
            checkPasswordMatch();
        } else {
            confirmPassword.removeClass("border-danger border-success");
        }
        if ((password.val() === "") || (confirmPassword.val() === "")) {
            password.removeClass("border-danger border-success");
            confirmPassword.removeClass("border-danger border-success");
            textValidPassword.css("opacity", 0);
        }
    }
    $("#c_password").on("input", handleInputChange);
    $("#password").on("input", handleInputChange);
</script>