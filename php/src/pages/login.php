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
    <title>LOGIN</title>
    <?php require_once __DIR__ . "/../lib/link.php"; ?>
</head>

<body>
    <?php require_once __DIR__ . "/../components/navbar.php"; ?>
    <div class="w-100 d-flex justify-content-center min-width-container" style="margin-block: 7rem;">
        <div class="border bg-white rounded-3 shadow-sm p-4" style="width:600px">
            <div class="d-flex justify-content-start">
                <a href="javascript:window.history.back()" class="d-flex align-items-center text-cyan" style="gap:10px">
                    <i class="fa-solid fa-left-long"></i>
                    <h5>กลับ</h5>
                </a>
            </div>
            <h1 class="text-center">เข้าสู่ระบบ</h1>
            <form action="../api/manage_user-admin.php?login" method="POST" autocomplete="off">
                <div class="form-floating mt-4">
                    <input type="email" class="form-control rounded-3" name="email" id="email" placeholder="name@example.com" required autocomplete="email">
                    <label for="email">อีเมล</label>
                </div>
                <div class="form-floating mt-4">
                    <input type="password" class="form-control rounded-3" name="password" id="password" placeholder="xxx" required autocomplete="new-password">
                    <label for="password">รหัสผ่าน</label>
                </div>
                <button class="mt-4 btn btn-cyan w-100 fs-4 rounded-3" type="submit" name="login_submit">เข้าสู่ระบบ</button>
            </form>
            <div class="d-flex justify-content-center flex-column align-items-center mt-3 fs-5">
                <div>ยังไม่มีบัญชีใช่หรือใหม่?</div>
                <div>
                    <a href="<?= linkPage("register.php") ?>" class="text-cyan">สมัครสมาชิก</a>
                </div>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . "/../components/footer.php"; ?>
</body>

</html>