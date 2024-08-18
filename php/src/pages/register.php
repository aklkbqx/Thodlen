<?php
session_start();
require_once __DIR__ . "/../lib/util.php";
isset($_SESSION["user_login"]) ? header("location: ../") : (isset($_SESSION["admin_login"]) ? header("location: ../") : null);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REGISTER</title>
    <?php require_once __DIR__ . "/../lib/link.php"; ?>
</head>

<body>
    <?php require_once __DIR__ . "/../components/navbar.php"; ?>
    <div class="w-100 d-flex justify-content-center min-width-container" style="margin-block: 3rem;">
        <div class="border bg-white rounded-3 shadow-sm p-4" style="width:1200px">
            <div class="d-flex justify-content-start">
                <a href="javascript:window.history.back()" class="d-flex align-items-center text-cyan" style="gap:10px">
                    <i class="fa-solid fa-left-long"></i>
                    <h5>กลับ</h5>
                </a>
            </div>
            <h1 class="text-center">สมัครสมาชิก</h1>
            <form action="../api/manage_user-admin.php?register" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="row">
                    <div class="col-8" style="position: relative;">
                        <div class="form-floating mt-4">
                            <input type="text" class="form-control rounded-3" name="firstname" id="firstname" placeholder="Firstname" required>
                            <label for="firstname">ชื่อ</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="text" class="form-control rounded-3" name="lastname" id="lastname" placeholder="Lastname" required>
                            <label for="lastname">นามสกุล</label>
                        </div>
                        <div class="form-floating mt-4">
                            <textarea class="form-control rounded-3" name="address" id="address" placeholder="address" style="min-height: 100px;" required></textarea>
                            <label for="address">ที่อยู่</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="number" maxlength="10" class="form-control rounded-3" name="tel" id="tel" placeholder="0xxxxxxxx" required>
                            <label for="tel">เบอร์โทรศัพท์</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="email" class="form-control rounded-3" name="email" id="email" placeholder="name@example.com" required autocomplete="email">
                            <label for="email">อีเมล</label>
                        </div>
                        <div class="form-floating mt-4">
                            <input type="password" class="form-control rounded-3" name="password" id="password" placeholder="Password" required autocomplete="new-password">
                            <label for="password">รหัสผ่าน</label>
                        </div>
                        <div class="d-flex justify-content-end position-absolute text-danger" style="right: 15px;opacity:0;bottom: 60px;font-size: 14px;" id="text-validate-password">
                            รหัสผ่านไม่ตรงกัน
                        </div>
                        <div class="form-floating mt-4">
                            <input type="password" class="form-control rounded-3" name="c_password" id="c_password" placeholder="Confirm Password" required autocomplete="new-password">
                            <label for="c_password">ยืนยันรหัสผ่าน</label>
                        </div>
                        <input name="profile" id="profile" type="file" onchange="document.getElementById('profile_image_preview').src = window.URL.createObjectURL(this.files[0]);document.getElementById('trash-can').classList.remove('d-none')" hidden>
                    </div>
                    <div class="col-4">
                        <div class="d-flex flex-column align-items-center py-3 rounded-3">
                            <img src="../assets/images/user_images/default-profile.jpg" id="profile_image_preview" width="300px" height="300px" class="rounded-circle border pointer" style="object-fit:cover" onclick="document.getElementById('profile').click()">
                            <div class="d-flex align-items-center mt-3" style="gap:10px">
                                <label for="profile" class="btn btn-cyan"><i class="fa-solid fa-image"></i> เปลี่ยนรูปภาพ</label>
                                <button id="trash-can" type="button" class="btn btn-danger d-none" onclick="document.getElementById('profile_image_preview').src = '../assets/images/user_images/default-profile.jpg';document.getElementById('profile').value=''; this.classList.add('d-none')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="mt-4 btn btn-cyan w-100 fs-4 rounded-3" type="submit" name="register_submit">ลงทะเบียน</button>
            </form>
            <div class="d-flex justify-content-center flex-column align-items-center mt-3 fs-5">
                <div>ฉันมีบัญชีอยู่แล้ว!</div>
                <div><a href="<?= linkPage("login.php"); ?>" class="text-cyan">เข้าสู่ระบบ</a></div>
            </div>
        </div>
    </div>
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
    <?php require_once __DIR__ . "/../components/footer.php"; ?>
</body>

</html>